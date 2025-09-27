<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header('Location: index.php');
    exit();
}

// Database connection
require_once 'models/Database.php';
$database = new Database();
$db = $GLOBALS['pdo']; // Use the global PDO connection from models/Database.php

// Get doctor's information
$doctor_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM doctors WHERE user_id = ?");
$stmt->execute([$doctor_id]);
$doctor = $stmt->fetch(PDO::FETCH_ASSOC);

// Get statistics
$stats = [
    'total_patients' => 0,
    'today_appointments' => 0,
    'weekly_diagnoses' => 0,
    'active_prescriptions' => 0
];

try {
    // Total patients
    $stmt = $db->query("SELECT COUNT(*) FROM patients");
    $stats['total_patients'] = $stmt->fetchColumn();
    
    // Today's appointments
    $stmt = $db->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id = ? AND DATE(appointment_datetime) = CURDATE()");
    $stmt->execute([$doctor['doctor_id']]);
    $stats['today_appointments'] = $stmt->fetchColumn();
    
    // Weekly diagnoses
    $stmt = $db->prepare("SELECT COUNT(*) FROM medical_records WHERE doctor_id = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stmt->execute([$doctor['doctor_id']]);
    $stats['weekly_diagnoses'] = $stmt->fetchColumn();
    
    // Active prescriptions
    $stmt = $db->query("SELECT COUNT(*) FROM prescriptions WHERE status = 'pending'");
    $stats['active_prescriptions'] = $stmt->fetchColumn();
    
} catch (Exception $e) {
    // Continue with default values if there's an error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MESMTF - Doctor Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0d6efd;
            --secondary: #6c757d;
            --success: #198754;
            --info: #0dcaf0;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        body { 
            background: #f0f2f5; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .navbar-custom {
            background: linear-gradient(135deg, #0d6efd 0%, #198754 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .sidebar {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            height: fit-content;
            position: sticky;
            top: 20px;
        }
        
        .sidebar .nav-link {
            color: #495057;
            padding: 12px 15px;
            margin: 5px 0;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #e3f2fd;
            color: var(--primary);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }
        
        .stat-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .recent-activity {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .activity-item {
            padding: 12px 15px;
            border-left: 3px solid var(--primary);
            background: #f8f9fa;
            margin-bottom: 10px;
            border-radius: 0 8px 8px 0;
        }
        
        .quick-action-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #e9ecef;
        }
        
        .quick-action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: var(--primary);
        }
        
        .quick-action-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin: 0 auto 15px;
        }
        
        .profile-pic {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        
        .section-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, #0d6efd 0%, #198754 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
        }
        
        .toast-container {
            z-index: 1100;
        }
        
        .table-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .form-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 25px;
            margin-bottom: 20px;
        }
        
        /* Custom scrollbar */
        .recent-activity::-webkit-scrollbar {
            width: 6px;
        }
        
        .recent-activity::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .recent-activity::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        .recent-activity::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-bottom: 20px;
                position: static;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="dashboard-container container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-user-md me-2"></i>Medical Expert System for Malaria and Typhoid Fever
            </a>
            <div class="d-flex align-items-center">
                <?php
                    $profile_picture = $_SESSION['profile_picture'] ?? '';
                    $imgPath = $profile_picture ? (strpos($profile_picture, 'images/') === 0 ? $profile_picture : 'images/profiles/' . basename($profile_picture)) : 'images/default_avatar.png';
                ?>
                <img id="navbarProfilePic" src="<?php echo htmlspecialchars($imgPath); ?>" alt="Profile" class="profile-pic me-2">
                <span class="text-light fw-bold me-3">
                    Dr. <?php echo htmlspecialchars($_SESSION['first_name'] ?? '') . ' ' . htmlspecialchars($_SESSION['last_name'] ?? ''); ?>
                </span>
                <a href="#" class="btn btn-outline-light me-2" id="openEditProfile">
                    <i class="fas fa-user-edit me-1"></i>Edit Profile
                </a>
                <a href="api/auth/login.php?action=logout" class="btn btn-light">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="profileToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="profileToastBody">
                    Profile successfully updated!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-container container-fluid mt-4">
        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3">
                <div class="sidebar p-3">
                    <h5 class="mb-3 text-primary"><i class="fas fa-bars me-2"></i>Doctor Portal</h5>
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="#" data-section="dashboardSection">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a class="nav-link" href="#" data-section="medicalRecordsSection">
                            <i class="fas fa-user-injured"></i> Medical Records
                        </a>
                        <a class="nav-link" href="#" data-section="appointmentsSection">
                            <i class="fas fa-calendar-check"></i> Appointments
                        </a>
                        <a class="nav-link" href="#" data-section="diagnosisSection">
                            <i class="fas fa-diagnoses"></i> AI-Powered Diagnosis
                        </a>
                        <a class="nav-link" href="#" data-section="patientRegistrationSection">
                            <i class="fas fa-user-plus"></i> Patient Registration
                        </a>
                        <a class="nav-link" href="#" data-section="prescriptionsSection">
                            <i class="fas fa-prescription"></i> Prescriptions
                        </a>
                        <a class="nav-link" href="#" data-section="reportsSection">
                            <i class="fas fa-chart-bar"></i> Patient Reports
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="col-lg-9">
                <!-- Dashboard Section -->
                <div class="section-content" id="dashboardSection">
                    <!-- Welcome Header -->
                    <div class="dashboard-header">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="mb-2">Welcome, Dr. <?php echo htmlspecialchars($_SESSION['first_name'] ?? ''); ?></h2>
                                <p class="mb-0">Here's your medical dashboard overview for today</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="bg-white text-primary rounded-pill px-3 py-2 d-inline-block">
                                    <i class="fas fa-calendar-day me-2"></i>
                                    <?php echo date('l, F j, Y'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card p-3">
                                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h3 class="fw-bold"><?php echo $stats['total_patients']; ?></h3>
                                <p class="text-muted mb-0">Total Patients</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card p-3">
                                <div class="stat-icon bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <h3 class="fw-bold"><?php echo $stats['today_appointments']; ?></h3>
                                <p class="text-muted mb-0">Today's Appointments</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card p-3">
                                <div class="stat-icon bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-diagnoses"></i>
                                </div>
                                <h3 class="fw-bold"><?php echo $stats['weekly_diagnoses']; ?></h3>
                                <p class="text-muted mb-0">Diagnoses This Week</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="stat-card p-3">
                                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <h3 class="fw-bold"><?php echo $stats['active_prescriptions']; ?></h3>
                                <p class="text-muted mb-0">Active Prescriptions</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions & Recent Activity -->
                    <div class="row g-4">
                        <!-- Quick Actions -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-12">
                                    <h4 class="section-title">Quick Actions</h4>
                                </div>
                                <div class="col-md-4">
                                    <div class="quick-action-card" onclick="switchPanel('medicalRecordsSection')">
                                        <div class="quick-action-icon bg-primary text-white">
                                            <i class="fas fa-user-injured"></i>
                                        </div>
                                        <h6>Medical Records</h6>
                                        <p class="small text-muted">View and manage patient records</p>
                                        <span class="btn btn-sm btn-outline-primary">Access</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="quick-action-card" onclick="switchPanel('appointmentsSection')">
                                        <div class="quick-action-icon bg-success text-white">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                        <h6>Appointments</h6>
                                        <p class="small text-muted">Schedule and manage appointments</p>
                                        <span class="btn btn-sm btn-outline-success">Manage</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="quick-action-card" onclick="switchPanel('diagnosisSection')">
                                        <div class="quick-action-icon bg-info text-white">
                                            <i class="fas fa-diagnoses"></i>
                                        </div>
                                        <h6>Diagnosis</h6>
                                        <p class="small text-muted">AI-powered malaria and typhoid diagnosis</p>
                                        <span class="btn btn-sm btn-outline-info">Start</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="quick-action-card" onclick="switchPanel('patientRegistrationSection')">
                                        <div class="quick-action-icon bg-warning text-white">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                        <h6>Patient Registration</h6>
                                        <p class="small text-muted">Register new patients</p>
                                        <span class="btn btn-sm btn-outline-warning">Register</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="quick-action-card" onclick="switchPanel('prescriptionsSection')">
                                        <div class="quick-action-icon bg-danger text-white">
                                            <i class="fas fa-prescription"></i>
                                        </div>
                                        <h6>Prescriptions</h6>
                                        <p class="small text-muted">Manage patient prescriptions</p>
                                        <span class="btn btn-sm btn-outline-danger">Manage</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="quick-action-card" onclick="switchPanel('reportsSection')">
                                        <div class="quick-action-icon bg-secondary text-white">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                        <h6>Patient Reports</h6>
                                        <p class="small text-muted">View patient analytics</p>
                                        <span class="btn btn-sm btn-outline-secondary">View</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="col-lg-4">
                            <div class="stat-card p-3">
                                <h5 class="section-title">Recent Activity</h5>
                                <p class="text-muted mb-3">Latest system activities and updates</p>
                                
                                <div class="recent-activity" id="recentActivityList">
                                    <!-- Activity items will be loaded via JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical Records Section -->
                <div class="section-content d-none" id="medicalRecordsSection">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="section-title mb-0">Medical Records</h4>
                        <button class="btn btn-primary" onclick="loadMedicalRecords()">
                            <i class="fas fa-sync-alt me-2"></i>Refresh
                        </button>
                    </div>
                    
                    <div class="table-card">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Patient ID</th>
                                        <th>Name</th>
                                        <th>Diagnosis</th>
                                        <th>Disease</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="medicalRecordsTable">
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-spinner fa-spin me-2"></i>Loading records...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Appointments Section -->
                <div class="section-content d-none" id="appointmentsSection">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="section-title mb-0">Appointments</h4>
                        <div>
                            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                                <i class="fas fa-plus me-2"></i>New Appointment
                            </button>
                            <button class="btn btn-primary" onclick="loadAppointments()">
                                <i class="fas fa-sync-alt me-2"></i>Refresh
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-card">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="appointmentsTable">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-spinner fa-spin me-2"></i>Loading appointments...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Diagnosis Section -->
                <div class="section-content d-none" id="diagnosisSection">
                    <h4 class="section-title">AI-Powered Diagnosis</h4>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-card">
                                <h5><i class="fas fa-stethoscope me-2"></i>Patient Diagnosis</h5>
                                <form id="diagnosisForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Select Patient</label>
                                            <select class="form-select" id="patientSelect" required>
                                                <option value="">Choose patient...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Disease Type</label>
                                            <select class="form-select" id="diseaseType" required>
                                                <option value="">Select disease...</option>
                                                <option value="malaria">Malaria</option>
                                                <option value="typhoid">Typhoid</option>
                                                <option value="both">Malaria & Typhoid</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Symptoms</label>
                                            <textarea class="form-control" id="symptoms" rows="4" 
                                                      placeholder="Enter patient symptoms (fever, headache, abdominal pain, etc.)" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Additional Notes</label>
                                            <textarea class="form-control" id="diagnosisNotes" rows="2" 
                                                      placeholder="Any additional observations..."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary" onclick="performDiagnosis()">
                                                <i class="fas fa-diagnoses me-2"></i>Perform Diagnosis
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-card">
                                <h5><i class="fas fa-lightbulb me-2"></i>Diagnosis Result</h5>
                                <div id="diagnosisResult" class="alert alert-info">
                                    <p class="mb-0">Enter patient symptoms and click "Perform Diagnosis" to get results.</p>
                                </div>
                                
                                <h6 class="mt-4">Common Symptoms</h6>
                                <div class="small">
                                    <strong>Malaria:</strong> Fever, chills, headache, sweating<br>
                                    <strong>Typhoid:</strong> High fever, abdominal pain, weakness<br>
                                    <strong>Both:</strong> Combination of above symptoms
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Patient Registration Section -->
                <div class="section-content d-none" id="patientRegistrationSection">
                    <h4 class="section-title">Patient Registration</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-card">
                                <h5><i class="fas fa-user-plus me-2"></i>Register New Patient</h5>
                                <form id="patientRegistrationForm">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">First Name *</label>
                                            <input type="text" class="form-control" name="first_name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Last Name *</label>
                                            <input type="text" class="form-control" name="last_name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" name="date_of_birth">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Gender</label>
                                            <select class="form-select" name="gender">
                                                <option value="">Select...</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" name="phone">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" name="address" rows="2"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Medical History</label>
                                            <textarea class="form-control" name="medical_history" rows="3" 
                                                      placeholder="Any pre-existing conditions, allergies, etc."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-success" onclick="registerPatient()">
                                                <i class="fas fa-save me-2"></i>Register Patient
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="table-card">
                                <h5><i class="fas fa-users me-2"></i>Recent Patients</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Registered</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recentPatientsTable">
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-3">
                                                    <i class="fas fa-spinner fa-spin me-2"></i>Loading...
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prescriptions Section -->
                <div class="section-content d-none" id="prescriptionsSection">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="section-title mb-0">Prescriptions</h4>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPrescriptionModal">
                            <i class="fas fa-plus me-2"></i>New Prescription
                        </button>
                    </div>
                    
                    <div class="table-card">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Medication</th>
                                        <th>Dosage</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="prescriptionsTable">
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-spinner fa-spin me-2"></i>Loading prescriptions...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Reports Section -->
                <div class="section-content d-none" id="reportsSection">
                    <h4 class="section-title">Patient Reports & Analytics</h4>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="stat-card p-4 text-center">
                                <div class="stat-icon bg-info bg-opacity-10 text-info mx-auto">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4>Monthly Diagnoses</h4>
                                <canvas id="diagnosesChart" height="200"></canvas>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="stat-card p-4 text-center">
                                <div class="stat-icon bg-success bg-opacity-10 text-success mx-auto">
                                    <i class="fas fa-pills"></i>
                                </div>
                                <h4>Disease Distribution</h4>
                                <canvas id="diseaseChart" height="200"></canvas>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="table-card">
                                <h5><i class="fas fa-file-medical me-2"></i>Detailed Reports</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Report Type</th>
                                                <th>Period</th>
                                                <th>Generated On</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="reportsTable">
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    No reports generated yet
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Schedule New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Patient</label>
                                <select class="form-select" name="patient_id" required>
                                    <option value="">Select patient...</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date & Time</label>
                                <input type="datetime-local" class="form-control" name="appointment_datetime" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Appointment purpose..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveAppointment()">Schedule</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global variables
        let currentDoctorId = <?php echo $doctor['doctor_id'] ?? 0; ?>;

        // Panel switching function
        function switchPanel(panelId) {
            // Update navigation
            document.querySelectorAll('.sidebar .nav-link').forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('data-section') === panelId) {
                    link.classList.add('active');
                }
            });
            
            // Show/hide sections
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.add('d-none');
                if (section.id === panelId) {
                    section.classList.remove('d-none');
                    // Load section data
                    loadSectionData(panelId);
                }
            });
        }

        // Load data for specific sections
        function loadSectionData(sectionId) {
            switch(sectionId) {
                case 'medicalRecordsSection':
                    loadMedicalRecords();
                    break;
                case 'appointmentsSection':
                    loadAppointments();
                    loadPatientsForSelect('#addAppointmentModal select[name=\"patient_id\"]');
                    break;
                case 'diagnosisSection':
                    loadPatientsForSelect('#patientSelect');
                    break;
                case 'patientRegistrationSection':
                    loadRecentPatients();
                    break;
                case 'prescriptionsSection':
                    loadPrescriptions();
                    break;
                case 'reportsSection':
                    loadReports();
                    break;
                case 'dashboardSection':
                    loadRecentActivity();
                    break;
            }
        }

        // Load recent activity
        async function loadRecentActivity() {
            try {
                const response = await fetch('api/doctor/get_recent_activity.php?doctor_id=' + currentDoctorId);
                const data = await response.json();
                
                const activityList = document.getElementById('recentActivityList');
                if (data.success && data.activities.length > 0) {
                    activityList.innerHTML = data.activities.map(activity => `
                        <div class="activity-item">
                            <strong>${activity.title}</strong>
                            <p class="mb-0 small text-muted">${activity.timestamp}</p>
                        </div>
                    `).join('');
                } else {
                    activityList.innerHTML = `
                        <div class="activity-item">
                            <strong>No recent activity</strong>
                            <p class="mb-0 small text-muted">Activity will appear here</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error loading activity:', error);
            }
        }

        // Load medical records
        async function loadMedicalRecords() {
            try {
                const response = await fetch('api/doctor/get_medical_records.php?doctor_id=' + currentDoctorId);
                const data = await response.json();
                
                const table = document.getElementById('medicalRecordsTable');
                if (data.success && data.records.length > 0) {
                    table.innerHTML = data.records.map(record => `
                        <tr>
                            <td>PAT-${record.patient_id}</td>
                            <td>${record.patient_name}</td>
                            <td>${record.diagnosis}</td>
                            <td><span class="badge bg-info">${record.disease}</span></td>
                            <td>${new Date(record.created_at).toLocaleDateString()}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">View</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    table.innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No medical records found
                            </td>
                        </tr>
                    `;
                }
            } catch (error) {
                console.error('Error loading medical records:', error);
            }
        }

        // Load appointments
        async function loadAppointments() {
            try {
                const response = await fetch('api/doctor/get_appointments.php?doctor_id=' + currentDoctorId);
                const data = await response.json();
                
                const table = document.getElementById('appointmentsTable');
                if (data.success && data.appointments.length > 0) {
                    table.innerHTML = data.appointments.map(appt => `
                        <tr>
                            <td>${appt.patient_name}</td>
                            <td>${new Date(appt.appointment_datetime).toLocaleString()}</td>
                            <td><span class="badge bg-${appt.status === 'scheduled' ? 'primary' : appt.status === 'completed' ? 'success' : 'secondary'}">${appt.status}</span></td>
                            <td>${appt.notes || '-'}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary me-1">Edit</button>
                                <button class="btn btn-sm btn-outline-danger">Cancel</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    table.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No appointments scheduled
                            </td>
                        </tr>
                    `;
                }
            } catch (error) {
                console.error('Error loading appointments:', error);
            }
        }

        // Load patients for select dropdowns
        async function loadPatientsForSelect(selector) {
            try {
                const response = await fetch('api/doctor/get_patients.php');
                const data = await response.json();
                
                const select = document.querySelector(selector);
                if (data.success && data.patients.length > 0) {
                    select.innerHTML = '<option value="">Select patient...</option>' + 
                        data.patients.map(patient => `
                            <option value="${patient.patient_id}">${patient.first_name} ${patient.last_name}</option>
                        `).join('');
                }
            } catch (error) {
                console.error('Error loading patients:', error);
            }
        }

        // Perform diagnosis
        async function performDiagnosis() {
            const patientId = document.getElementById('patientSelect').value;
            const diseaseType = document.getElementById('diseaseType').value;
            const symptoms = document.getElementById('symptoms').value;
            const notes = document.getElementById('diagnosisNotes').value;
            
            if (!patientId || !diseaseType || !symptoms) {
                alert('Please fill in all required fields');
                return;
            }
            
            const resultDiv = document.getElementById('diagnosisResult');
            resultDiv.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin me-2"></i>Analyzing symptoms...</div>';
            
            // Simulate AI diagnosis (replace with actual API call)
            setTimeout(() => {
                const diseases = {
                    'malaria': 'High probability of Malaria detected',
                    'typhoid': 'Typhoid fever suspected',
                    'both': 'Possible co-infection of Malaria and Typhoid',
                    'other': 'Symptoms indicate other medical condition'
                };
                
                const recommendation = diseases[diseaseType] || 'Further tests recommended';
                resultDiv.innerHTML = `
                    <div class="alert alert-success">
                        <h6><i class="fas fa-check-circle me-2"></i>Diagnosis Complete</h6>
                        <p class="mb-2"><strong>Result:</strong> ${recommendation}</p>
                        <p class="mb-1"><strong>Recommended Action:</strong> Laboratory confirmation required</p>
                        <p class="mb-0"><strong>Medication:</strong> Prescribe appropriate treatment</p>
                    </div>
                `;
            }, 2000);
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Load dashboard data
            loadRecentActivity();
            
            // Set up navigation
            document.querySelectorAll('.sidebar .nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    switchPanel(this.getAttribute('data-section'));
                });
            });
            
            // Set up quick action cards
            document.querySelectorAll('.quick-action-card').forEach(card => {
                card.style.cursor = 'pointer';
            });
        });

        // Simple notification function
        function showNotification(message, type = 'success') {
            const toast = new bootstrap.Toast(document.getElementById('profileToast'));
            document.getElementById('profileToastBody').textContent = message;
            document.getElementById('profileToast').className = `toast align-items-center text-white bg-${type} border-0`;
            toast.show();
        }
    </script>
</body>
</html>