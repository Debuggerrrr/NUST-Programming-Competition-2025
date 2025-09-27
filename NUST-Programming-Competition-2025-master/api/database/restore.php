<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isset($_FILES['backupFile']) || $_FILES['backupFile']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'No backup file uploaded']);
    exit;
}

require_once '../../config/database.php';

$tmpPath = $_FILES['backupFile']['tmp_name'];

// Attempt restore using mysql client
$cmd = "mysql --user={$user} --password={$pass} --host={$host} {$dbname} < \"{$tmpPath}\"";

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $result = pclose(popen('start /B cmd /C "' . $cmd . '"', 'r'));
} else {
    $result = shell_exec($cmd);
}

echo json_encode(['success' => true]);
?>


