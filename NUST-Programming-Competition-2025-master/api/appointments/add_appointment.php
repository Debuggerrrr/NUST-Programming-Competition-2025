<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in and has appropriate role
if (!isset($_SESSION['id']) || !in_array($_SESSION['role'], ['admin', 'receptionist'])) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

require_once '../../config/database.php';

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate required fields (notes is optional in schema)
    if (!isset($input['patient_id']) || !isset($input['doctor_id']) || 
        !isset($input['appointment_datetime'])) {
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }
    
    // Insert new appointment
    $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_datetime, status, notes) 
            VALUES (?, ?, ?, 'scheduled', ?)";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $input['patient_id'],
        $input['doctor_id'],
        $input['appointment_datetime'],
        isset($input['notes']) ? $input['notes'] : ''
    ]);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Appointment scheduled successfully']);
    } else {
        echo json_encode(['error' => 'Failed to schedule appointment']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to schedule appointment: ' . $e->getMessage()]);
}
?>
