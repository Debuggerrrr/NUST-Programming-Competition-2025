<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['username'], $input['password'], $input['email'], $input['role'], $input['first_name'], $input['last_name'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Insert into users table
    $password_hash = password_hash($input['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT INTO users (username, password_hash, email, role, is_active) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $input['username'],
        $password_hash,
        $input['email'],
        $input['role'],
        $input['is_active'] ?? true
    ]);
    
    $user_id = $pdo->lastInsertId();
    
    // Insert into role-specific table
    switch ($input['role']) {
        case 'patient':
            $stmt = $pdo->prepare("
                INSERT INTO patients (user_id, first_name, last_name, date_of_birth, gender, phone)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id, $input['first_name'], $input['last_name'],
                $input['date_of_birth'] ?? null, $input['gender'] ?? null, $input['phone'] ?? ''
            ]);
            break;
            
        case 'doctor':
            $stmt = $pdo->prepare("
                INSERT INTO doctors (user_id, first_name, last_name, specialization, phone)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id, $input['first_name'], $input['last_name'],
                $input['specialization'] ?? '', $input['phone'] ?? ''
            ]);
            break;
            
        // Add other roles as needed
        default:
            // For other roles, just create basic record
            break;
    }
    
    $pdo->commit();
    echo json_encode(['success' => true, 'user_id' => $user_id]);
    
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>