<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$uid = (int) $_SESSION['id'];
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$title = trim($_POST['title'] ?? '');
$password = $_POST['password'] ?? '';

// basic validation
if ($username === '' || $email === '') {
    echo json_encode(['success' => false, 'message' => 'Username and email are required.']);
    exit;
}

// ensure username not used by another user
$stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? AND id != ? LIMIT 1');
$stmt->execute([$username, $uid]);
if ($stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Username already taken.']);
    exit;
}

// handle profile picture upload (which is optional)
$profile_picture_path = null;
if (!empty($_FILES['profile_picture']['name']) && $_FILES['profile_picture']['error'] !== UPLOAD_ERR_NO_FILE) {
    $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];
    $finfoType = mime_content_type($_FILES['profile_picture']['tmp_name']);
    if (!isset($allowedTypes[$finfoType])) {
        echo json_encode(['success' => false, 'message' => 'Invalid image type.']);
        exit;
    }

    $ext = $allowedTypes[$finfoType];
    $newName = 'user_' . $uid . '_' . time() . '.' . $ext;
    $targetDir = __DIR__ . '/../../images/profiles/';
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
    $targetPath = $targetDir . $newName;

    if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetPath)) {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
        exit;
    }
    $profile_picture_path = 'images/profiles/' . $newName;
}

// Build dynamic update
$fields = [];
$params = [];

$fields[] = 'username = ?'; $params[] = $username;
$fields[] = 'email = ?'; $params[] = $email;
$fields[] = 'first_name = ?'; $params[] = $first_name;
$fields[] = 'last_name = ?'; $params[] = $last_name;
$fields[] = 'title = ?'; $params[] = $title;

if ($profile_picture_path) {
    $fields[] = 'profile_picture = ?'; $params[] = $profile_picture_path;
}

if (!empty($password)) {
    $fields[] = 'password = ?'; $params[] = password_hash($password, PASSWORD_DEFAULT);
}

$params[] = $uid;
$sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

// update session data to reflect changes
$_SESSION['username'] = $username;
$_SESSION['first_name'] = $first_name;
if ($profile_picture_path) $_SESSION['profile_picture'] = $profile_picture_path;

echo json_encode(['success' => true, 'message' => 'Profile updated successfully.']);
