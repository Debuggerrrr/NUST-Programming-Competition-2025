<?php
// about.php - About page for Medical Expert System
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - MESMTF Medical Expert System</title>
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
                        <a class="nav-link active" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li>
                    <li class="nav-item">
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--  Page Header -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>About MESMTF</h2>
                    <p>Revolutionizing healthcare in Namibia through advanced medical technology</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6">
                    <h3>What is MESMTF?</h3>
                    <p>The Medical Expert System for Malaria and Typhoid Fever (MESMTF) is an advanced web-based platform that uses artificial intelligence to emulate human expertise in diagnosing and treating Malaria and Typhoid Fever.</p>
                    <p>Our system provides comprehensive e-Health services including medical records management, appointment scheduling, diagnosis, treatment planning, pharmacy services, drug administration, and reporting.</p>
                    <p>Developed in collaboration with the Namibian Ministry of Health and Social Services, MESMTF represents a significant step forward in digital healthcare solutions for the nation.</p>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="images/pic1.jpg" class="img-fluid rounded">
                    </div>
                </div>
            </div>

            <!-- Key Benefits Section -->
            <div class="row mb-5">
                <div class="col-lg-12">
                    <h3 class="text-center">Key Benefits</h3>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <ul class="benefits-list">
                                <li>Accurate diagnosis using rule-based expert system</li>
                                <li>24/7 availability for preliminary diagnosis</li>
                                <li>Reduced waiting times for patients</li>
                                <li>Comprehensive patient management system</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="benefits-list">
                                <li>Integration with pharmacy and drug administration</li>
                                <li>Real-time health monitoring and alerts</li>
                                <li>Data-driven insights for public health planning</li>
                                <li>Secure and confidential patient records</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-4">
                    <h3>Our Leadership & Partners</h3>
                    <p>Collaborating with Namibia's healthcare leaders</p>
                </div>
            </div>
            
            <!-- Minister of Health -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="leader-card">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="leader-image">
                                    <img src="images\pic2.jpg" alt="Dr. Esperance Luvindao" class="img-fluid rounded-circle">
                                    <!-- Minister's Photo -->
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h4>Dr. Esperance Luvindao</h4>
                                <p class="leader-title">Minister of Health and Social Services, Namibia</p>
                                <p>Dr. Esperance Luvindao has been instrumental in advancing healthcare initiatives across Namibia. Under her leadership, the Ministry has implemented numerous digital health solutions to improve healthcare accessibility and quality nationwide.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notable Doctors Section -->
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <h4 class="text-center">Notable Namibian Medical Professionals</h4>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="doctor-card text-center">
                        <div class="doctor-image mb-3">
                            <img src="images\pic3.jpg" alt="Dr. Izona Bock" class="img-fluid rounded-circle">
                            <!-- Dr. Bock's Photo -->
                        </div>
                        <h5>Dr. Izona Bock</h5>
                        <p class="specialty">Infectious Disease Specialist</p>
                        <p>Leading researcher in tropical diseases with over 15 years of experience in malaria and typhoid treatment protocols.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="doctor-card text-center">
                        <div class="doctor-image mb-3">
                            <img src="images\pic4.jpeg" alt="Mr. Penda Ithindi" class="img-fluid rounded-circle">
                            <!-- Mr. Ithindi's Photo -->
                        </div>
                        <h5>Mr. Penda Ithindi</h5>
                        <p class="specialty">Public Health Director</p>
                        <p>Pioneer in digital health implementation and community health programs across Namibia's rural areas.</p>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="doctor-card text-center">
                        <div class="doctor-image mb-3">
                            <img src="images\pic5.webp" alt="Mr. Erwin Nakafingo" class="img-fluid rounded-circle">
                            <!-- Mr. Nakafingo's Photo -->
                        </div>
                        <h5>Mr. Erwin Nakafingo</h5>
                        <p class="specialty">Medical Research Director</p>
                        <p>Expert in epidemiological studies and health data analysis, contributing significantly to disease prevention strategies.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Vision Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="mission-card">
                        <h4>Our Mission</h4>
                        <p>To provide accessible, accurate, and efficient medical diagnosis and treatment guidance for malaria and typhoid fever through advanced technology, improving healthcare outcomes across Namibia.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="vision-card">
                        <h4>Our Vision</h4>
                        <p>To become Namibia's leading digital health platform, transforming healthcare delivery through innovation, collaboration, and cutting-edge medical technology that serves every community.</p>
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
                            <img src="images/Logo.jpeg" alt="MESMTF Logo" class="footer-logo-img">
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
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-heading">Health Resources</h5>
                    <ul class="footer-links">
                        <li><a href="#" class="footer-link">Malaria Prevention</a></li>
                        <li><a href="#" class="footer-link">Typhoid Information</a></li>
                    </ul>
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