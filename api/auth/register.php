<?php
require_once '../../models/User.php';
require_once '../../utils/Validation.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = [
        'username' => $_POST['username'] ?? '',
        'password' => $_POST['password'] ?? '',
        'email' => $_POST['email'] ?? '',
        'role' => $_POST['role'] ?? '',
        'first_name' => $_POST['first_name'] ?? '',
        'last_name' => $_POST['last_name'] ?? ''
    ];

    $required_fields = ['username', 'password', 'email', 'role', 'first_name', 'last_name'];
    $errors = Validation::validateRequired($input, $required_fields);

    if (!empty($errors)) {
        $error = 'Missing required fields: ' . implode(', ', array_keys($errors));
    } elseif (!Validation::isValidEmail($input['email'])) {
        $error = 'Invalid email address.';
    } else {
        $allowed_roles = ['patient', 'doctor', 'nurse', 'pharmacist', 'admin'];
        if (!in_array($input['role'], $allowed_roles)) {
            $error = 'Invalid role.';
        } else {
            $user = new User();
            if ($user->getByUsername($input['username'])) {
                $error = 'Username already exists.';
            } else {
                $db = new Database();
                $existing_email = $db->fetch("SELECT id FROM users WHERE email = :email", [':email' => $input['email']]);
                if ($existing_email) {
                    $error = 'Email already exists.';
                } else {
                    if ($user->create($input)) {
                        $success = 'User registered successfully! You can now <a href=\'login.php\'>login</a>.';
                    } else {
                        $error = 'Failed to create user.';
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/MESMTF/styles.css">
</head>
<body>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MESMTF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">
                <i class="fas fa-laptop-medical me-2"></i>MESMTF
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../diagnosis.php">Diagnosis</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card">
            <div class="card-header text-white" style="background-color: var(--primary);">
                <h5 class="mb-0">Register for MESMTF</h5>
            </div>
            <div class="card-body">
                <?php if ($success): ?>
                    <div class="alert alert-success"> <?= $success ?> </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"> <?= $error ?> </div>
                <?php endif; ?>
                <form method="POST" action="register.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Register As</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                            <option value="nurse">Nurse</option>
                            <option value="pharmacist">Pharmacist</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>