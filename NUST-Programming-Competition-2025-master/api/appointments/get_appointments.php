<?php
session_start();
header('Content-Type: application/json');

// Check if user is logged in and has appropriate role
if (!isset($_SESSION['id']) || !in_array($_SESSION['role'], ['admin', 'receptionist'])) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

require_once '../../config/database.php';

try {
    // Fetch appointments with patient and doctor information (align with init.sql schema)
    $sql = "SELECT 
                a.appointment_id,
                a.appointment_datetime,
                a.status,
                a.notes,
                CONCAT(pat.first_name, ' ', pat.last_name) AS patient_name,
                CONCAT(doc.first_name, ' ', doc.last_name) AS doctor_name,
                doc.specialization
            FROM appointments a
            LEFT JOIN patients pat ON a.patient_id = pat.patient_id
            LEFT JOIN doctors doc ON a.doctor_id = doc.doctor_id
            ORDER BY a.appointment_datetime DESC";
    
    $stmt = $pdo->query($sql);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'appointments' => $appointments]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch appointments: ' . $e->getMessage()]);
}
?>
