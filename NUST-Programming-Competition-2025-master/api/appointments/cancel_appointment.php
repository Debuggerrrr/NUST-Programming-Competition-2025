<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id']) || !in_array($_SESSION['role'], ['admin', 'receptionist'])) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

require_once '../../config/database.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['appointment_id'])) {
        echo json_encode(['error' => 'Missing appointment_id']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE appointments SET status = 'cancelled' WHERE appointment_id = ?");
    $ok = $stmt->execute([$input['appointment_id']]);
    echo json_encode(['success' => (bool)$ok]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to cancel appointment: ' . $e->getMessage()]);
}
?>


