<?php
session_start();
// Handle login form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    // Call login.php to validate credentials
    require_once 'api/auth/login.php';
    // login.php should set $_SESSION['user_id'] on success
    if (isset($_SESSION['user_id'])) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MESMTF - Medical Expert System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-laptop-medical me-2"></i>MESMTF
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="fas fa-home me-1"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php"><i class="fas fa-info-circle me-1"></i> About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php"><i class="fas fa-stethoscope me-1"></i> Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="diagnosis.php"><i class="fas fa-diagnoses me-1"></i> Diagnosis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="api/auth/login.php"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Public Home Page -->
    <div id="publicPage">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <h1 class="display-4 fw-bold mb-4">Medical Expert System for Malaria and Typhoid Fever</h1>
                <p class="lead mb-4">A comprehensive e-Health solution for the Ministry of Health and Social Services</p>
                <a href="diagnosis.php" class="btn btn-primary btn-lg me-2"><i class="fas fa-diagnoses me-1"></i> Start Diagnosis</a>
                <a href="services.php" class="btn btn-outline-light btn-lg"><i class="fas fa-info-circle me-1"></i> Learn More</a>
            </div>
        </section>
    </div>


    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>MESMTF</h5>
                    <p>Medical Expert System for Malaria and Typhoid Fever - A comprehensive e-Health solution for the Ministry of Health and Social Services.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled" >
                        <li><a href="index.php" class="text-white">Home</a></li>
                        <li><a href="about.html" class="text-white">About</a></li>
                        <li><a href="services.html" class="text-white">Services</a></li>
                        <li><a href="diagnosis.html" class="text-white">Diagnosis</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <address>
                        <i class="fas fa-map-marker-alt me-2"></i> 13 Jackson Kaijieua Street<br>
                        Private Bag 1388, Winbrook, NAMIBIA<br>
                        <i class="fas fa-phone me-2"></i> +264 61 207 2052<br>
                        <i class="fas fa-envelope me-2"></i> tfse@nust.na
                    </address>
                </div>
            </div>
            <hr class="bg-light">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2025 MESMTF. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>Developed for Ministry of Health and Social Services</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>