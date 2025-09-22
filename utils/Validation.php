<?php
require_once __DIR__ . '/../config/constants.php';

class Validation {
    // Check required fields in an associative array
    public static function validateRequired($data, $fields) {
        $errors = [];
        foreach ($fields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                $errors[$field] = "$field is required";
            }
        }
        return $errors;
    }

    // Validate email format
    public static function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
