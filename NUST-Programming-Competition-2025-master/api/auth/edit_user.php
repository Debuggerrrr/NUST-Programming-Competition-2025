<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$DASH = '../../admin_dashboard.php';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) { header('Location: ' . $DASH); exit; }

// fetches the user
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
$stmt->execute([$id]);
$user = $stmt->fetch();
if (!$user) { header('Location: ' . $DASH); exit; }

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $role = $_POST['role'] ?? $user['role'];
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '') {
        $errors[] = 'Username and email required.';
    } else {
        // checks the uniqueness
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? AND id != ? LIMIT 1');
        $stmt->execute([$username, $id]);
        if ($stmt->fetch()) $errors[] = 'Username already in use.';
    }

    // handles profile pic
    if (!empty($_FILES['profile_picture']['name']) && $_FILES['profile_picture']['error'] !== UPLOAD_ERR_NO_FILE) {
        $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/gif'=>'gif'];
        $type = mime_content_type($_FILES['profile_picture']['tmp_name']);
        if (!isset($allowed[$type])) {
            $errors[] = 'Invalid profile image.';
        } else {
            $ext = $allowed[$type];
            $newName = 'user_' . $id . '_' . time() . '.' . $ext;
            $targetDir = __DIR__ . '/images/profiles/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
            $target = $targetDir . $newName;
            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
                $errors[] = 'Failed to save profile picture.';
            } else {
                $profile_picture = 'images/profiles/' . $newName;
            }
        }
    }

    if (empty($errors)) {
        $fields = [];
        $params = [];
        $fields[] = 'username = ?'; $params[] = $username;
        $fields[] = 'email = ?'; $params[] = $email;
        $fields[] = 'first_name = ?'; $params[] = $first_name;
        $fields[] = 'last_name = ?'; $params[] = $last_name;
        $fields[] = 'role = ?'; $params[] = $role;
        if (!empty($password)) {
            $fields[] = 'password = ?'; $params[] = password_hash($password, PASSWORD_DEFAULT);
        }
        if (isset($profile_picture)) {
            $fields[] = 'profile_picture = ?'; $params[] = $profile_picture;
        }
        $params[] = $id;
        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = ?';
        $pdo->prepare($sql)->execute($params);

        // Create a row in role table if switched to role that requires a row (Optionally)
        if ($role === 'patient') {
            $pdo->prepare('INSERT IGNORE INTO patients (id) VALUES (?)')->execute([$id]);
        } elseif ($role === 'doctor') {
            $pdo->prepare('INSERT IGNORE INTO doctors (id) VALUES (?)')->execute([$id]);
        } elseif ($role === 'nurse') {
            $pdo->prepare('INSERT IGNORE INTO nurses (id) VALUES (?)')->execute([$id]);
        } elseif ($role === 'pharmacist') {
            $pdo->prepare('INSERT IGNORE INTO pharmacists (id) VALUES (?)')->execute([$id]);
        }

        header('Location: ' . $DASH . '?msg=' . urlencode('User updated.'));
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit user</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h3>Edit user</h3>
    <?php if ($errors): ?>
        <div class="alert alert-danger"><?php echo implode('<br>', array_map('htmlspecialchars',$errors)); ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <div class="row g-2">
            <div class="col-md-4"><label>Username</label><input name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>"></div>
            <div class="col-md-4"><label>Email</label><input name="email" type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>"></div>
            <div class="col-md-4"><label>New password (leave empty to keep)</label><input name="password" type="password" class="form-control"></div>
            <div class="col-md-4"><label>First name</label><input name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>"></div>
            <div class="col-md-4"><label>Last name</label><input name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>"></div>
            <div class="col-md-4"><label>Role</label>
                <select name="role" class="form-select">
                    <option value="patient" <?php if($user['role']=='patient') echo 'selected'; ?>>Patient</option>
                    <option value="doctor" <?php if($user['role']=='doctor') echo 'selected'; ?>>Doctor</option>
                    <option value="nurse" <?php if($user['role']=='nurse') echo 'selected'; ?>>Nurse</option>
                    <option value="pharmacist" <?php if($user['role']=='pharmacist') echo 'selected'; ?>>Pharmacist</option>
                    <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
                </select>
            </div>
            <div class="col-md-6"><label>Profile picture</label><input type="file" name="profile_picture" class="form-control"></div>
        </div>
        <div class="mt-3">
            <a href="<?php echo $DASH; ?>" class="btn btn-secondary">Cancel</a>
            <button class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>
</body>
</html>
