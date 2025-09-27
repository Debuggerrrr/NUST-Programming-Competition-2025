<?php
require_once __DIR__ . '/../config/constants.php';

class Auth {
    // Check if user is logged in
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Require login for protected pages
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: /MESMTF/api/auth/login.php');
            exit();
        }
    }

    // Log in user (called after verifying credentials)
    public static function login($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['role'] = $user->role;
    }

    // Log out user
    public static function logout() {
        session_unset();
        session_destroy();
    }

    // Require a specific role
    public static function requireRole(array $allowedRoles) {
        if (!self::isLoggedIn() || !in_array($_SESSION['role'], $allowedRoles)) {
            header('Location: /api/auth/login.php');
            exit();
        }
    }
}
?>
