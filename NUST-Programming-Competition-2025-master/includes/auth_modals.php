<?php
/**
 * Global Authentication Modals
 * Reusable login and registration modals for all pages
 */
?>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login to MESMTF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="api/auth/login.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="loginUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="loginUsername" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginRole" class="form-label">Login As</label>
                        <select class="form-select" id="loginRole" name="role">
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                            <option value="nurse">Nurse</option>
                            <option value="pharmacist">Pharmacist</option>
                            <option value="receptionist">Receptionist</option>
                            <option value="admin">Administrator</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="text-danger" id="loginError"></div>
                    <div class="text-center mt-3">
                        <p>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Register</a></p>
                        <p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal">Forgot password?</a>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register for MESMTF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="api/auth/register.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="regUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="regUsername" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="regPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="regPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="regEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="regEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="regFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="regFirstName" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="regLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="regLastName" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="regTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="regTitle" name="title" placeholder="e.g. Mr, Ms, Dr, Prof" required>
                    </div>
                    <div class="mb-3">
                        <label for="regRole" class="form-label">Register As</label>
                        <select class="form-select" id="regRole" name="role" required>
                            <option value="patient">Patient</option>
                        </select>
                        <small class="text-muted">Only patients can self-register. Staff accounts are created by administrators.</small>
                    </div>
                    <div class="mb-3">
                        <label for="regProfilePicture" class="form-label">Profile Picture (Optional)</label>
                        <input type="file" class="form-control" id="regProfilePicture" name="profile_picture" accept="image/*">
                    </div>
                    <div class="text-danger" id="registerError"></div>
                    <div class="text-center mt-3">
                        <p>Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Login</a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Password reset functionality will be implemented in a future update.</p>
                <p>Please contact your administrator for password assistance.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
// Global authentication JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Handle login form submission
    const loginForm = document.querySelector('#loginModal form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const errorDiv = document.getElementById('loginError');
            
            fetch('api/auth/login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('success') || data.includes('redirect')) {
                    // Login successful, redirect based on role
                    const role = formData.get('role');
                    if (role === 'doctor') {
                        window.location.href = 'doc_dashboard.php';
                    } else if (role === 'patient') {
                        window.location.href = 'patient_dashboard.php';
                    } else if (role === 'nurse') {
                        window.location.href = 'nurse_dashboard.php';
                    } else if (role === 'pharmacist') {
                        window.location.href = 'pharmacist_dashboard.php';
                    } else if (role === 'admin' || role === 'receptionist') {
                        window.location.href = 'admin_dashboard.php';
                    } else {
                        window.location.href = 'dashboard.php';
                    }
                } else {
                    errorDiv.innerHTML = 'Invalid username or password.';
                }
            })
            .catch(error => {
                console.error('Login error:', error);
                errorDiv.innerHTML = 'Login failed. Please try again.';
            });
        });
    }
    
    // Handle registration form submission
    const registerForm = document.querySelector('#registerModal form');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const errorDiv = document.getElementById('registerError');
            
            fetch('api/auth/register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('success') || data.includes('registered')) {
                    // Registration successful
                    errorDiv.innerHTML = '<div class="text-success">Registration successful! You can now login.</div>';
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                        modal.hide();
                        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                        loginModal.show();
                    }, 1500);
                } else {
                    errorDiv.innerHTML = 'Registration failed. Please check your information.';
                }
            })
            .catch(error => {
                console.error('Registration error:', error);
                errorDiv.innerHTML = 'Registration failed. Please try again.';
            });
        });
    }
});
</script>
