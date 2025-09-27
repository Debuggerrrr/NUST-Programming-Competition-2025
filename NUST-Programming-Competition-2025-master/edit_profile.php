<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
require_once 'models/User.php';
$user = new User();
$user->getById($_SESSION['user_id']);

// Handle profile update logic here (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? $user->username;
    $first_name = $_POST['first_name'] ?? $user->first_name;
    $last_name = $_POST['last_name'] ?? $user->last_name;
    $email = $_POST['email'] ?? $user->email;
    $title = $_POST['title'] ?? $user->title;
    $specialization = ($user->role === 'doctor') ? ($_POST['specialization'] ?? $user->specialization) : '';
    $password = $_POST['password'] ?? '';

    // Handle profile picture upload
    $profile_picture_path = $user->profile_picture;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'images/profiles/';
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

    // Build update query
    $params = [
        ':id' => $user->id,
        ':username' => $username,
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':email' => $email,
        ':title' => $title,
        ':specialization' => $specialization,
        ':profile_picture' => $profile_picture_path
    ];
    $set_password = '';
    if (!empty($password)) {
        $set_password = ', password_hash = :password_hash';
        $params[':password_hash'] = password_hash($password, PASSWORD_DEFAULT);
    }
    require_once 'models/Database.php';
    $db = new Database();
    $sql = "UPDATE users SET username = :username, first_name = :first_name, last_name = :last_name, email = :email, title = :title, specialization = :specialization, profile_picture = :profile_picture $set_password WHERE id = :id";
    $db->query($sql, $params);

    // Update session
    $_SESSION['username'] = $username;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['title'] = $title;
    $_SESSION['specialization'] = $specialization;
    $_SESSION['profile_picture'] = $profile_picture_path;

    // Refresh user object
    $user->getById($user->id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile & Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h3>Edit Profile & Settings</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user->username); ?>" required>
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user->first_name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user->last_name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user->email); ?>" required>
        </div>
        <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
            <div class="d-flex align-items-center mt-2">
                <?php if (!empty($user->profile_picture)): ?>
                    <img src="<?php echo $user->profile_picture; ?>" alt="Profile" class="rounded-circle" style="width:60px;height:60px;object-fit:cover;">
                <?php endif; ?>
                <div class="ms-3">
                    <span class="fw-bold">
                        <?php 
                            $displayTitle = !empty($user->title) ? htmlspecialchars($user->title) : '';
                            $displayName = htmlspecialchars($user->first_name . ' ' . $user->last_name);
                            echo trim($displayTitle . ' ' . $displayName);
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($user->title); ?>">
        </div>
        <?php if ($user->role === 'doctor'): ?>
        <div class="mb-3">
            <label for="specialization" class="form-label">Specialization</label>
            <input type="text" class="form-control" id="specialization" name="specialization" value="<?php echo htmlspecialchars($user->specialization); ?>">
        </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="password" class="form-label">Reset Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="<?php echo ($user->role === 'doctor') ? 'doctor_dashboard.php' : 'patient_dashboard.php'; ?>" class="btn btn-secondary ms-2">Back to Dashboard</a>
    </form>
</div>
</body>
</html>
