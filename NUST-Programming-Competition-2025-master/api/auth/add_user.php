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
    $db = Database::getConnection();
    $db->beginTransaction();

    // Insert into users table
    $password_hash = password_hash($input['password'], PASSWORD_DEFAULT);
    $stmt = $db->prepare("
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
    
    $user_id = $db->lastInsertId();
    
    // Insert into role-specific table
    $title = $input['title'] ?? '';
    switch ($input['role']) {
        case 'patient':
            $stmt = $db->prepare("
                INSERT INTO patients (user_id, first_name, last_name, title, date_of_birth, gender, address, phone)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id, $input['first_name'], $input['last_name'], $title,
                $input['date_of_birth'] ?? null, $input['gender'] ?? null,
                $input['address'] ?? '', $input['phone'] ?? ''
            ]);
            break;
            
        case 'doctor':
            $stmt = $db->prepare("
                INSERT INTO doctors (user_id, first_name, last_name, title, specialization, license_number, phone)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id, $input['first_name'], $input['last_name'], $title,
                $input['specialization'] ?? '', $input['license_number'] ?? '',
                $input['phone'] ?? ''
            ]);
            break;
            
        case 'nurse':
            $stmt = $db->prepare("
                INSERT INTO nurses (user_id, first_name, last_name, title, department, license_number, phone)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id, $input['first_name'], $input['last_name'], $title,
                $input['department'] ?? '', $input['license_number'] ?? '',
                $input['phone'] ?? ''
            ]);
            break;
            
        case 'pharmacist':
            $stmt = $db->prepare("
                INSERT INTO pharmacists (user_id, first_name, last_name, title, license_number, phone, pharmacy_location)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id, $input['first_name'], $input['last_name'], $title,
                $input['license_number'] ?? '', $input['phone'] ?? '',
                $input['pharmacy_location'] ?? ''
            ]);
            break;
            
        case 'receptionist':
            $stmt = $db->prepare("
                INSERT INTO receptionists (user_id, first_name, last_name, title, phone, shift_schedule)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id, $input['first_name'], $input['last_name'], $title,
                $input['phone'] ?? '', $input['shift_schedule'] ?? ''
            ]);
            break;
            
        case 'admin':
            $stmt = $db->prepare("
                INSERT INTO admins (user_id, first_name, last_name, title, phone, admin_level)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id, $input['first_name'], $input['last_name'], $title,
                $input['phone'] ?? '', $input['admin_level'] ?? 'standard'
            ]);
            break;
    }
    
    $db->commit();
    echo json_encode(['success' => true, 'user_id' => $user_id]);
    
} catch (Exception $e) {
    $db->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>