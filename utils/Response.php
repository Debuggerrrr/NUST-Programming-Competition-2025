<?php
require_once __DIR__ . '/../config/constants.php';

class Response {
    public static function json($data, $status_code = HTTP_OK) {
        http_response_code($status_code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success($message, $data = [], $status_code = HTTP_OK) {
        self::json([
            'status' => STATUS_SUCCESS,
            'message' => $message,
            'data' => $data
        ], $status_code);
    }

    public static function error($message, $status_code = HTTP_BAD_REQUEST, $errors = []) {
        self::json([
            'status' => STATUS_ERROR,
            'message' => $message,
            'errors' => $errors
        ], $status_code);
    }
}
?>