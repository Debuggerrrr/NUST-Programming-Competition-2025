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
            // Use consistent session variable naming
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['role'] = $user->role;
            $_SESSION['first_name'] = $user->first_name ?? '';
            $_SESSION['profile_picture'] = $user->profile_picture ?? '';
            
            // Handle redirect based on request type
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                // AJAX request - return JSON response
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'role' => $user->role]);
                exit;
            } else {
                // Regular form submission - redirect
                // Use absolute path relative to project root to avoid 404s
                $base = '/NUST-Programming-Competition-2025-master/';
                if ($user->role === 'doctor') {
                    header('Location: ' . $base . 'doc_dashboard.php');
                } elseif ($user->role === 'patient') {
                    header('Location: ' . $base . 'patient_dashboard.php');
                } elseif ($user->role === 'nurse') {
                    header('Location: ' . $base . 'nurse_dashboard.php');
                } elseif ($user->role === 'pharmacist') {
                    header('Location: ' . $base . 'pharmacist_dashboard.php');
                } elseif ($user->role === 'admin' || $user->role === 'receptionist') {
                    header('Location: ' . $base . 'admin_dashboard.php');
                } else {
                    header('Location: ' . $base . 'dashboard.php');
                }
                exit;
            }
        }
    } else {
        $error = 'Invalid username or password.';
    }
}
?>