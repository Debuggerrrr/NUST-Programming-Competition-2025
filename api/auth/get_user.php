<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}
require_once '../../models/User.php';
$user = new User();
$user->getById($_SESSION['user_id']);
echo json_encode([
    'username' => $user->username,
    'first_name' => $user->first_name,
    'last_name' => $user->last_name,
    'email' => $user->email,
    'title' => $user->title,
    'specialization' => $user->specialization,
    'profile_picture' => $user->profile_picture,
    'role' => $user->role
]);
