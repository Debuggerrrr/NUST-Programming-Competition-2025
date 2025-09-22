<?php
// services.php - Services page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - MESMTF</title>
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
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="diagnosis.php">Diagnosis</a></li>
                    <li class="nav-item"><a class="nav-link" href="api/auth/login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
<!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">Our Services</h2>
                    <p class="lead">Comprehensive healthcare solutions for everyone</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card module-card">
                        <div class="card-body text-center p-4">
                            <div class="module-icon">
                                <i class="fas fa-user-injured"></i>
                            </div>
                            <h4 class="card-title">Medical Records</h4>
                            <p class="card-text">Comprehensive electronic health records system for storing and managing patient information securely.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card module-card">
                        <div class="card-body text-center p-4">
                            <div class="module-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h4 class="card-title">Appointment Booking</h4>
                            <p class="card-text">Easy online scheduling with healthcare professionals specializing in Malaria and Typhoid treatment.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card module-card">
                        <div class="card-body text-center p-4">
                            <div class="module-icon">
                                <i class="fas fa-diagnoses"></i>
                            </div>
                            <h4 class="card-title">AI Diagnosis</h4>
                            <p class="card-text">Rule-based expert system for preliminary diagnosis of Malaria and Typhoid Fever based on symptoms.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card module-card">
                        <div class="card-body text-center p-4">
                            <div class="module-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <h4 class="card-title">Pharmacy Services</h4>
                            <p class="card-text">Electronic prescription system and medication management with drug interaction checks.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card module-card">
                        <div class="card-body text-center p-4">
                            <div class="module-icon">
                                <i class="fas fa-file-medical"></i>
                            </div>
                            <h4 class="card-title">Reporting</h4>
                            <p class="card-text">Comprehensive reporting system for prescriptions, patient history, and treatment outcomes.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card module-card">
                        <div class="card-body text-center p-4">
                            <div class="module-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h4 class="card-title">Mobile Access</h4>
                            <p class="card-text">Access the system from anywhere using smartphones, tablets, or computers with offline capability.</p>
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
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
