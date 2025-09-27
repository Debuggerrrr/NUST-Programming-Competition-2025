<?php
// services.php - Services page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - MESMTF Medical Expert System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <div class="logo-placeholder">
                    <img src="images/Logo.jpeg" alt="MESMTF Logo" class="nav-logo">
                </div>
                MESMTF
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="diagnosis.php">Diagnosis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Simple Page Header -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Our Services</h2>
                    <p>Comprehensive healthcare solutions for medical professionals</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Content -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- Medical Records -->
                <div class="col-lg-6">
                    <div class="service-card">
                        <div class="service-icon">📊</div>
                        <h3>Medical Records Management</h3>
                        <p>Secure electronic health records system for comprehensive patient information storage and management.</p>
                        <div class="service-info">
                            <strong>Reports Generated:</strong>
                            <span>Medical history summaries, treatment timelines, patient summaries</span>
                        </div>
                    </div>
                </div>

                <!-- AI Diagnosis -->
                <div class="col-lg-6">
                    <div class="service-card">
                        <div class="service-icon">🤖</div>
                        <h3>AI-Powered Diagnosis</h3>
                        <p>Advanced rule-based expert system for accurate preliminary diagnosis of Malaria and Typhoid Fever.</p>
                        <div class="service-info">
                            <strong>Reports Generated:</strong>
                            <span>Symptom analysis, diagnostic assessments, risk scores</span>
                        </div>
                    </div>
                </div>

                <!-- Pharmacy Services -->
                <div class="col-lg-6">
                    <div class="service-card">
                        <div class="service-icon">💊</div>
                        <h3>Pharmacy & Medication Management</h3>
                        <p>Complete electronic prescription system with drug interaction checks and medication tracking.</p>
                        <div class="service-info">
                            <strong>Reports Generated:</strong>
                            <span>Prescription summaries, adherence tracking, drug interactions</span>
                        </div>
                    </div>
                </div>

                <!-- Comprehensive Reporting -->
                <div class="col-lg-6">
                    <div class="service-card">
                        <div class="service-icon">📈</div>
                        <h3>Comprehensive Reporting</h3>
                        <p>Detailed analytics and reporting system for treatment outcomes and progress tracking.</p>
                        <div class="service-info">
                            <strong>Reports Generated:</strong>
                            <span>Treatment analysis, progress tracking, epidemiological studies</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Simple Call to Action -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h4>Ready to Get Started?</h4>
                    <p class="mb-3">Join healthcare professionals using our medical expert system</p>
                    <a href="about.php" class="btn btn-outline-primary">Learn More</a>
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
        });
    </script>
</body>
</html>