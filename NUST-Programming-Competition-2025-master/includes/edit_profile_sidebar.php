<?php
/**
 * Unified Edit Profile Sidebar Component
 * Works for all user roles with the new database schema
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Edit Profile Sidebar -->
<div id="editProfileSidebar" class="edit-profile-sidebar bg-white shadow" style="position:fixed;top:0;right:-400px;width:400px;height:100vh;z-index:1050;transition:right 0.3s;overflow-y:auto;">
    <div class="p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-primary">Edit Profile</h4>
            <button type="button" id="closeEditProfile" class="btn-close"></button>
        </div>
        
        <form id="editProfileForm" enctype="multipart/form-data">
            <!-- Profile Picture Section -->
            <div class="text-center mb-4">
                <img id="profilePreview" src="images/default_avatar.png" alt="Profile" class="rounded-circle border" style="width:100px;height:100px;object-fit:cover;">
                <div class="mt-2">
                    <input type="file" class="form-control form-control-sm" id="profilePicture" name="profile_picture" accept="image/*" onchange="previewImage(this)">
                    <small class="text-muted">Upload a new profile picture</small>
                </div>
            </div>
            
            <!-- Basic Information -->
            <div class="row g-2">
                <div class="col-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control form-control-sm" id="firstName" name="first_name" required>
                </div>
                <div class="col-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control form-control-sm" id="lastName" name="last_name" required>
                </div>
                <div class="col-6">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="e.g. Mr, Ms, Dr, Prof">
                </div>
                <div class="col-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control form-control-sm" id="email" name="email" required>
                </div>
            </div>
            
            <!-- Role-specific fields -->
            <div id="roleSpecificFields">
                <!-- Patient fields -->
                <div id="patientFields" class="role-fields" style="display: none;">
                    <hr>
                    <h6 class="text-primary">Medical Information</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="dateOfBirth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control form-control-sm" id="dateOfBirth" name="date_of_birth">
                        </div>
                        <div class="col-6">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select form-select-sm" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control form-control-sm" id="address" name="address" rows="2"></textarea>
                        </div>
                        <div class="col-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control form-control-sm" id="phone" name="phone">
                        </div>
                        <div class="col-6">
                            <label for="emergencyContact" class="form-label">Emergency Contact</label>
                            <input type="tel" class="form-control form-control-sm" id="emergencyContact" name="emergency_contact">
                        </div>
                        <div class="col-12">
                            <label for="emergencyContactName" class="form-label">Emergency Contact Name</label>
                            <input type="text" class="form-control form-control-sm" id="emergencyContactName" name="emergency_contact_name">
                        </div>
                        <div class="col-12">
                            <label for="medicalHistory" class="form-label">Medical History</label>
                            <textarea class="form-control form-control-sm" id="medicalHistory" name="medical_history" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="allergies" class="form-label">Allergies</label>
                            <textarea class="form-control form-control-sm" id="allergies" name="allergies" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Doctor fields -->
                <div id="doctorFields" class="role-fields" style="display: none;">
                    <hr>
                    <h6 class="text-primary">Professional Information</h6>
                    <div class="row g-2">
                        <div class="col-12">
                            <label for="specialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control form-control-sm" id="specialization" name="specialization">
                        </div>
                        <div class="col-6">
                            <label for="licenseNumber" class="form-label">License Number</label>
                            <input type="text" class="form-control form-control-sm" id="licenseNumber" name="license_number">
                        </div>
                        <div class="col-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control form-control-sm" id="phone" name="phone">
                        </div>
                        <div class="col-12">
                            <label for="officeLocation" class="form-label">Office Location</label>
                            <input type="text" class="form-control form-control-sm" id="officeLocation" name="office_location">
                        </div>
                        <div class="col-12">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control form-control-sm" id="bio" name="bio" rows="3"></textarea>
                        </div>
                        <div class="col-6">
                            <label for="consultationFee" class="form-label">Consultation Fee</label>
                            <input type="number" class="form-control form-control-sm" id="consultationFee" name="consultation_fee" step="0.01">
                        </div>
                    </div>
                </div>
                
                <!-- Nurse fields -->
                <div id="nurseFields" class="role-fields" style="display: none;">
                    <hr>
                    <h6 class="text-primary">Professional Information</h6>
                    <div class="row g-2">
                        <div class="col-12">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control form-control-sm" id="department" name="department">
                        </div>
                        <div class="col-6">
                            <label for="licenseNumber" class="form-label">License Number</label>
                            <input type="text" class="form-control form-control-sm" id="licenseNumber" name="license_number">
                        </div>
                        <div class="col-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control form-control-sm" id="phone" name="phone">
                        </div>
                        <div class="col-12">
                            <label for="shiftSchedule" class="form-label">Shift Schedule</label>
                            <input type="text" class="form-control form-control-sm" id="shiftSchedule" name="shift_schedule">
                        </div>
                    </div>
                </div>
                
                <!-- Pharmacist fields -->
                <div id="pharmacistFields" class="role-fields" style="display: none;">
                    <hr>
                    <h6 class="text-primary">Professional Information</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="licenseNumber" class="form-label">License Number</label>
                            <input type="text" class="form-control form-control-sm" id="licenseNumber" name="license_number">
                        </div>
                        <div class="col-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control form-control-sm" id="phone" name="phone">
                        </div>
                        <div class="col-12">
                            <label for="pharmacyLocation" class="form-label">Pharmacy Location</label>
                            <input type="text" class="form-control form-control-sm" id="pharmacyLocation" name="pharmacy_location">
                        </div>
                        <div class="col-12">
                            <label for="specialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control form-control-sm" id="specialization" name="specialization">
                        </div>
                    </div>
                </div>
                
                <!-- Receptionist fields -->
                <div id="receptionistFields" class="role-fields" style="display: none;">
                    <hr>
                    <h6 class="text-primary">Professional Information</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control form-control-sm" id="phone" name="phone">
                        </div>
                        <div class="col-6">
                            <label for="shiftSchedule" class="form-label">Shift Schedule</label>
                            <input type="text" class="form-control form-control-sm" id="shiftSchedule" name="shift_schedule">
                        </div>
                    </div>
                </div>
                
                <!-- Admin fields -->
                <div id="adminFields" class="role-fields" style="display: none;">
                    <hr>
                    <h6 class="text-primary">Administrative Information</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control form-control-sm" id="phone" name="phone">
                        </div>
                        <div class="col-6">
                            <label for="adminLevel" class="form-label">Admin Level</label>
                            <select class="form-select form-select-sm" id="adminLevel" name="admin_level">
                                <option value="standard">Standard</option>
                                <option value="super">Super Admin</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-save me-2"></i>Save Changes
                </button>
                <button type="button" id="closeEditProfile" class="btn btn-secondary w-100">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Global profile management functions
let currentUserRole = '<?php echo $_SESSION['role'] ?? ''; ?>';

document.addEventListener('DOMContentLoaded', function() {
    // Initialize profile sidebar
    initializeProfileSidebar();
    
    // Load current profile data
    loadProfileData();
});

function initializeProfileSidebar() {
    const sidebar = document.getElementById('editProfileSidebar');
    const openBtn = document.getElementById('openEditProfile');
    const closeBtn = document.getElementById('closeEditProfile');
    
    if (openBtn) {
        openBtn.addEventListener('click', function() {
            sidebar.style.right = '0';
            loadProfileData();
        });
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            sidebar.style.right = '-400px';
        });
    }
    
    // Close sidebar when clicking outside
    document.addEventListener('click', function(e) {
        if (sidebar.style.right === '0' && !sidebar.contains(e.target) && e.target !== openBtn) {
            sidebar.style.right = '-400px';
        }
    });
    
    // Show role-specific fields
    showRoleSpecificFields(currentUserRole);
}

function showRoleSpecificFields(role) {
    // Hide all role fields
    document.querySelectorAll('.role-fields').forEach(field => {
        field.style.display = 'none';
    });
    
    // Show fields for current role
    const roleFields = document.getElementById(role + 'Fields');
    if (roleFields) {
        roleFields.style.display = 'block';
    }
}

function loadProfileData() {
    fetch('api/profile/manage_profile.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateForm(data.profile);
            }
        })
        .catch(error => {
            console.error('Error loading profile:', error);
        });
}

function populateForm(profile) {
    // Populate basic fields
    document.getElementById('firstName').value = profile.first_name || '';
    document.getElementById('lastName').value = profile.last_name || '';
    document.getElementById('title').value = profile.title || '';
    document.getElementById('email').value = profile.email || '';
    
    // Populate role-specific fields
    Object.keys(profile).forEach(key => {
        const element = document.getElementById(key);
        if (element) {
            element.value = profile[key] || '';
        }
    });
    
    // Update profile picture
    if (profile.profile_picture) {
        const imgPath = profile.profile_picture.startsWith('images/') ? 
            profile.profile_picture : 
            'images/profiles/' + profile.profile_picture.split('/').pop();
        document.getElementById('profilePreview').src = imgPath;
    }
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Handle form submission
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('api/profile/manage_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profile updated successfully!');
            sidebar.style.right = '-400px';
            // Optionally reload page or update UI
            location.reload();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update profile');
    });
});
</script>
