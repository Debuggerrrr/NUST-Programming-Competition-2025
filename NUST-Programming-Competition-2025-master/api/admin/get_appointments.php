<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

try {
    $filter = $_GET['filter'] ?? 'all';
    $search = $_GET['search'] ?? '';
    
    $query = "
        SELECT a.*, p.first_name, p.last_name, 
               d.first_name as doctor_first_name, d.last_name as doctor_last_name
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        JOIN doctors d ON a.doctor_id = d.doctor_id
    ";
    
    $params = [];
    
    // Apply filters
    switch ($filter) {
        case 'today':
            $query .= " WHERE DATE(a.appointment_datetime) = CURDATE()";
            break;
        case 'upcoming':
            $query .= " WHERE a.appointment_datetime >= NOW()";
            break;
        case 'completed':
            $query .= " WHERE a.status = 'completed'";
            break;
        default:
            // All appointments
            break;
    }
    
    // Apply search
    if (!empty($search)) {
        $query .= (strpos($query, 'WHERE') !== false ? " AND" : " WHERE");
        $query .= " (p.first_name LIKE ? OR p.last_name LIKE ? OR d.first_name LIKE ? OR d.last_name LIKE ?)";
        $searchTerm = "%$search%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }
    
    $query .= " ORDER BY a.appointment_datetime DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'appointments' => $appointments]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>