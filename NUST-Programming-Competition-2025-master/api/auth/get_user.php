<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

try {
    $db = Database::getConnection();
    
    $stmt = $db->query("
        SELECT u.user_id, u.username, u.email, u.role, u.is_active, u.created_at,
               COALESCE(p.first_name, d.first_name, n.first_name, ph.first_name, r.first_name, a.first_name) as first_name,
               COALESCE(p.last_name, d.last_name, n.last_name, ph.last_name, r.last_name, a.last_name) as last_name,
               COALESCE(p.title, d.title, n.title, ph.title, r.title, a.title) as title,
               d.specialization, n.department, ph.pharmacy_location, r.shift_schedule, a.admin_level
        FROM users u
        LEFT JOIN patients p ON u.user_id = p.user_id AND u.role = 'patient'
        LEFT JOIN doctors d ON u.user_id = d.user_id AND u.role = 'doctor'
        LEFT JOIN nurses n ON u.user_id = n.user_id AND u.role = 'nurse'
        LEFT JOIN pharmacists ph ON u.user_id = ph.user_id AND u.role = 'pharmacist'
        LEFT JOIN receptionists r ON u.user_id = r.user_id AND u.role = 'receptionist'
        LEFT JOIN admins a ON u.user_id = a.user_id AND u.role = 'admin'
        ORDER BY u.created_at DESC
    ");
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'data' => $users]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>