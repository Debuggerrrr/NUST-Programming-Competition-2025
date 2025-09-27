<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['user_id'], $input['username'], $input['email'], $input['role'], $input['first_name'], $input['last_name'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

try {
    $db = Database::getConnection();
    $db->beginTransaction();

    // Update users table
    $updateFields = "username = ?, email = ?, role = ?, is_active = ?";
    $params = [$input['username'], $input['email'], $input['role'], $input['is_active'] ?? true];
    
    if (!empty($input['password'])) {
        $updateFields .= ", password_hash = ?";
        $params[] = password_hash($input['password'], PASSWORD_DEFAULT);
    }
    
    $params[] = $input['user_id'];
    
    $stmt = $db->prepare("UPDATE users SET {$updateFields} WHERE user_id = ?");
    $stmt->execute($params);
    
    // Update role-specific table
    $title = $input['title'] ?? '';
    switch ($input['role']) {
        case 'patient':
            $stmt = $db->prepare("
                UPDATE patients SET first_name = ?, last_name = ?, title = ?, date_of_birth = ?, 
                gender = ?, address = ?, phone = ? WHERE user_id = ?
            ");
            $stmt->execute([
                $input['first_name'], $input['last_name'], $title,
                $input['date_of_birth'] ?? null, $input['gender'] ?? null,
                $input['address'] ?? '', $input['phone'] ?? '', $input['user_id']
            ]);
            break;
            
        case 'doctor':
            $stmt = $db->prepare("
                UPDATE doctors SET first_name = ?, last_name = ?, title = ?, specialization = ?, 
                license_number = ?, phone = ? WHERE user_id = ?
            ");
            $stmt->execute([
                $input['first_name'], $input['last_name'], $title,
                $input['specialization'] ?? '', $input['license_number'] ?? '',
                $input['phone'] ?? '', $input['user_id']
            ]);
            break;
            
        // Add other roles similarly...
    }
    
    $db->commit();
    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    $db->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>