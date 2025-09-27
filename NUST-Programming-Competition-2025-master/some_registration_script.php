<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Database connection
require_once 'config/database.php';

// Fetch all users for display
$stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'patient'");
$stmt->execute();
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Patients</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar { background: #fff; border-radius: 1rem; box-shadow: 0 2px 16px rgba(0,0,0,0.07); }
        .sidebar .nav-link.active { background: #0d6efd; color: #fff; }
        .dashboard-header { background: linear-gradient(90deg, #0d6efd 60%, #198754 100%); color: #fff; border-radius: 1rem; }
        .summary-card { border-radius: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .profile-pic { width: 48px; height: 48px; object-fit: cover; border-radius: 50%; border: 2px solid #fff; }
        .section-title { font-weight: 600; margin-bottom: 1rem; }
        .card-header { font-weight: 500; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-header mb-4">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-user-shield me-2"></i>MESMTF Admin Portal</a>
            <div class="d-flex align-items-center ms-auto">
                <?php
                    $profile_picture = $_SESSION['profile_picture'] ?? 'images/default_avatar.png';
                ?>
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-pic me-2">
                <span class="text-light fw-bold me-3">
                    Admin <?php echo htmlspecialchars($_SESSION['first_name'] ?? '') . ' ' . htmlspecialchars($_SESSION['last_name'] ?? ''); ?>
                </span>
                <a href="edit_profile.php" class="btn btn-outline-light me-2">Edit Profile</a>
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
                        <a class="nav-link" href="admin_dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                        <a class="nav-link active" href="javascript:void(0);" data-section="managePatientsSection"><i class="fas fa-user-shield me-2"></i> Manage Patients</a>
                        <a class="nav-link" href="javascript:void(0);" data-section="manageDoctorsSection"><i class="fas fa-user-md me-2"></i> Manage Doctors</a>
                        <a class="nav-link" href="javascript:void(0);" data-section="manageNursesSection"><i class="fas fa-user-nurse me-2"></i> Manage Nurses</a>
                        <a class="nav-link" href="javascript:void(0);" data-section="managePharmacistsSection"><i class="fas fa-user-plus me-2"></i> Manage Pharmacists</a>
                        <a class="nav-link" href="javascript:void(0);" data-section="appointmentsSection"><i class="fas fa-calendar-check me-2"></i> Appointments</a>
                        <a class="nav-link" href="javascript:void(0);" data-section="reportsSection"><i class="fas fa-file-medical me-2"></i> Reports</a>
                        <a class="nav-link" href="javascript:void(0);" data-section="databaseSection"><i class="fas fa-database me-2"></i> Databases</a>
                    </nav>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Manage Patients Section -->
                <div class="section-content" id="managePatientsSection">
                    <div class="card summary-card mb-4">
                        <div class="card-body">
                            <h4 class="section-title">Manage Patients</h4>
                            <div class="mb-3">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPatientModal"><i class="fas fa-plus me-1"></i> Add New Patient</button>
                            </div>
                            <!-- Patients Table -->
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($patients as $patient): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($patient['user_id']); ?></td>
                                            <td><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></td>
                                            <td><?php echo htmlspecialchars($patient['email']); ?></td>
                                            <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewPatientModal" data-id="<?php echo $patient['user_id']; ?>"><i class="fas fa-eye"></i> View</button>
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPatientModal" data-id="<?php echo $patient['user_id']; ?>"><i class="fas fa-edit"></i> Edit</button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePatientModal" data-id="<?php echo $patient['user_id']; ?>"><i class="fas fa-trash"></i> Delete</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Other sections (Manage Doctors, Nurses, etc.) will be similar to Manage Patients section -->
            </div>
        </div>
    </div>

    <!-- Add Patient Modal -->
    <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPatientForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Patient</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Patient Modal -->
    <div class="modal fade" id="viewPatientModal" tabindex="-1" aria-labelledby="viewPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPatientModalLabel">Patient Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Patient details will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Patient Modal -->
    <div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPatientForm">
                        <input type="hidden" id="edit_user_id" name="user_id">
                        <div class="mb-3">
                            <label for="edit_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="edit_username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="edit_date_of_birth" name="date_of_birth" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_gender" class="form-label">Gender</label>
                            <select class="form-select" id="edit_gender" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="edit_address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Patient Modal -->
    <div class="modal fade" id="deletePatientModal" tabindex="-1" aria-labelledby="deletePatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePatientModalLabel">Delete Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this patient? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeletePatient">Delete</button>
                </div>
            </div>
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

        // Add Patient form submission
        document.getElementById('addPatientForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            fetch('api/admin/add_patient.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal and refresh patient table
                    var addModal = bootstrap.Modal.getInstance(document.getElementById('addPatientModal'));
                    addModal.hide();
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // View Patient details
        document.getElementById('viewPatientModal').addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-id');
            var modalBody = this.querySelector('.modal-body');
            modalBody.innerHTML = 'Loading...';
            fetch('api/admin/get_patient.php?user_id=' + userId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        var patient = data.patient;
                        modalBody.innerHTML = `
                            <p><strong>Name:</strong> ${patient.first_name} ${patient.last_name}</p>
                            <p><strong>Email:</strong> ${patient.email}</p>
                            <p><strong>Phone:</strong> ${patient.phone}</p>
                            <p><strong>Date of Birth:</strong> ${patient.date_of_birth}</p>
                            <p><strong>Gender:</strong> ${patient.gender}</p>
                            <p><strong>Address:</strong> ${patient.address}</p>
                        `;
                    } else {
                        modalBody.innerHTML = 'Error loading details.';
                    }
                })
                .catch(error => {
                    modalBody.innerHTML = 'Error loading details.';
                    console.error('Error:', error);
                });
        });

        // Edit Patient form population
        document.getElementById('editPatientModal').addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-id');
            var modal = this;
            fetch('api/admin/get_patient.php?user_id=' + userId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        var patient = data.patient;
                        modal.querySelector('#edit_user_id').value = patient.user_id;
                        modal.querySelector('#edit_username').value = patient.username;
                        modal.querySelector('#edit_email').value = patient.email;
                        modal.querySelector('#edit_first_name').value = patient.first_name;
                        modal.querySelector('#edit_last_name').value = patient.last_name;
                        modal.querySelector('#edit_date_of_birth').value = patient.date_of_birth;
                        modal.querySelector('#edit_gender').value = patient.gender;
                        modal.querySelector('#edit_address').value = patient.address;
                        modal.querySelector('#edit_phone').value = patient.phone;
                    } else {
                        alert('Error loading patient data.');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Edit Patient form submission
        document.getElementById('editPatientForm').addEventListener('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            fetch('api/admin/edit_patient.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal and refresh patient table
                    var editModal = bootstrap.Modal.getInstance(document.getElementById('editPatientModal'));
                    editModal.hide();
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Delete Patient
        document.getElementById('deletePatientModal').addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-id');
            var confirmButton = document.getElementById('confirmDeletePatient');
            confirmButton.setAttribute('data-id', userId);
        });

        document.getElementById('confirmDeletePatient').addEventListener('click', function() {
            var userId = this.getAttribute('data-id');
            fetch('api/admin/delete_patient.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal and refresh patient table
                    var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deletePatientModal'));
                    deleteModal.hide();
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
    </script>
</body>
</html>