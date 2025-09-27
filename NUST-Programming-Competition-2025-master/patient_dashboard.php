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
    <title>MESMTF Patient Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar { background: #fff; border-radius: 1rem; box-shadow: 0 2px 16px rgba(0,0,0,0.07); }
        .sidebar .nav-link.active { background: #0d6efd; color: #fff; }
        .dashboard-header { background: linear-gradient(90deg, #0d6efd 60%, #198754 100%); color: #fff; border-radius: 1rem; }
        .summary-card { border-radius: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .section-title { font-weight: 600; margin-bottom: 1rem; }
        .card-header { font-weight: 500; }
        .profile-pic { width: 48px; height: 48px; object-fit: cover; border-radius: 50%; border: 2px solid #fff; }
        .welcome-msg { font-size: 1.2rem; font-weight: 500; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-header mb-4">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-laptop-medical me-2"></i>MESMTF Patient Portal</a>
            <div class="d-flex align-items-center ms-auto">
                <?php
                    $profilePic = !empty($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : '';
                    // Use default if not set
                    $imgPath = $profilePic ? (strpos($profilePic, 'images/') === 0 ? $profilePic : 'images/profiles/' . basename($profilePic)) : 'images/default_avatar.png';
                ?>
                <img src="<?php echo htmlspecialchars($imgPath); ?>" alt="Profile" class="profile-pic me-2">
                <span class="text-light fw-bold me-3">
                    <?php echo htmlspecialchars($_SESSION['first_name'] ?? $_SESSION['username']); ?>
                </span>
                <a href="#" class="btn btn-outline-light me-2" id="openEditProfile">Edit Profile</a>
                <a href="api/auth/login.php?action=logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-md-3 mb-3">
                <div class="sidebar p-3">
                    <h5 class="mb-4 text-primary"><i class="fas fa-bars me-2"></i>Navigation</h5>
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="#" data-section="dashboardSection"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                        <a class="nav-link" href="#" data-section="medicalRecordsSection"><i class="fas fa-user-injured me-2"></i> Medical Records</a>
                        <a class="nav-link" href="#" data-section="appointmentsSection"><i class="fas fa-calendar-check me-2"></i> Appointments</a>
                        <a class="nav-link" href="#" data-section="diagnosisSection"><i class="fas fa-diagnoses me-2"></i> Diagnosis</a>
                        <a class="nav-link" href="#" data-section="treatmentSection"><i class="fas fa-notes-medical me-2"></i> Treatment</a>
                        <a class="nav-link" href="#" data-section="pharmacySection"><i class="fas fa-pills me-2"></i> Pharmacy</a>
                        <a class="nav-link" href="#" data-section="drugAdminSection"><i class="fas fa-syringe me-2"></i> Drug Administration</a>
                        <a class="nav-link" href="#" data-section="reportsSection"><i class="fas fa-file-medical me-2"></i> Reports</a>
                        <a class="nav-link" href="#" data-section="databaseSection"><i class="fas fa-database me-2"></i> Databases</a>
                    </nav>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Dashboard Section -->
                <div class="section-content" id="dashboardSection">
                    <div class="card summary-card mb-4">
                        <div class="card-body">
                            <div class="welcome-msg mb-3">
                                <?php echo $welcome_message; ?>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card text-center bg-primary text-white summary-card">
                                        <div class="card-body">
                                            <i class="fas fa-users fa-2x mb-2"></i>
                                            <h4 id="patientCount">0</h4>
                                            <p>Registered Patients</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center bg-success text-white summary-card">
                                        <div class="card-body">
                                            <i class="fas fa-calendar-day fa-2x mb-2"></i>
                                            <h4 id="appointmentCount">0</h4>
                                            <p>Today's Appointments</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center bg-info text-white summary-card">
                                        <div class="card-body">
                                            <i class="fas fa-chart-line fa-2x mb-2"></i>
                                            <h4 id="analyticsCount">0</h4>
                                            <p>Analytics Reports</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="section-title mt-4">Recent Activities</h5>
                            <ul class="list-group" id="recentActivities">
                                <li class="list-group-item">No recent activities</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Medical Records Section -->
                <div class="section-content d-none" id="medicalRecordsSection">
                    <div class="card summary-card">
                        <div class="card-header bg-primary text-white"><i class="fas fa-user-injured me-2"></i> Medical Records</div>
                        <div class="card-body">
                            <p>View and manage your medical records. Authorized users can upload, edit, delete, and search records.</p>
                            <!-- Table placeholder -->
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Last Visit</th><th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="patientsTable">
                                        <tr><td colspan="6" class="text-center">No records found</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Appointments Section -->
                <div class="section-content d-none" id="appointmentsSection">
                    <div class="card summary-card">
                        <div class="card-header bg-success text-white"><i class="fas fa-calendar-check me-2"></i> Appointments</div>
                        <div class="card-body">
                            <p>Book, view, or modify appointments with doctors.</p>
                            <!-- Table placeholder -->
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Doctor</th><th>Date & Time</th><th>Status</th><th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="appointmentsTable">
                                        <tr><td colspan="4" class="text-center">No appointments scheduled</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Diagnosis Section -->
                <div class="section-content d-none" id="diagnosisSection">
                    <div class="card summary-card mb-4">
                        <div class="card-header bg-info text-white"><i class="fas fa-diagnoses me-2"></i> Diagnosis</div>
                        <div class="card-body">
                            <p>Enter symptoms for Malaria, Typhoid, or other diseases. The system will recommend diagnosis and treatment. <b>Very Strong Signs (VSs)</b> require chest X-ray in addition to drug administration.</p>
                            <form id="symptomEntryForm" class="mb-3">
                                <div class="mb-2">
                                    <label for="diseaseSelect" class="form-label">Select Disease</label>
                                    <select class="form-select" id="diseaseSelect" name="disease">
                                        <option value="malaria">Malaria</option>
                                        <option value="typhoid">Typhoid</option>
                                        <option value="tb">Tuberculosis (TB)</option>
                                        <option value="hiv">HIV/AIDS</option>
                                        <option value="mental">Mental Health</option>
                                        <option value="diabetes">Diabetes</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="symptomsInput" class="form-label">Enter Symptoms (comma separated)</label>
                                    <input type="text" class="form-control" id="symptomsInput" name="symptoms" placeholder="e.g. headache, fever, abdominal pain">
                                </div>
                                <button type="button" class="btn btn-primary" id="diagnoseBtn"><i class="fas fa-stethoscope me-2"></i> Diagnose</button>
                            </form>
                            <div id="diagnosisResult" class="alert alert-info d-none"></div>
                            <!-- Symptoms Table -->
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Signs</th>
                                            <th>Malaria Symptoms</th>
                                            <th>Typhoid Symptoms</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Very Strong Signs (VSs)</td>
                                            <td>Abdominal pain, Vomiting, Sore throat</td>
                                            <td>Abdominal pain, Stomach issues</td>
                                        </tr>
                                        <tr>
                                            <td>Strong Signs (Ss)</td>
                                            <td>Headache, Fatigue, Cough, Constipation</td>
                                            <td>Headache, Persistent high fever</td>
                                        </tr>
                                        <tr>
                                            <td>Weak Signs (Ws)</td>
                                            <td>Chest pain, Back pain, Muscle Pain</td>
                                            <td>Weakness, Tiredness</td>
                                        </tr>
                                        <tr>
                                            <td>Very Weak Signs (VWs)</td>
                                            <td>Diarrhea, sweating, rash, Loss of appetite</td>
                                            <td>Rash, Loss of appetite</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">Malaria Treatment Drugs</div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Artemether-lumefantrine</li>
                                                <li>Chloroquine</li>
                                                <li>Quinine</li>
                                                <li>Doxycycline</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">Typhoid Treatment Drugs</div>
                                        <div class="card-body">
                                            <ul>
                                                <li>Ciprofloxacin</li>
                                                <li>Azithromycin</li>
                                                <li>Ceftriaxone</li>
                                                <li>Amoxicillin</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">Other Diseases</div>
                                        <div class="card-body">
                                            <p>System supports diagnosis for TB, HIV/AIDS, Mental Health, Diabetes, etc. Enter symptoms and select disease above.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-warning text-dark">Chest X-ray Requirement</div>
                                        <div class="card-body">
                                            <p>If <b>Very Strong Signs (VSs)</b> are detected, a chest X-ray is required in addition to drug administration.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Treatment Section -->
                <div class="section-content d-none" id="treatmentSection">
                    <div class="card summary-card">
                        <div class="card-header bg-warning text-dark"><i class="fas fa-notes-medical me-2"></i> Treatment</div>
                        <div class="card-body">
                            <p>View prescribed treatments and instructions from your doctor.</p>
                            <!-- Placeholder for treatment info -->
                            <div class="alert alert-info">No treatment records found.</div>
                        </div>
                    </div>
                </div>
                <!-- Pharmacy Section -->
                <div class="section-content d-none" id="pharmacySection">
                    <div class="card summary-card">
                        <div class="card-header bg-secondary text-white"><i class="fas fa-pills me-2"></i> Pharmacy</div>
                        <div class="card-body">
                            <p>View and manage pharmaceutical services and prescriptions.</p>
                            <!-- Placeholder for pharmacy info -->
                            <div class="alert alert-info">No pharmacy records found.</div>
                        </div>
                    </div>
                </div>
                <!-- Drug Administration Section -->
                <div class="section-content d-none" id="drugAdminSection">
                    <div class="card summary-card">
                        <div class="card-header bg-info text-white"><i class="fas fa-syringe me-2"></i> Drug Administration</div>
                        <div class="card-body">
                            <p>View drug administration history and upcoming schedules.</p>
                            <!-- Placeholder for drug administration info -->
                            <div class="alert alert-info">No drug administration records found.</div>
                        </div>
                    </div>
                </div>
                <!-- Reports Section -->
                <div class="section-content d-none" id="reportsSection">
                    <div class="card summary-card">
                        <div class="card-header bg-primary text-white"><i class="fas fa-file-medical me-2"></i> Reports</div>
                        <div class="card-body">
                            <p>Generate and view medical, prescription, and analytics reports.</p>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-primary text-white text-center summary-card">
                                        <div class="card-body">
                                            <i class="fas fa-file-medical fa-2x mb-2"></i>
                                            <h6>Medical Reports</h6>
                                            <button class="btn btn-light btn-sm mt-2">Generate</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-success text-white text-center summary-card">
                                        <div class="card-body">
                                            <i class="fas fa-prescription fa-2x mb-2"></i>
                                            <h6>Prescription Reports</h6>
                                            <button class="btn btn-light btn-sm mt-2">Generate</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-info text-white text-center summary-card">
                                        <div class="card-body">
                                            <i class="fas fa-chart-line fa-2x mb-2"></i>
                                            <h6>Analytics Reports</h6>
                                            <button class="btn btn-light btn-sm mt-2">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Database Section -->
                <div class="section-content d-none" id="databaseSection">
                    <div class="card summary-card">
                        <div class="card-header bg-dark text-white"><i class="fas fa-database me-2"></i> Databases</div>
                        <div class="card-body">
                            <p>Manage your data. Admin users can add, edit, delete, and view all interfaces.</p>
                            <div class="alert alert-info">Database management tools coming soon.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile Sidebar -->
    <div id="editProfileSidebar" class="edit-profile-sidebar bg-white shadow" style="position:fixed;top:0;right:-350px;width:350px;height:100vh;z-index:1050;transition:right 0.3s;overflow-y:auto;">
        <div class="p-4">
            <h4 class="mb-4 text-center">Edit Profile & Settings</h4>
            <form id="editProfileForm" method="POST" enctype="multipart/form-data" action="edit_profile.php">
                <?php
                require_once 'models/User.php';
                $sidebarUser = new User();
                $sidebarUser->getById($_SESSION['user_id']);
                // Determine sidebar profile picture
                $sidebarProfilePic = !empty($sidebarUser->profile_picture) ? $sidebarUser->profile_picture : 'images/default_avatar.png';
                if ($sidebarProfilePic && strpos($sidebarProfilePic, 'images/') !== 0) {
                    $sidebarProfilePic = 'images/profiles/' . basename($sidebarProfilePic);
                }
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
                        <div class="text-center mt-2 mb-2">
                            <img src="<?php echo htmlspecialchars($sidebarProfilePic); ?>" alt="Profile" class="rounded-circle border" style="width:60px;height:60px;object-fit:cover;">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-2">Save Changes</button>
                <button type="button" id="closeEditProfile" class="btn btn-secondary w-100">Cancel</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Tab switching logic for dashboard
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.sidebar .nav-link');
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
                        if (img) {
                            if (data.profile_picture && data.profile_picture !== '') {
                                let picPath = (data.profile_picture.startsWith('images/')) ? data.profile_picture : 'images/profiles/' + data.profile_picture.split('/').pop();
                                img.src = picPath;
                            } else {
                                img.src = 'images/default_avatar.png';
                            }
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
        // Diagnosis logic
        document.getElementById('diagnoseBtn').addEventListener('click', function() {
            var disease = document.getElementById('diseaseSelect').value;
            var symptoms = document.getElementById('symptomsInput').value.toLowerCase();
            var result = '';
            var vssMalaria = ['abdominal pain','vomiting','sore throat'];
            var vssTyphoid = ['abdominal pain','stomach issues'];
            var vssDetected = false;
            if (disease === 'malaria') {
                vssMalaria.forEach(function(s) { if (symptoms.includes(s)) vssDetected = true; });
                result = vssDetected
                    ? 'Very Strong Signs detected. <b>Chest X-ray required</b> and drug administration recommended.'
                    : 'No Very Strong Signs detected. Drug administration only recommended.';
            } else if (disease === 'typhoid') {
                vssTyphoid.forEach(function(s) { if (symptoms.includes(s)) vssDetected = true; });
                result = vssDetected
                    ? 'Very Strong Signs detected. <b>Chest X-ray required</b> and drug administration recommended.'
                    : 'No Very Strong Signs detected. Drug administration only recommended.';
            } else {
                result = 'Diagnosis for selected disease will be shown here. Please consult a doctor for further steps.';
            }
            var diagRes = document.getElementById('diagnosisResult');
            diagRes.innerHTML = result;
            diagRes.classList.remove('d-none');
        });
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