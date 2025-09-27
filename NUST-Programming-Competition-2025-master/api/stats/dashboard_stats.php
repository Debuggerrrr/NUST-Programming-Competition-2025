<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id']) || !in_array($_SESSION['role'], ['admin'])) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

require_once '../../config/database.php';

try {
    // Totals
    $totals = [
        'patients' => (int)$pdo->query("SELECT COUNT(*) FROM patients")->fetchColumn(),
        'doctors' => (int)$pdo->query("SELECT COUNT(*) FROM doctors")->fetchColumn(),
        'nurses' => (int)$pdo->query("SELECT COUNT(*) FROM nurses")->fetchColumn(),
        'appointments' => (int)$pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'scheduled'")->fetchColumn()
    ];

    // Registrations per month (last 6 months)
    $registrationSql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, COUNT(*) AS count 
                        FROM users 
                        GROUP BY ym 
                        ORDER BY ym DESC 
                        LIMIT 6";
    $rows = $pdo->query($registrationSql)->fetchAll(PDO::FETCH_ASSOC);
    $rows = array_reverse($rows);

    $labels = array_map(function($r){ return $r['ym']; }, $rows);
    $data = array_map(function($r){ return (int)$r['count']; }, $rows);

    echo json_encode(['success' => true, 'totals' => $totals, 'registrations' => ['labels' => $labels, 'data' => $data]]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to load statistics: ' . $e->getMessage()]);
}
?>


