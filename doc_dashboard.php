<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .navbar { margin-bottom: 2rem; }
        .card { box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .list-group-item.active { background-color: #0d6efd; border-color: #0d6efd; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="doc_dashboard.php">MESMTF Doctor Dashboard</a>
            <div class="d-flex align-items-center ms-auto">
                <?php
                    $profile_picture = $_SESSION['profile_picture'] ?? 'images/default_avatar.png';
                ?>
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture"
                     class="rounded-circle me-2" style="width:40px;height:40px;object-fit:cover;border:2px solid #fff;">
                <span class="text-light fw-bold me-3">
                    Welcome, Dr. <?php echo htmlspecialchars($_SESSION['first_name'] ?? '') . ' ' . htmlspecialchars($_SESSION['last_name'] ?? ''); ?>
                </span>
                <a href="edit_profile.php" class="btn btn-outline-light me-2">Edit Profile</a>
                <a href="api/auth/login.php?action=logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h2 class="mb-4">Doctor Dashboard</h2>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">Medical Records</a>
                    <a href="#" class="list-group-item list-group-item-action">Appointments</a>
                    <a href="#" class="list-group-item list-group-item-action">Diagnosis</a>
                    <a href="#" class="list-group-item list-group-item-action">Treatment</a>
                    <a href="#" class="list-group-item list-group-item-action">Pharmacy</a>
                    <a href="#" class="list-group-item list-group-item-action">Drug Administration</a>
                    <a href="#" class="list-group-item list-group-item-action">Reporting</a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">Quick Actions</div>
                    <div class="card-body">
                        <a href="#" class="btn btn-success me-2 mb-2">View Patients</a>
                        <a href="#" class="btn btn-info me-2 mb-2">Book Appointment</a>
                        <a href="#" class="btn btn-warning me-2 mb-2">Start Diagnosis</a>
                        <a href="#" class="btn btn-secondary mb-2">Generate Report</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Dashboard Overview</div>
                    <div class="card-body">
                        <ul>
                            <li>View and manage patient medical records</li>
                            <li>Book and manage appointments</li>
                            <li>Perform medical diagnosis for Malaria/Typhoid (see symptoms table)</li>
                            <li>Prescribe treatments and manage pharmacy</li>
                            <li>Administer drugs and update records</li>
                            <li>Generate and print reports</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
