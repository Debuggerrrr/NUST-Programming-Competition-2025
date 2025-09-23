
<?php
// Start session and set response type
session_start();
header('Content-Type: application/json');

// Check authentication
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit();
}

// Include required models
require_once '../../models/User.php';
require_once '../../models/Database.php';

// Get current user from DB
$user = new User();
$user->getById($_SESSION['user_id']);

// Get updated fields from POST or fallback to current values
$username = $_POST['username'] ?? $user->username;
$first_name = $_POST['first_name'] ?? $user->first_name;
$last_name = $_POST['last_name'] ?? $user->last_name;
$email = $_POST['email'] ?? $user->email;
$title = $_POST['title'] ?? $user->title;
$specialization = ($user->role === 'doctor') ? ($_POST['specialization'] ?? $user->specialization) : '';
$password = $_POST['password'] ?? '';

// Handle profile picture upload
$profile_picture_path = $user->profile_picture;
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../../images/profiles/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $file_name = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
    $target_file = $upload_dir . $file_name;
    if (move_uploaded_file($file_tmp, $target_file)) {
        $profile_picture_path = 'images/profiles/' . $file_name;
    }
}

// Prepare SQL update parameters
$params = [
    ':id' => $user->id,
    ':username' => $username,
    ':first_name' => $first_name,
    ':last_name' => $last_name,
    ':email' => $email,
    ':title' => $title,
    ':specialization' => $specialization,
    ':profile_picture' => $profile_picture_path
];
$set_password = '';
if (!empty($password)) {
    $set_password = ', password_hash = :password_hash';
    $params[':password_hash'] = password_hash($password, PASSWORD_DEFAULT);
}

// Update user in DB
$db = new Database();
$sql = "UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, email = :email, title = :title, specialization = :specialization, profile_picture = :profile_picture $set_password WHERE id = :id";
try {
    $db->query($sql, $params);
    // Update session with new values
    $_SESSION['username'] = $username;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['title'] = $title;
    $_SESSION['specialization'] = $specialization;
    $_SESSION['profile_picture'] = $profile_picture_path;
    // Return success JSON
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Return error JSON
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
