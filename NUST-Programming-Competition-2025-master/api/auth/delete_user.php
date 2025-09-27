<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User ID required']);
    exit;
}

try {
    $db = Database::getConnection();
    
    // This will cascade delete from role-specific tables due to foreign key constraints
    $stmt = $db->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$input['user_id']]);
    
    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>