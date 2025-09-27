<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pharmacist') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MESMTF Pharmacist Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .edit-profile-sidebar { position:fixed; top:0; right:-350px; width:350px; height:100vh; z-index:1050; transition:right 0.3s; overflow-y:auto; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-header mb-4">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-pills me-2"></i>MESMTF Pharmacist Portal</a>
            <div class="d-flex align-items-center ms-auto">
                <?php
                    $profile_picture = $_SESSION['profile_picture'] ?? 'images/default_avatar.png';
                ?>
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-pic me-2">
                <span class="text-light fw-bold me-3">
                    <?php echo htmlspecialchars($_SESSION['first_name'] ?? $_SESSION['username']); ?>
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
                        <a class="nav-link active" href="#" data-section="dashboardSection"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                        <a class="nav-link" href="#" data-section="inventorySection"><i class="fas fa-capsules me-2"></i> Inventory</a>
                        <a class="nav-link" href="#" data-section="dispenseSection"><i class="fas fa-prescription-bottle me-2"></i> Dispense Drugs</a>
                        <a class="nav-link" href="#" data-section="prescriptionsSection"><i class="fas fa-file-prescription me-2"></i> Prescriptions</a>
                        <a class="nav-link" href="#" data-section="reportsSection"><i class="fas fa-file-medical me-2"></i> Reporting</a>
                    </nav>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Dashboard Section -->
                <div class="section-content" id="dashboardSection">
                    <div class="card summary-card mb-4">
                        <div class="card-body">
                            <h4 class="section-title">Welcome, <?php echo htmlspecialchars($_SESSION['first_name'] ?? $_SESSION['username']); ?></h4>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card text-center bg-primary text-white summary-card">
                                        <div class="card-body">
                                            <i class="fas fa-capsules fa-2x mb-2"></i>
                                            <h4>120</h4>
                                            <p>Drugs in Inventory</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center bg-success text-white summary-card">
                                        <div class="card-body">
                                            <i class="fas fa-prescription-bottle fa-2x mb-2"></i>
                                            <h4>35</h4>
                                            <p>Drugs Dispensed Today</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center bg-info text-white summary-card">
                                        <div class="card-body">
                                            <i class="fas fa-file-prescription fa-2x mb-2"></i>
                                            <h4>22</h4>
                                            <p>Prescriptions</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="section-title mt-4">Quick Actions</h5>
                            <div>
                                <a href="#" class="btn btn-success me-2 mb-2"><i class="fas fa-capsules me-1"></i> Manage Inventory</a>
                                <a href="#" class="btn btn-info me-2 mb-2"><i class="fas fa-prescription-bottle me-1"></i> Dispense Drugs</a>
                                <a href="#" class="btn btn-warning me-2 mb-2"><i class="fas fa-file-prescription me-1"></i> View Prescriptions</a>
                                <a href="#" class="btn btn-secondary mb-2"><i class="fas fa-file-medical me-1"></i> Generate Report</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Inventory Section -->
                <div class="section-content d-none" id="inventorySection">
                    <div class="card summary-card">
                        <div class="card-header bg-primary text-white"><i class="fas fa-capsules me-2"></i> Inventory</div>
                        <div class="card-body">
                            <p>Manage pharmacy inventory: add, edit, delete drugs.</p>
                            <div class="alert alert-info">Inventory management interface coming soon.</div>
                        </div>
                    </div>
                </div>
                <!-- Dispense Drugs Section -->
                <div class="section-content d-none" id="dispenseSection">
                    <div class="card summary-card">
                        <div class="card-header bg-success text-white"><i class="fas fa-prescription-bottle me-2"></i> Dispense Drugs</div>
                        <div class="card-body">
                            <p>Dispense drugs to patients and update records.</p>
                            <div class="alert alert-info">Dispensing interface coming soon.</div>
                        </div>
                    </div>
                </div>
                <!-- Prescriptions Section -->
                <div class="section-content d-none" id="prescriptionsSection">
                    <div class="card summary-card">
                        <div class="card-header bg-info text-white"><i class="fas fa-file-prescription me-2"></i> Prescriptions</div>
                        <div class="card-body">
                            <p>View and manage prescriptions from doctors.</p>
                            <div class="alert alert-info">Prescriptions interface coming soon.</div>
                        </div>
                    </div>
                </div>
                <!-- Reporting Section -->
                <div class="section-content d-none" id="reportsSection">
                    <div class="card summary-card">
                        <div class="card-header bg-secondary text-white"><i class="fas fa-file-medical me-2"></i> Reporting</div>
                        <div class="card-body">
                            <p>Generate and print pharmacy reports.</p>
                            <div class="alert alert-info">Reporting interface coming soon.</div>
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
                    <?php if ($sidebarUser->role === 'pharmacist'): ?>
                    <div class="col-6 mb-2">
                        <label for="license_number" class="form-label">License Number</label>
                        <input type="text" class="form-control form-control-sm" id="license_number" name="license_number" value="<?php echo htmlspecialchars($sidebarUser->license_number); ?>">
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
                fetch('api/auth/get_user.php')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('username').value = data.username;
                        document.getElementById('first_name').value = data.first_name;
                        document.getElementById('last_name').value = data.last_name;
                        document.getElementById('email').value = data.email;
                        document.getElementById('title').value = data.title;
                        if (document.getElementById('license_number')) {
                            document.getElementById('license_number').value = data.license_number;
                        }
                        var img = sidebar.querySelector('img[alt="Profile"]');
                        if (img) {
                            if (data.profile_picture && data.profile_picture !== '') {
                                let picPath = (data.profile_picture.startsWith('images/')) ? data.profile_picture : 'images/profiles/' + data.profile_picture.split('/').pop();
                                img.src = picPath;
                            } else {
                                img.src = 'images/default_avatar.png';
                            }
                        }
                    });
            });
        }
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                sidebar.style.right = '-350px';
            });
        }
        document.addEventListener('click', function(e) {
            if (sidebar.style.right === '0' && !sidebar.contains(e.target) && e.target !== openBtn) {
                sidebar.style.right = '-350px';
            }
        });
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
                        sidebar.style.right = '-350px';
                    }
                });
            });
        }
    });
    </script>
</body>
</html>
