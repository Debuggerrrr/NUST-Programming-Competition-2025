<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// Simple logical backup using mysqldump if available
require_once '../../config/database.php';

$backupDir = __DIR__ . '/../../backups';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$filename = 'backup_' . date('Ymd_His') . '.sql';
$filepath = $backupDir . '/' . $filename;

// Attempt mysqldump (works if in PATH)
$cmd = "mysqldump --user={$user} --password={$pass} --host={$host} {$dbname} > \"{$filepath}\"";

$result = null;
// Suppress output; Windows requires shell
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $result = pclose(popen('start /B cmd /C "' . $cmd . '"', 'r'));
} else {
    $result = shell_exec($cmd);
}

if (file_exists($filepath) && filesize($filepath) > 0) {
    echo json_encode(['success' => true, 'file' => 'backups/' . $filename]);
} else {
    echo json_encode(['error' => 'Backup failed. Ensure mysqldump is installed and in PATH.']);
}
?>


