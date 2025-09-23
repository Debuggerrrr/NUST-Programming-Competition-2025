<?php
session_start();
$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    require_once 'api/auth/login.php';
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['role'] === 'doctor') {
            header('Location: doc_dashboard.php');
        } elseif ($_SESSION['role'] === 'patient') {
            header('Location: patient_dashboard.php');
        } elseif ($_SESSION['role'] === 'nurse') {
            header('Location: nurse_dashboard.php');
        } elseif ($_SESSION['role'] === 'pharmacist') {
            header('Location: pharmacist_dashboard.php');
        } elseif ($_SESSION['role'] === 'admin') {
            header('Location: admin_dashboard.php');
        } else {
            header('Location: dashboard.php');
        }
        exit();
    } else {
        $login_error = 'Invalid username or password.';
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
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <div class="logo-placeholder">
                    <!--  logo -->
                    <img src="images\Logo.jpeg" alt="MESMTF Logo" class="nav-logo">
                </div>
                MESMTF
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
        <!-- Login Modal -->
            <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginModalLabel">Login to MESMTF</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="index.php">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Login As</label>
                                    <select class="form-select" id="role" name="role">
                                        <option value="patient">Patient</option>
                                        <option value="doctor">Doctor</option>
                                        <option value="nurse">Nurse</option>
                                        <option value="pharmacist">Pharmacist</option>
                                        <option value="admin">Administrator</option>
                                    </select>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <div class="text-danger"> <?php echo $login_error; ?> </div>
                                <div class="text-center mt-3">
                                    <p>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Register</a></p>
                                    <p>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal">Forgot password?</a>
                                    </p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <!-- Register Modal -->
            <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registerModalLabel">Register for MESMTF</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="api/auth/register.php" enctype="multipart/form-data">
                            <div class="modal-body">
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
                                                    <label for="title" class="form-label">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Mr, Ms, Dr, Prof" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Register As</label>
                                                    <select class="form-select" id="role" name="role" required onchange="toggleSpecialization(this.value)">
                                                          <option value="patient">Patient</option>
                                                          <option value="doctor">Doctor</option>
                                                          <option value="nurse">Nurse</option>
                                                          <option value="pharmacist">Pharmacist</option>
                                                          <option value="receptionist">Receptionist</option>
                                                          <option value="admin">Administrator</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3" id="specializationField" style="display:none;">
                                                    <label for="specialization" class="form-label">Specialization (Doctors only)</label>
                                                    <input type="text" class="form-control" id="specialization" name="specialization" placeholder="e.g. Cardiologist, Pediatrician">
                                                </div>
                                                <script>
                                                    function toggleSpecialization(role) {
                                                        document.getElementById('specializationField').style.display = (role === 'doctor') ? 'block' : 'none';
                                                    }
                                                </script>
                                                <div class="mb-3">
                                                    <label for="profile_picture" class="form-label">Profile Picture</label>
                                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-100">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Forgot Password Modal -->
            <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="api/auth/forgot_password.php">
                            <div class="modal-header">
                                <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Password</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="reset_email" class="form-label">Enter your email address</label>
                                    <input type="email" class="form-control" id="reset_email" name="reset_email" required>
                                </div>
                                <div class="text-muted">We'll send you instructions to reset your password.</div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Medical Expert System for Malaria and Typhoid Fever</h1>
                <p class="hero-description">A comprehensive e-Health solution for the Ministry of Health and Social Services</p>
                <div class="hero-buttons">
                    <a href="services.php" class="btn btn-hero btn-hero-outline">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Our System</h2>
                <p>Advanced features designed specifically for healthcare professionals</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span>F</span>
                        </div>
                        <h4>Fast Diagnosis</h4>
                        <p>Quick and accurate identification of malaria and typhoid fever symptoms with our advanced algorithms.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span>S</span>
                        </div>
                        <h4>Secure & Private</h4>
                        <p>Patient data is protected with enterprise-grade security and strict privacy controls.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span>D</span>
                        </div>
                        <h4>Data Analytics</h4>
                        <p>Comprehensive reporting and analytics to track disease patterns and treatment outcomes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-logo">
                        <div class="logo-placeholder">
    <!-- logo Section -->
                            <img src="images\Logo.jpeg" alt="MESMTF Logo" class="footer-logo-img">
                        </div>
                        <div>
                            <h5 class="footer-heading">MESMTF System</h5>
                            <p>Medical Expert System for Malaria and Typhoid Fever - A comprehensive e-Health solution.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="index.php" class="footer-link">Home</a></li>
                        <li><a href="about.php" class="footer-link">About</a></li>
                        <li><a href="services.php" class="footer-link">Services</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-heading">Contact Us</h5>
                    <div class="contact-info">
                        <p><span class="contact-icon"></span> 13 Jackson Kaijieua Street<br>Private Bag 1388, Winbrook, NAMIBIA</p>
                        <p><span class="contact-icon"></span> +264 61 207 2052</p>
                        <p><span class="contact-icon"></span> tfse@nust.na</p>
                    </div>
                </div>

            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; 2025 MESMTF. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p>Developed for Ministry of Health and Social Services</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript for interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.style.padding = '0.5rem 0';
                    navbar.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
                } else {
                    navbar.style.padding = '0.8rem 0';
                    navbar.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                }
            });

            <?php if (isset($_GET['registered']) && $_GET['registered'] === 'success'): ?>
                // Show registration success message and open login modal
                var toast = document.createElement('div');
                toast.className = 'toast align-items-center text-bg-success border-0 position-fixed top-0 end-0 m-3';
                toast.setAttribute('role', 'alert');
                toast.innerHTML = '<div class="d-flex"><div class="toast-body">Registration successful! Please log in.</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
                document.body.appendChild(toast);
                var bsToast = new bootstrap.Toast(toast);
                bsToast.show();

                var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            <?php endif; ?>
        });
    </script>
</body>
</html>