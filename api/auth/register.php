<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../models/User.php';
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
        'last_name' => $_POST['last_name'] ?? '',
        'title' => $_POST['title'] ?? '',
        'specialization' => ($_POST['role'] === 'doctor') ? ($_POST['specialization'] ?? '') : ''
    ];

    // Handle profile picture upload
    $profile_picture_path = '';
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
    $input['profile_picture'] = $profile_picture_path;

    $required_fields = ['username', 'password', 'email', 'role', 'first_name', 'last_name'];
    $errors = Validation::validateRequired($input, $required_fields);

    if (!empty($errors)) {
        $error = 'Missing required fields: ' . implode(', ', array_keys($errors));
    } elseif (!Validation::isValidEmail($input['email'])) {
        $error = 'Invalid email address.';
    } else {
        $allowed_roles = ['patient', 'doctor', 'nurse', 'pharmacist', 'receptionist', 'admin'];
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
                        header('Location: ../../index.php?registered=success');
                        exit();
                    } else {
                        $error = 'Failed to create user.';
                    }
                }
            }
        }
    }
}
?>
<?php if (!empty($error)): ?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration Error</title>
    <meta charset="UTF-8">
</head>
<body>
    <div style="margin:2em auto;max-width:400px;padding:2em;border:1px solid #ccc;border-radius:8px;">
        <h2>Registration Error</h2>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <a href="../../index.php" style="display:inline-block;margin-top:1em;">Back to Registration</a>
    </div>
</body>
</html>
<?php endif; ?>