<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Correct file paths
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../utils/Auth.php';

// Logout functionality
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header('Location: ../../index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    $user = new User();
    if ($user->getByUsername($username) && $user->verifyPassword($password)) {
        if (!empty($role) && $role !== $user->role) {
            $error = 'You cannot login as ' . htmlspecialchars($role) . ' with this account.';
        } else {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['role'] = $user->role;
            $_SESSION['first_name'] = $user->first_name;
            $_SESSION['profile_picture'] = $user->profile_picture ?? '';
            // Do not redirect here; let index.php handle it
        }
    } else {
        $error = 'Invalid username or password.';
    }
}
?>