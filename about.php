<?php
// about.php - About page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - MESMTF</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="diagnosis.php">Diagnosis</a></li>
                    <li class="nav-item"><a class="nav-link" href="api/auth/login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">About MESMTF</h2>
                    <p class="lead">Revolutionizing healthcare through artificial intelligence</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h3 class="fw-bold mb-3">What is MESMTF?</h3>
                    <p>The Medical Expert System for Malaria and Typhoid Fever (MESMTF) is an advanced web-based platform that uses artificial intelligence to emulate human expertise in diagnosing and treating Malaria and Typhoid Fever.</p>
                    <p>Our system provides comprehensive e-Health services including medical records management, appointment scheduling, diagnosis, treatment planning, pharmacy services, drug administration, and reporting.</p>
                </div>
                <div class="col-md-6">
                    <h3 class="fw-bold mb-3">Key Benefits</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Accurate diagnosis using rule-based expert system</li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> 24/7 availability for preliminary diagnosis</li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Reduced waiting times for patients</li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Comprehensive patient management system</li>
                        <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i> Integration with pharmacy and drug administration</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

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
                    <ul class="list-unstyled">
                        <li><a href="index.html" class="text-white">Home</a></li>
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
    <script>
            // Navigation menu functionality
            document.addEventListener('DOMContentLoaded', function() {
                // Get the current page filename
                const currentPage = location.pathname.split('/').pop();
                // Remove active class from all nav items
                document.querySelectorAll('.nav-link').forEach(link => {
                    ink.classList.remove('active');
                });
                // Add active class to the current page's nav item
                if (currentPage === 'index.html' || currentPage === '') {
                    document.querySelector('a[href="index.html"]').classList.add('active');
                } else if (currentPage === 'services.html') {
                    document.querySelector('a[href="services.html"]').classList.add('active');
                } else if (currentPage === 'about.html') {
                    document.querySelector('a[href="about.html"]').classList.add('active');
                } else if (currentPage === 'diagnosis.html') {
                    document.querySelector('a[href="diagnosis.html"]').classList.add('active');
                }
            });
    </script>
</body>
</html>

