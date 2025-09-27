<?php
/**
 * Global Authentication Header
 * Reusable header with login/logout functionality for all pages
 */
session_start();
?>

<!-- Global Auth Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-hospital me-2"></i>MESMTF
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['id']) && isset($_SESSION['role'])): ?>
                    <!-- User is logged in -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="images/default_avatar.png" alt="Profile" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                            <span><?php echo htmlspecialchars($_SESSION['first_name'] ?? $_SESSION['username']); ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><span class="dropdown-item-text">
                                <small class="text-muted">Logged in as: <?php echo ucfirst($_SESSION['role']); ?></small>
                            </span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="openEditProfile()">
                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                            </a></li>
                            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'receptionist'): ?>
                                <li><a class="dropdown-item" href="admin_dashboard.php">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                            <?php elseif ($_SESSION['role'] === 'doctor'): ?>
                                <li><a class="dropdown-item" href="doc_dashboard.php">
                                    <i class="fas fa-stethoscope me-2"></i>Doctor Dashboard
                                </a></li>
                            <?php elseif ($_SESSION['role'] === 'nurse'): ?>
                                <li><a class="dropdown-item" href="nurse_dashboard.php">
                                    <i class="fas fa-user-nurse me-2"></i>Nurse Dashboard
                                </a></li>
                            <?php elseif ($_SESSION['role'] === 'pharmacist'): ?>
                                <li><a class="dropdown-item" href="pharmacist_dashboard.php">
                                    <i class="fas fa-pills me-2"></i>Pharmacist Dashboard
                                </a></li>
                            <?php elseif ($_SESSION['role'] === 'patient'): ?>
                                <li><a class="dropdown-item" href="patient_dashboard.php">
                                    <i class="fas fa-user-injured me-2"></i>Patient Dashboard
                                </a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="api/auth/login.php?action=logout">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- User is not logged in -->
                    <li class="nav-item">
                        <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#registerModal">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </button>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script>
// Global authentication functions
function openEditProfile() {
    // This will be handled by individual dashboard pages
    if (typeof window.openEditProfile === 'function') {
        window.openEditProfile();
    } else {
        alert('Profile editing is available in your dashboard.');
    }
}
</script>
