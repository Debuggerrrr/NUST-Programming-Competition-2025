<?php
/**
 * Unified Profile Management API
 * Handles profile data for all user roles with the new schema
 */

session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

require_once '../../config/database.php';

$userId = $_SESSION['id'];
$userRole = $_SESSION['role'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Get user profile data
        $profileData = getUserProfileData($pdo, $userId, $userRole);
        echo json_encode(['success' => true, 'profile' => $profileData]);
        
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Update user profile data
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (updateUserProfile($pdo, $userId, $userRole, $input)) {
            echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update profile']);
        }
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

function getUserProfileData($pdo, $userId, $role) {
    // Get basic user data
    $stmt = $pdo->prepare("SELECT username, email, role, created_at FROM users WHERE user_id = ?");
    $stmt->execute([$userId]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get role-specific data
    $roleData = getRoleSpecificData($pdo, $userId, $role);
    
    return array_merge($userData, $roleData);
}

function getRoleSpecificData($pdo, $userId, $role) {
    $tableName = $role . 's';
    $idColumn = $role . '_id';
    
    $stmt = $pdo->prepare("SELECT * FROM {$tableName} WHERE user_id = ?");
    $stmt->execute([$userId]);
    $roleData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $roleData ?: [];
}

function updateUserProfile($pdo, $userId, $role, $data) {
    $pdo->beginTransaction();
    
    try {
        // Update basic user data
        if (isset($data['email'])) {
            $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE user_id = ?");
            $stmt->execute([$data['email'], $userId]);
        }
        
        // Update role-specific data
        $tableName = $role . 's';
        $updateFields = [];
        $updateValues = [];
        
        // Define allowed fields for each role
        $allowedFields = getAllowedFields($role);
        
        foreach ($data as $field => $value) {
            if (in_array($field, $allowedFields)) {
                $updateFields[] = "{$field} = ?";
                $updateValues[] = $value;
            }
        }
        
        if (!empty($updateFields)) {
            $updateValues[] = $userId;
            $sql = "UPDATE {$tableName} SET " . implode(', ', $updateFields) . " WHERE user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($updateValues);
        }
        
        $pdo->commit();
        return true;
        
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

function getAllowedFields($role) {
    $fields = [
        'patient' => ['first_name', 'last_name', 'title', 'date_of_birth', 'gender', 'address', 'phone', 'emergency_contact', 'emergency_contact_name', 'profile_picture', 'medical_history', 'allergies'],
        'doctor' => ['first_name', 'last_name', 'title', 'specialization', 'license_number', 'phone', 'office_location', 'profile_picture', 'bio', 'consultation_fee'],
        'nurse' => ['first_name', 'last_name', 'title', 'department', 'license_number', 'phone', 'profile_picture', 'shift_schedule'],
        'pharmacist' => ['first_name', 'last_name', 'title', 'license_number', 'phone', 'pharmacy_location', 'profile_picture', 'specialization'],
        'receptionist' => ['first_name', 'last_name', 'title', 'phone', 'profile_picture', 'shift_schedule'],
        'admin' => ['first_name', 'last_name', 'title', 'phone', 'profile_picture', 'admin_level']
    ];
    
    return $fields[$role] ?? [];
}
?>
