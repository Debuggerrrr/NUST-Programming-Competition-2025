<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header('Location: index.php');
    exit();
}

// Welcome message logic
$welcome_message = '';
if (!isset($_SESSION['has_logged_in'])) {
    $welcome_message = 'Welcome, ' . ($_SESSION['first_name'] ?? $_SESSION['username']) . '!';
    $_SESSION['has_logged_in'] = true;
} else {
    $welcome_message = 'Welcome back, ' . ($_SESSION['first_name'] ?? $_SESSION['username']) . '!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="/MESMTF/styles.css">
<style>
    .edit-profile-sidebar {
        box-shadow: 0 0 20px rgba(0,0,0,0.15);
    }
</style>
</head>
<body>
    <!-- Toast Notification -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 2000">
        <div id="profileToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="profileToastBody">
                    Profile successfully updated!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Expert System Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--primary);">
        <div class="container">
            <a class="navbar-brand" href="patient_dashboard.php">
                <i class="fas fa-laptop-medical me-2"></i>MESMTF
            </a>
            <div class="d-flex align-items-center ms-auto">
                <div class="me-3 d-flex align-items-center">
                    <?php 
                        $profilePic = !empty($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
                        $imgPath = $profilePic ? (strpos($profilePic, 'images/profiles/') === 0 ? $profilePic : 'images/profiles/' . basename($profilePic)) : '';
                        if ($imgPath) {
                            echo '<img src="' . $imgPath . '" alt="Profile" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">';
                        } else {
                            echo '<i class="fas fa-user-circle fa-2x text-light"></i>';
                        }
                    ?>
                    <div class="ms-2 text-light">
                        <span class="fw-bold">
                            <?php 
                                $displayTitle = isset($_SESSION['title']) && !empty($_SESSION['title']) ? htmlspecialchars($_SESSION['title']) : '';
                                $displayUsername = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
                                echo trim($displayTitle . ' ' . $displayUsername);
                            ?>
                        </span>
                    </div>
                </div>
                <button id="openEditProfile" class="btn btn-outline-light me-2">Edit Profile</button>
                <a href="api/auth/login.php?action=logout" class="btn btn-danger">Logout</a>
            </div>
    </nav>
    <!-- Edit Profile Sidebar -->
    <div id="editProfileSidebar" class="edit-profile-sidebar bg-white shadow" style="position:fixed;top:0;right:-350px;width:350px;height:100vh;z-index:1050;transition:right 0.3s;overflow-y:auto;">
        <div class="p-4">
            <h4 class="mb-4 text-center">Edit Profile & Settings</h4>
            <form id="editProfileForm" method="POST" enctype="multipart/form-data" action="edit_profile.php">
                <?php
                require_once 'models/User.php';
                $sidebarUser = new User();
                $sidebarUser->getById($_SESSION['user_id']);
                ?>
                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control form-control-sm" id="username" name="username" value="<?php echo htmlspecialchars($sidebarUser->username); ?>" required>
                    </div>
                    <div class="col-12 mb-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter new password">
                    </div>
                    <div class="col-12 mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" value="<?php echo htmlspecialchars($sidebarUser->email); ?>" required>
                    </div>
                    <div class="col-6 mb-2">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control form-control-sm" id="first_name" name="first_name" value="<?php echo htmlspecialchars($sidebarUser->first_name); ?>" required>
                    </div>
                    <div class="col-6 mb-2">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control form-control-sm" id="last_name" name="last_name" value="<?php echo htmlspecialchars($sidebarUser->last_name); ?>" required>
                    </div>
                    <div class="col-6 mb-2">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control form-control-sm" id="title" name="title" value="<?php echo htmlspecialchars($sidebarUser->title); ?>" placeholder="e.g. Mr, Ms, Dr, Prof">
                    </div>
                    <?php if ($sidebarUser->role === 'doctor'): ?>
                    <div class="col-6 mb-2">
                        <label for="specialization" class="form-label">Specialization</label>
                        <input type="text" class="form-control form-control-sm" id="specialization" name="specialization" value="<?php echo htmlspecialchars($sidebarUser->specialization); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="col-12 mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control form-control-sm" id="profile_picture" name="profile_picture" accept="image/*">
                        <?php if (!empty($sidebarUser->profile_picture)): ?>
                            <div class="text-center mt-2 mb-2">
                                <img src="<?php echo htmlspecialchars($sidebarUser->profile_picture); ?>" alt="Profile" class="rounded-circle border" style="width:60px;height:60px;object-fit:cover;">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">Save Changes</button>
                <button type="button" id="closeEditProfile" class="btn btn-secondary w-100">Cancel</button>
            </form>
        </div>
    </div>
    <!-- Dashboard Container -->
    <div class="dashboard-container container-fluid py-4" id="dashboardContainer">
        <div class="row">
            <div class="col-md-3">
                <div class="card dashboard-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Navigation</h5>
                    </div>
                    <div class="list-group list-group-flush" id="dashboardTabs" style="background-color: var(--primary);">
                        <a href="#" class="list-group-item list-group-item-action active" data-section="dashboardSection">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" data-section="medicalRecordsSection">
                            <i class="fas fa-user-injured me-2"></i> Medical Records
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" data-section="appointmentsSection">
                            <i class="fas fa-calendar-check me-2"></i> Appointments
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" data-section="pharmacySection">
                            <i class="fas fa-pills me-2"></i> Pharmacy
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" data-section="reportsSection">
                            <i class="fas fa-file-medical me-2"></i> Reports
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" data-section="adminSection" id="adminSection" style="display: none;">
                            <i class="fas fa-cog me-2"></i> Administration
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Dashboard Content -->
                <div class="section-content" id="dashboardSection">
                    <div class="card dashboard-card">
                        <div class="card-header text-white" style="background-color: var(--primary);">
                            <h5 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info" role="alert">
                                <?php echo $welcome_message; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card bg-primary text-white text-center">
                                        <div class="card-body">
                                            <h2 id="patientCount">0</h2>
                                            <p>Total Patients</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="card bg-success text-white text-center">
                                        <div class="card-body">
                                            <h2 id="appointmentCount">0</h2>
                                            <p>Today's Appointments</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="mt-4">Recent Activities</h5>
                            <ul class="list-group" id="recentActivities">
                                <li class="list-group-item">No recent activities</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Medical Records Section -->
                <div class="section-content d-none" id="medicalRecordsSection">
                    <div class="card dashboard-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-user-injured me-2"></i> Medical Records</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                                    <i class="fas fa-plus me-2"></i> Add New Patient
                                </button>
                                <div class="w-50">
                                    <input type="text" class="form-control" placeholder="Search patients...">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Last Visit</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="patientsTable">
                                        <tr>
                                            <td colspan="6" class="text-center">No patients found</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointments Section -->
                <div class="section-content d-none" id="appointmentsSection">
                    <div class="card dashboard-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i> Appointments</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal">
                                    <i class="fas fa-plus me-2"></i> Book New Appointment
                                </button>
                                <div class="btn-group">
                                    <button class="btn btn-outline-primary active">Today</button>
                                    <button class="btn btn-outline-primary">This Week</button>
                                    <button class="btn btn-outline-primary">All</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Doctor</th>
                                            <th>Date & Time</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="appointmentsTable">
                                        <tr>
                                            <td colspan="5" class="text-center">No appointments scheduled</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diagnosis Section -->
                <div class="section-content d-none" id="diagnosisSection">
                    <div class="card dashboard-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-diagnoses me-2"></i> Diagnosis</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0">Patient Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Select Patient</label>
                                                <select class="form-select" id="patientSelect">
                                                    <option value="">-- Select Patient --</option>
                                                </select>
                                            </div>
                                            <div id="patientInfo" class="d-none">
                                                <h6>Patient Details</h6>
                                                <p><strong>Name:</strong> <span id="selectedPatientName">-</span></p>
                                                <p><strong>Age:</strong> <span id="selectedPatientAge">-</span></p>
                                                <p><strong>Gender:</strong> <span id="selectedPatientGender">-</span></p>
                                                <p><strong>Last Diagnosis:</strong> <span id="selectedPatientLastDiagnosis">-</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header text-white" style="background-color: var(--primary);">
                                            <h6 class="mb-0">Expert System Diagnosis</h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="expertDiagnosisResult">
                                                <p class="text-muted">Select a patient and symptoms to generate diagnosis</p>
                                            </div>
                                            <button class="btn btn-primary mt-3 w-100" data-bs-toggle="modal" data-bs-target="#symptomsModal">
                                                <i class="fas fa-stethoscope me-2"></i> Enter Symptoms
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">Diagnosis History</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Patient</th>
                                                            <th>Stock</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="drugInventoryTable">
                                                        <tr>
                                                            <td>Chloroquine</td>
                                                            <td><span class="badge bg-success">In Stock</span></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-outline-primary">Dispense</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Artemether</td>
                                                            <td><span class="badge bg-warning">Low Stock</span></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-outline-primary">Dispense</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ciprofloxacin</td>
                                                            <td><span class="badge bg-success">In Stock</span></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-outline-primary">Dispense</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0">Prescription</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Select Patient</label>
                                                <select class="form-select" id="prescriptionPatientSelect">
                                                    <option value="">-- Select Patient --</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Medication</label>
                                                <select class="form-select" id="medicationSelect">
                                                    <option value="">-- Select Medication --</option>
                                                    <option value="chloroquine">Chloroquine</option>
                                                    <option value="artemether">Artemether</option>
                                                    <option value="ciprofloxacin">Ciprofloxacin</option>
                                                    <option value="doxycycline">Doxycycline</option>
                                                    <option value="azithromycin">Azithromycin</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Dosage</label>
                                                        <input type="text" class="form-control" placeholder="e.g., 250mg">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Duration</label>
                                                        <input type="text" class="form-control" placeholder="e.g., 7 days">
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary w-100">
                                                <i class="fas fa-prescription me-2"></i> Generate Prescription
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">Recent Prescriptions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Patient</th>
                                                    <th>Medication</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>15/09/2025</td>
                                                    <td>John Doe</td>
                                                    <td>Chloroquine</td>
                                                    <td><span class="badge bg-success">Dispensed</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>14/09/2025</td>
                                                    <td>Jane Smith</td>
                                                    <td>Artemether</td>
                                                    <td><span class="badge bg-warning">Pending</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">View</button>
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

                <!-- Reports Section -->
                <div class="section-content d-none" id="reportsSection">
                    <div class="card dashboard-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-file-medical me-2"></i> Reports</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card bg-primary text-white text-center">
                                        <div class="card-body">
                                            <i class="fas fa-file-medical fa-3x mb-3"></i>
                                            <h5>Medical Reports</h5>
                                            <p>Generate patient medical history reports</p>
                                            <button class="btn btn-light">Generate</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-success text-white text-center">
                                        <div class="card-body">
                                            <i class="fas fa-prescription fa-3x mb-3"></i>
                                            <h5>Prescription Reports</h5>
                                            <p>View and print prescription reports</p>
                                            <button class="btn btn-light">Generate</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-info text-white text-center">
                                        <div class="card-body">
                                            <i class="fas fa-chart-line fa-3x mb-3"></i>
                                            <h5>Analytics Reports</h5>
                                            <p>View disease trends and statistics</p>
                                            <button class="btn btn-light">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">Sample Prescription</h6>
                                </div>
                                <div class="card-body">
                                    <div class="prescription-box">
                                        <div class="text-center mb-4">
                                            <h4>Ministry of Health and Social Services</h4>
                                            <h5>Medical Prescription</h5>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <p><strong>Patient Name:</strong> John Doe</p>
                                                <p><strong>Age:</strong> 35 years</p>
                                                <p><strong>Gender:</strong> Male</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Date:</strong> 15/09/2025</p>
                                                <p><strong>Prescription ID:</strong> RX-2025-0876</p>
                                                <p><strong>Doctor:</strong> Dr. Sarah Johnson</p>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Medication</th>
                                                        <th>Dosage</th>
                                                        <th>Frequency</th>
                                                        <th>Duration</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Chloroquine</td>
                                                        <td>250mg</td>
                                                        <td>Twice daily</td>
                                                        <td>7 days</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Paracetamol</td>
                                                        <td>500mg</td>
                                                        <td>As needed for fever</td>
                                                        <td>5 days</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mt-4">
                                            <p><strong>Instructions:</strong> Take after meals. Complete the full course of medication even if symptoms improve.</p>
                                            <p><strong>Next Visit:</strong> 22/09/2025</p>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <p>_________________________</p>
                                                <p><strong>Dr. Sarah Johnson</strong></p>
                                                <p>Medical Doctor</p>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <p>_________________________</p>
                                                <p><strong>Pharmacist Signature</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button class="btn btn-primary"><i class="fas fa-print me-2"></i> Print Prescription</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Section -->
                <div class="section-content d-none" id="adminSectionContent">
                    <div class="card dashboard-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-cog me-2"></i> Administration</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0">User Management</h6>
                                        </div>
                                        <div class="card-body">
                                            <p>Manage system users and their permissions</p>
                                            <button class="btn btn-primary w-100">Manage Users</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0">System Settings</h6>
                                        </div>
                                        <div class="card-body">
                                            <p>Configure system preferences and settings</p>
                                            <button class="btn btn-primary w-100">System Settings</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0">Database Management</h6>
                                        </div>
                                        <div class="card-body">
                                            <p>Backup and restore system database</p>
                                            <button class="btn btn-primary w-100">Database Tools</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">System Statistics</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            <h3>152</h3>
                                            <p>Total Patients</p>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <h3>47</h3>
                                            <p>Today's Appointments</p>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <h3>28</h3>
                                            <p>Malaria Cases</p>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <h3>19</h3>
                                            <p>Typhoid Cases</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Tab switching logic for dashboard
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('#dashboardTabs a');
    const sections = document.querySelectorAll('.section-content');
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            sections.forEach(section => {
                if (section.id === tab.getAttribute('data-section')) {
                    section.classList.remove('d-none');
                } else {
                    section.classList.add('d-none');
                }
            });
        });
    });

    // Sidebar logic
    var sidebar = document.getElementById('editProfileSidebar');
    var openBtn = document.getElementById('openEditProfile');
    var closeBtn = document.getElementById('closeEditProfile');
    if (openBtn) {
        openBtn.addEventListener('click', function() {
            sidebar.style.right = '0';
            // Fetch latest user info via AJAX
            fetch('api/auth/get_user.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('username').value = data.username;
                    document.getElementById('first_name').value = data.first_name;
                    document.getElementById('last_name').value = data.last_name;
                    document.getElementById('email').value = data.email;
                    document.getElementById('title').value = data.title;
                    if (document.getElementById('specialization')) {
                        document.getElementById('specialization').value = data.specialization;
                    }
                    // Update profile picture preview
                    var img = sidebar.querySelector('img[alt="Profile"]');
                    if (img && data.profile_picture) {
                        img.src = data.profile_picture;
                    }
                    // Update name/title display
                    var nameSpan = sidebar.querySelector('.ms-3 .fw-bold');
                    if (nameSpan) {
                        nameSpan.textContent = (data.title ? data.title + ' ' : '') + data.first_name + ' ' + data.last_name;
                    }
                });
        });
    }
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            sidebar.style.right = '-350px';
        });
    }
    // Optional: close sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (sidebar.style.right === '0' && !sidebar.contains(e.target) && e.target !== openBtn) {
            sidebar.style.right = '-350px';
        }
    });

    // AJAX submit for edit profile form
    var editForm = document.getElementById('editProfileForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(editForm);
            fetch('api/auth/edit_profile_ajax.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Profile successfully updated!');
                    sidebar.style.right = '-350px';
                    // Optionally update navbar info here
                } else {
                    showToast('Error: ' + (data.error || 'Could not update profile.'), true);
                }
            })
            .catch(() => {
                showToast('Error: Could not update profile.', true);
            });
        });
    }
    // Toast logic
    function showToast(message, isError) {
        var toastEl = document.getElementById('profileToast');
        var toastBody = document.getElementById('profileToastBody');
        toastBody.textContent = message;
        toastEl.classList.remove('bg-success', 'bg-danger');
        toastEl.classList.add(isError ? 'bg-danger' : 'bg-success');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
});
</script>
</body>
</html>