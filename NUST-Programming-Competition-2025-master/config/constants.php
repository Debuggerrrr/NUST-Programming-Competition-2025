<?php
// JWT Secret Key
define('JWT_SECRET', 'your-secret-key-change-in-production-2025-mesmtf');

// User roles
define('ROLE_PATIENT', 'patient');
define('ROLE_DOCTOR', 'doctor');
define('ROLE_NURSE', 'nurse');
define('ROLE_PHARMACIST', 'pharmacist');
define('ROLE_RECEPTIONIST', 'receptionist');
define('ROLE_ADMIN', 'admin');

// Response codes
define('STATUS_SUCCESS', 'success');
define('STATUS_ERROR', 'error');

// HTTP status codes
define('HTTP_OK', 200);
define('HTTP_CREATED', 201);
define('HTTP_BAD_REQUEST', 400);
define('HTTP_UNAUTHORIZED', 401);
define('HTTP_FORBIDDEN', 403);
define('HTTP_NOT_FOUND', 404);
define('HTTP_SERVER_ERROR', 500);
?>