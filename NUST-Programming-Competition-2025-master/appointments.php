<?php
// services.php - Services page
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="tooplate-inner-peace.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation Bar -->
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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <!-- Appointment Section - Two Columns -->
    <section id="contact">
        <div class="contact-container">
            <h2 class="section-title">Book Appointment</h2>
            
            <div class="contact-wrapper">
                <div class="contact-info">
                    <h3>Get in Touch</h3>
                    
                    <div class="info-item">
                        <div class="info-icon">📍</div>
                        <div class="info-text">
                            <h4>Visit Us</h4>
                            <p>Ministerial Building, Harvey Street<br>Windhoek, Namibia</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📧</div>
                        <div class="info-text">
                            <h4>Email</h4>
                            <p>Public.Relations@mhss.gov.na<br>Private Bag 13198, Windhoek, Republic of Namibia</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📞</div>
                        <div class="info-text">
                            <h4>Telephone</h4>
                            <p>+264 61 203 9111<br>Mon-Fri, 9am-6pm EST</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">💬</div>
                        <div class="info-text">
                            <h4>Live Chat</h4>
                            <p>Available 24/7 for urgent support</p>
                        </div>
                    </div>

                    <div class="social-links">
                        <a href="#" class="social-link">f</a>
                        <a href="#" class="social-link">t</a>
                        <a href="#" class="social-link">i</a>
                        <a href="#" class="social-link">l</a>
                    </div>
                </div>

                <div class="contact-form">
                    <h3 style="color: var(--primary); font-size: 1.8rem; margin-bottom: 2rem;">Send a Message</h3>
                    <form>
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
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
                    <li><a href="index.php" class="footer-link" >Home</a></li>
                    <li><a href="about.php" class="footer-link">About</a></li>
                    <li><a href="services.php" class="footer-link">Services</a></li>
                    <li><a href="diagnosis.php" class="footer-link">Diagnosis</a></li>
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

            <!-- Social Media Links -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-heading">Follow Ministry of Health</h5>
                <div class="social-links">
                    <a href="https://www.facebook.com/MOHSSNamibia" target="_blank" class="social-link">
                        <i class="fab fa-facebook-f"></i> 
                    </a>
                    <a href="https://twitter.com/MOHSS_Namibia" target="_blank" class="social-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.youtube.com/user/MOHSSNamibia" target="_blank" class="social-link">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.instagram.com/mohss_namibia" target="_blank" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
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
    <script src="tooplate-inner-peace-scripts.js"></script>
</body>
</html>