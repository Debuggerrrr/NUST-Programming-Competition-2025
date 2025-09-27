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
    // Fetch patients (align with init.sql schema)
    $patients_sql = "SELECT 
                        pat.patient_id,
                        CONCAT(pat.first_name, ' ', pat.last_name) AS name,
                        pat.phone
                     FROM patients pat
                     ORDER BY pat.first_name, pat.last_name";
    
    $patients_stmt = $pdo->query($patients_sql);
    $patients = $patients_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Fetch doctors (align with init.sql schema)
    $doctors_sql = "SELECT 
                       doc.doctor_id,
                       CONCAT(doc.first_name, ' ', doc.last_name) AS name,
                       doc.specialization
                    FROM doctors doc
                    ORDER BY doc.first_name, doc.last_name";
    
    $doctors_stmt = $pdo->query($doctors_sql);
    $doctors = $doctors_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true, 
        'patients' => $patients,
        'doctors' => $doctors
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Failed to fetch data: ' . $e->getMessage()]);
}
?>
