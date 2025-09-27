<?php
session_start();
header('Content-Type: application/json');

// Allow admin and receptionist to update appointments
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

    if (!isset($input['appointment_id']) || !isset($input['patient_id']) || !isset($input['doctor_id']) || !isset($input['appointment_datetime'])) {
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    $status = isset($input['status']) && in_array($input['status'], ['scheduled','completed','cancelled'])
        ? $input['status']
        : 'scheduled';

    $sql = "UPDATE appointments 
            SET patient_id = ?, doctor_id = ?, appointment_datetime = ?, status = ?, notes = ?
            WHERE appointment_id = ?";

    $stmt = $pdo->prepare($sql);
    $ok = $stmt->execute([
        $input['patient_id'],
        $input['doctor_id'],
        $input['appointment_datetime'],
        $status,
        isset($input['notes']) ? $input['notes'] : '',
        $input['appointment_id']
    ]);

    echo json_encode(['success' => (bool)$ok]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to update appointment: ' . $e->getMessage()]);
}
?>


