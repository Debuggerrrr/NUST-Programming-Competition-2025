<?php
// diagnosis.php - Diagnosis page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosis - MESMTF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-laptop-medical me-2"></i> <div class="logo-placeholder">
                    <img src="\Programming-Competition-2025\images\Logo.jpeg" alt="MESMTF Logo" class="nav-logo">
                </div>MESMTF
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link active" href="diagnosis.php">Diagnosis</a></li>
                    <li class="nav-item"><a class="nav-link" href="api/auth/login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Diagnosis Page</h1>
        <p>This is the diagnosis page. Add your diagnosis form or logic here.</p>
    </div>
    
<!-- Diagnosis Section -->
    <section id="diagnosis" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="fw-bold">AI-Powered Diagnosis</h2>
                    <p class="lead">Get a preliminary assessment for Malaria and Typhoid Fever</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="fas fa-diagnoses me-2"></i> Symptom Checker</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Select the symptoms you're experiencing. Our AI system will analyze them and provide a preliminary assessment.</p>
                            <h5 class="mt-4 mb-3">Malaria Symptoms</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="abdominal_pain" id="m_abdominal_pain">
                                        <label class="form-check-label" for="m_abdominal_pain">Abdominal pain</label>
                                    </div>
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="vomiting" id="m_vomiting">
                                        <label class="form-check-label" for="m_vomiting">Vomiting</label>
                                    </div>
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="sore_throat" id="m_sore_throat">
                                        <label class="form-check-label" for="m_sore_throat">Sore throat</label>
                                    </div>
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="headache" id="m_headache">
                                        <label class="form-check-label" for="m_headache">Headache</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="fatigue" id="m_fatigue">
                                        <label class="form-check-label" for="m_fatigue">Fatigue</label>
                                    </div>
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="cough" id="m_cough">
                                        <label class="form-check-label" for="m_cough">Cough</label>
                                    </div>
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="constipation" id="m_constipation">
                                        <label class="form-check-label" for="m_constipation">Constipation</label>
                                    </div>
                                </div>
                            </div>
                            
                            <h5 class="mt-4 mb-3">Typhoid Symptoms</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="abdominal_pain" id="t_abdominal_pain">
                                        <label class="form-check-label" for="t_abdominal_pain">Abdominal pain</label>
                                    </div>
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="stomach_issues" id="t_stomach_issues">
                                        <label class="form-check-label" for="t_stomach_issues">Stomach issues</label>
                                    </div>
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="headache" id="t_headache">
                                        <label class="form-check-label" for="t_headache">Headache</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="persistent_fever" id="t_persistent_fever">
                                        <label class="form-check-label" for="t_persistent_fever">Persistent high fever</label>
                                    </div>
                                    <div class="form-check symptom-checkbox">
                                        <input class="form-check-input" type="checkbox" value="weakness" id="t_weakness">
                                        <label class="form-check-label" for="t_weakness">Weakness</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button id="diagnoseBtn" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-stethoscope me-2"></i> Analyze Symptoms
                                </button>
                            </div>
                            
                            <div id="diagnosisResult" class="diagnosis-result alert alert-info d-none">
                                <h5><i class="fas fa-info-circle me-2"></i> Preliminary Diagnosis</h5>
                                <p id="resultText"></p>
                                <div id="recommendation" class="mt-3"></div>
                                <div class="mt-3">
                                    <button id="bookAppointmentBtn" class="btn btn-success">
                                        <i class="fas fa-calendar-check me-2"></i> Book Appointment with Doctor
                                    </button>
                                </div>
                            </div>
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
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-logo">
                        <div class="logo-placeholder">
    <!-- logo Section -->
                            <img src="\Programming-Competition-2025\images\Logo.jpeg" alt="MESMTF Logo" class="footer-logo-img">
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

