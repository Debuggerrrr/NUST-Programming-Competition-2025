<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

try {
    $search = $_GET['search'] ?? '';
    $roleFilter = $_GET['role'] ?? '';
    
    $query = "
        SELECT u.user_id, u.username, u.email, u.role, u.is_active, u.created_at,
               COALESCE(p.first_name, d.first_name, n.first_name, ph.first_name, r.first_name, a.first_name) as first_name,
               COALESCE(p.last_name, d.last_name, n.last_name, ph.last_name, r.last_name, a.last_name) as last_name,
               COALESCE(d.specialization, n.department, ph.pharmacy_location) as details
        FROM users u
        LEFT JOIN patients p ON u.user_id = p.user_id AND u.role = 'patient'
        LEFT JOIN doctors d ON u.user_id = d.user_id AND u.role = 'doctor'
        LEFT JOIN nurses n ON u.user_id = n.user_id AND u.role = 'nurse'
        LEFT JOIN pharmacists ph ON u.user_id = ph.user_id AND u.role = 'pharmacist'
        LEFT JOIN receptionists r ON u.user_id = r.user_id AND u.role = 'receptionist'
        LEFT JOIN admins a ON u.user_id = a.user_id AND u.role = 'admin'
        WHERE 1=1
    ";
    
    $params = [];
    
    if (!empty($roleFilter)) {
        $query .= " AND u.role = ?";
        $params[] = $roleFilter;
    }
    
    if (!empty($search)) {
        $query .= " AND (u.username LIKE ? OR u.email LIKE ? OR 
                         p.first_name LIKE ? OR p.last_name LIKE ? OR
                         d.first_name LIKE ? OR d.last_name LIKE ?)";
        $searchTerm = "%$search%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
    }
    
    $query .= " ORDER BY u.created_at DESC";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'users' => $users]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>