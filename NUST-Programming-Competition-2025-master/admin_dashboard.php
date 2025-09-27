<?php
// Only start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'receptionist'])) {
    header('Location: index.php');
    exit;
}

$role = $_SESSION['role'] ?? 'receptionist';
$user_name = $_SESSION['first_name'] ?? $_SESSION['username'] ?? 'User';

// Include your database configuration
require_once __DIR__ . '/config/database.php';

// Get real data from database using your existing $pdo connection
try {
    // Get today's appointments count
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as count 
        FROM appointments 
        WHERE DATE(appointment_datetime) = CURDATE() 
        AND status = 'scheduled'
    ");
    $stmt->execute();
    $todayAppointments = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get total patients count
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM patients");
    $totalPatients = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get active staff count
    $stmt = $pdo->query("
        SELECT COUNT(*) as count FROM users 
        WHERE is_active = 1 
        AND role IN ('doctor', 'nurse', 'pharmacist', 'receptionist', 'admin')
    ");
    $activeStaff = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get checked-in patients today
    $stmt = $pdo->prepare("
        SELECT COUNT(DISTINCT patient_id) as count 
        FROM appointments 
        WHERE DATE(appointment_datetime) = CURDATE() 
        AND status = 'completed'
    ");
    $stmt->execute();
    $checkedInToday = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get upcoming appointments
    $stmt = $pdo->prepare("
        SELECT a.*, p.first_name, p.last_name, d.first_name as doctor_first_name, d.last_name as doctor_last_name
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        JOIN doctors d ON a.doctor_id = d.doctor_id
        WHERE a.appointment_datetime >= NOW()
        AND a.status = 'scheduled'
        ORDER BY a.appointment_datetime ASC
        LIMIT 5
    ");
    $stmt->execute();
    $upcomingAppointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get recent patients
    $stmt = $pdo->query("
        SELECT p.*, u.created_at 
        FROM patients p 
        JOIN users u ON p.user_id = u.user_id 
        ORDER BY u.created_at DESC 
        LIMIT 4
    ");
    $recentPatients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get recent activity
    $stmt = $pdo->query("
        (SELECT 'appointment' as type, appointment_datetime as timestamp, 
                CONCAT('Appointment scheduled for ', p.first_name, ' ', p.last_name) as description
         FROM appointments a 
         JOIN patients p ON a.patient_id = p.patient_id 
         ORDER BY a.created_at DESC LIMIT 3)
        UNION
        (SELECT 'patient' as type, u.created_at as timestamp, 
                CONCAT('New patient registered: ', p.first_name, ' ', p.last_name) as description
         FROM patients p 
         JOIN users u ON p.user_id = u.user_id 
         ORDER BY u.created_at DESC LIMIT 2)
        ORDER BY timestamp DESC 
        LIMIT 5
    ");
    $recentActivity = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    $todayAppointments = 0;
    $totalPatients = 0;
    $activeStaff = 0;
    $checkedInToday = 0;
    $upcomingAppointments = [];
    $recentPatients = [];
    $recentActivity = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MESMTF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Add your existing CSS styles here */
        :root{ --aside-width: 280px; --panel-radius: 20px; --panel-bg: #ffffff; --muted: #94a3b8; }
        body{ background: #eef2f7; font-family: 'Segoe UI', system-ui, sans-serif; }
        .admin-shell{ display:flex; min-height: calc(100vh - 76px); gap:24px; padding:24px; }
        .admin-sidebar{ width:var(--aside-width); background:#0d6efd; border-radius:var(--panel-radius); color:#fff; padding:24px 20px; }
        .sidebar-nav{ display:flex; flex-direction:column; gap:8px; }
        .sidebar-nav .nav-link{ color:rgba(255,255,255,0.85); padding:12px 16px; border-radius:12px; transition:all 0.3s; }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active{ background:rgba(255,255,255,0.22); color:#fff; transform: translateX(5px); }
        .stat-card{ background:#fff; border-radius:15px; padding:20px; box-shadow:0 4px 15px rgba(0,0,0,0.05); transition:transform 0.3s; }
        .stat-card:hover{ transform: translateY(-2px); }
        .icon{ width:50px; height:50px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:24px; }
        .empty-state{ text-align:center; padding:40px 20px; color:#6c757d; }
        .loading-spinner { display: inline-block; width: 1rem; height: 1rem; border: 2px solid currentColor; border-right-color: transparent; border-radius: 50%; animation: spinner-border 0.75s linear infinite; }
        @keyframes spinner-border { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php"><i class="fas fa-hospital"></i> MESMTF System</a>
            <div class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($user_name); ?> (<?php echo htmlspecialchars($role); ?>)
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="index.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </li>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <section class="admin-shell">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <div class="avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <h2><?php echo htmlspecialchars($user_name); ?></h2>
                    <span class="badge bg-light text-primary"><?php echo htmlspecialchars($role); ?></span>
                </div>
            </div>
            <nav class="sidebar-nav">
                <a class="nav-link active" href="#" onclick="switchPanel('overview')"><i class="fas fa-tachometer-alt"></i> Overview</a>
                <a class="nav-link" href="#" onclick="switchPanel('appointments-panel')"><i class="fas fa-calendar-check"></i> Appointments</a>
                <?php if ($role === 'admin'): ?>
                <a class="nav-link" href="#" onclick="switchPanel('users-panel')"><i class="fas fa-users"></i> User Management</a>
                <a class="nav-link" href="#" onclick="switchPanel('reports-panel')"><i class="fas fa-chart-bar"></i> Reports</a>
                <?php endif; ?>
            </nav>
        </aside>
        
        <main class="admin-content">
            <!-- Overview Panel -->
            <div class="panel active" id="overview">
                <div class="row g-3 mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="icon bg-primary bg-opacity-10 text-primary me-3">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0"><?php echo $todayAppointments; ?></h3>
                                    <small class="text-muted">Today's Appointments</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="icon bg-success bg-opacity-10 text-success me-3">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0"><?php echo $checkedInToday; ?></h3>
                                    <small class="text-muted">Checked In Today</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="icon bg-info bg-opacity-10 text-info me-3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0"><?php echo $totalPatients; ?></h3>
                                    <small class="text-muted">Total Patients</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="icon bg-warning bg-opacity-10 text-warning me-3">
                                    <i class="fas fa-user-md"></i>
                                </div>
                                <div>
                                    <h3 class="mb-0"><?php echo $activeStaff; ?></h3>
                                    <small class="text-muted">Active Staff</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-calendar me-2"></i>Upcoming Appointments</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($upcomingAppointments)): ?>
                                    <?php foreach ($upcomingAppointments as $appointment): ?>
                                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                            <div>
                                                <strong><?php echo htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']); ?></strong>
                                                <div class="text-muted small">
                                                    With Dr. <?php echo htmlspecialchars($appointment['doctor_first_name'] . ' ' . $appointment['doctor_last_name']); ?>
                                                    • <?php echo date('M j, g:i A', strtotime($appointment['appointment_datetime'])); ?>
                                                </div>
                                            </div>
                                            <span class="badge bg-primary">Scheduled</span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-4 text-muted">
                                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                        <p>No upcoming appointments</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Activity</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recentActivity)): ?>
                                    <?php foreach ($recentActivity as $activity): ?>
                                        <div class="mb-3">
                                            <div class="small text-muted"><?php echo date('g:i A', strtotime($activity['timestamp'])); ?></div>
                                            <div class="fw-medium"><?php echo htmlspecialchars($activity['description']); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-4 text-muted">
                                        <i class="fas fa-history fa-2x mb-2"></i>
                                        <p>No recent activity</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments Panel -->
            <div class="panel d-none" id="appointments-panel">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Manage Appointments</h5>
                        <button class="btn btn-primary btn-sm" onclick="showAppointmentModal()">
                            <i class="fas fa-plus me-1"></i>New Appointment
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button class="btn btn-outline-primary active" onclick="filterAppointments('all')">All</button>
                                    <button class="btn btn-outline-primary" onclick="filterAppointments('today')">Today</button>
                                    <button class="btn btn-outline-primary" onclick="filterAppointments('upcoming')">Upcoming</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="appointmentSearch" placeholder="Search appointments...">
                                    <button class="btn btn-outline-secondary" onclick="searchAppointments()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
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
                                        <td colspan="5" class="text-center py-4">
                                            <div class="loading-spinner me-2"></div>
                                            Loading appointments...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($role === 'admin'): ?>
            <!-- User Management Panel -->
            <div class="panel d-none" id="users-panel">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i>User Management</h5>
                        <button class="btn btn-primary btn-sm" onclick="showUserModal()">
                            <i class="fas fa-plus me-1"></i>Add User
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="userSearch" placeholder="Search users...">
                            </div>
                            <div class="col-md-6">
                                <select class="form-select" id="roleFilter" onchange="filterUsers()">
                                    <option value="">All Roles</option>
                                    <option value="patient">Patient</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="usersTable">
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="loading-spinner me-2"></div>
                                            Loading users...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Panel -->
            <div class="panel d-none" id="reports-panel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Reports & Analytics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <div class="stat-card text-center">
                                    <div class="icon bg-primary bg-opacity-10 text-primary mx-auto mb-2">
                                        <i class="fas fa-user-injured"></i>
                                    </div>
                                    <h4 id="monthlyPatients">0</h4>
                                    <small class="text-muted">Monthly Patients</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card text-center">
                                    <div class="icon bg-success bg-opacity-10 text-success mx-auto mb-2">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <h4 id="appointmentRate">0%</h4>
                                    <small class="text-muted">Completion Rate</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card text-center">
                                    <div class="icon bg-info bg-opacity-10 text-info mx-auto mb-2">
                                        <i class="fas fa-stethoscope"></i>
                                    </div>
                                    <h4 id="totalDiagnoses">0</h4>
                                    <small class="text-muted">Diagnoses</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card text-center">
                                    <div class="icon bg-warning bg-opacity-10 text-warning mx-auto mb-2">
                                        <i class="fas fa-pills"></i>
                                    </div>
                                    <h4 id="totalPrescriptions">0</h4>
                                    <small class="text-muted">Prescriptions</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Appointment Trends</h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="appointmentsChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">User Distribution</h6>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="userDistributionChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </section>

    <!-- Add User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalTitle">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
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
                                <label class="form-label">Username *</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password *</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Role *</label>
                                <select class="form-select" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="patient">Patient</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" checked>
                                    <label class="form-check-label">Active User</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveUser()">Save User</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global variables
        let currentPanel = 'overview';
        let appointmentsChart = null;
        let userDistributionChart = null;

        // Panel switching
        function switchPanel(panelId) {
            document.querySelectorAll('.panel').forEach(panel => {
                panel.classList.add('d-none');
                panel.classList.remove('active');
            });
            document.querySelectorAll('.sidebar-nav .nav-link').forEach(link => {
                link.classList.remove('active');
            });
            
            document.getElementById(panelId).classList.remove('d-none');
            document.getElementById(panelId).classList.add('active');
            currentPanel = panelId;
            
            // Load panel data
            loadPanelData(panelId);
        }

        // Load data for specific panels
        function loadPanelData(panelId) {
            switch(panelId) {
                case 'appointments-panel':
                    loadAppointments();
                    break;
                case 'users-panel':
                    loadUsers();
                    break;
                case 'reports-panel':
                    loadReports();
                    break;
            }
        }

        // Load appointments
        async function loadAppointments(filter = 'all', search = '') {
            try {
                const response = await fetch(`api/admin/get_appointments.php?filter=${filter}&search=${encodeURIComponent(search)}`);
                const data = await response.json();
                
                const table = document.getElementById('appointmentsTable');
                if (data.success && data.appointments.length > 0) {
                    table.innerHTML = data.appointments.map(appt => `
                        <tr>
                            <td>${escapeHtml(appt.first_name)} ${escapeHtml(appt.last_name)}</td>
                            <td>Dr. ${escapeHtml(appt.doctor_first_name)} ${escapeHtml(appt.doctor_last_name)}</td>
                            <td>${new Date(appt.appointment_datetime).toLocaleString()}</td>
                            <td><span class="badge bg-${getStatusColor(appt.status)}">${appt.status}</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="editAppointment(${appt.appointment_id})">Edit</button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteAppointment(${appt.appointment_id})">Delete</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    table.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-muted">No appointments found</td></tr>';
                }
            } catch (error) {
                console.error('Error loading appointments:', error);
                showNotification('Error loading appointments', 'error');
            }
        }

        // Load users
        async function loadUsers(search = '', role = '') {
            try {
                const response = await fetch(`api/admin/get_users.php?search=${encodeURIComponent(search)}&role=${encodeURIComponent(role)}`);
                const data = await response.json();
                
                const table = document.getElementById('usersTable');
                if (data.success && data.users.length > 0) {
                    table.innerHTML = data.users.map(user => `
                        <tr>
                            <td>${escapeHtml(user.first_name)} ${escapeHtml(user.last_name)}</td>
                            <td>${escapeHtml(user.email)}</td>
                            <td><span class="badge bg-${getRoleColor(user.role)}">${user.role}</span></td>
                            <td><span class="badge bg-${user.is_active ? 'success' : 'secondary'}">${user.is_active ? 'Active' : 'Inactive'}</span></td>
                            <td>${new Date(user.created_at).toLocaleDateString()}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="editUser(${user.user_id})">Edit</button>
                                <button class="btn btn-sm btn-outline-${user.is_active ? 'danger' : 'success'}" 
                                        onclick="${user.is_active ? 'deactivateUser' : 'activateUser'}(${user.user_id})">
                                    ${user.is_active ? 'Deactivate' : 'Activate'}
                                </button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    table.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">No users found</td></tr>';
                }
            } catch (error) {
                console.error('Error loading users:', error);
                showNotification('Error loading users', 'error');
            }
        }

        // Load reports
        async function loadReports() {
            // Initialize charts
            initCharts();
        }

        // Initialize charts
        function initCharts() {
            const appointmentsCtx = document.getElementById('appointmentsChart');
            const userDistCtx = document.getElementById('userDistributionChart');
            
            if (appointmentsChart) appointmentsChart.destroy();
            if (userDistributionChart) userDistributionChart.destroy();
            
            // Simple demo charts - replace with real data
            appointmentsChart = new Chart(appointmentsCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Appointments',
                        data: [65, 59, 80, 81, 56, 72],
                        borderColor: '#0d6efd',
                        tension: 0.1
                    }]
                }
            });
            
            userDistributionChart = new Chart(userDistCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Patients', 'Doctors', 'Nurses', 'Admins'],
                    datasets: [{
                        data: [40, 25, 20, 15],
                        backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545']
                    }]
                }
            });
        }

        // User management functions
        function showUserModal() {
            document.getElementById('userModalTitle').textContent = 'Add New User';
            document.getElementById('userForm').reset();
            new bootstrap.Modal(document.getElementById('userModal')).show();
        }

        async function saveUser() {
            const formData = new FormData(document.getElementById('userForm'));
            const userData = Object.fromEntries(formData);
            userData.is_active = document.querySelector('input[name="is_active"]').checked;
            
            try {
                const response = await fetch('api/admin/add_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(userData)
                });
                
                const result = await response.json();
                if (result.success) {
                    showNotification('User added successfully!', 'success');
                    bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
                    loadUsers();
                } else {
                    showNotification('Error: ' + result.error, 'error');
                }
            } catch (error) {
                showNotification('Error saving user', 'error');
            }
        }

        // Utility functions
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function getStatusColor(status) {
            const colors = { 'scheduled': 'primary', 'completed': 'success', 'cancelled': 'secondary' };
            return colors[status] || 'secondary';
        }

        function getRoleColor(role) {
            const colors = { 'admin': 'danger', 'doctor': 'info', 'nurse': 'warning', 'patient': 'primary' };
            return colors[role] || 'secondary';
        }

        function showNotification(message, type = 'info') {
            const alertClass = type === 'error' ? 'alert-danger' : type === 'success' ? 'alert-success' : 'alert-info';
            const alert = document.createElement('div');
            alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
            alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alert.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            setTimeout(() => alert.remove(), 5000);
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Load initial data for active panel
            loadPanelData(currentPanel);
            
            // Search functionality
            document.getElementById('appointmentSearch').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') searchAppointments();
            });
            
            document.getElementById('userSearch').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') filterUsers();
            });
        });

        // Filter functions
        function filterAppointments(filter) {
            const search = document.getElementById('appointmentSearch').value;
            loadAppointments(filter, search);
        }

        function searchAppointments() {
            const filter = document.querySelector('#appointments-panel .btn-group .btn.active').dataset.filter;
            const search = document.getElementById('appointmentSearch').value;
            loadAppointments(filter, search);
        }

        function filterUsers() {
            const search = document.getElementById('userSearch').value;
            const role = document.getElementById('roleFilter').value;
            loadUsers(search, role);
        }
    </script>
</body>
</html>