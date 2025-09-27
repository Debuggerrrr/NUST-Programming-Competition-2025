<?php
/**
 * MESMTF System Setup and User Management Guide
 * 
 * This script provides information about the new user management workflow
 * and helps administrators understand how to properly manage the system.
 */

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>MESMTF System Setup Guide</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <style>
        .step-card { margin-bottom: 2rem; }
        .code-block { background: #f8f9fa; padding: 1rem; border-radius: 0.5rem; font-family: monospace; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 1rem; border-radius: 0.5rem; }
        .success { background: #d1edff; border: 1px solid #74c0fc; padding: 1rem; border-radius: 0.5rem; }
    </style>
</head>
<body class='bg-light'>
<div class='container py-5'>
    <div class='row justify-content-center'>
        <div class='col-lg-10'>
            <div class='card'>
                <div class='card-header bg-primary text-white'>
                    <h1 class='h3 mb-0'><i class='fas fa-cogs me-2'></i>MESMTF System Setup Guide</h1>
                </div>
                <div class='card-body'>";

// Check if system is already initialized
require_once 'config/database.php';
$stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
$adminCount = $stmt->fetch()['count'];

if ($adminCount == 0) {
    echo "<div class='warning mb-4'>
            <h4><i class='fas fa-exclamation-triangle me-2'></i>System Not Initialized</h4>
            <p>No admin user found. Please run the setup script first:</p>
            <div class='code-block'>php setup_admin.php</div>
            <p>Or visit: <a href='setup_admin.php' class='btn btn-warning btn-sm'>Run Setup Script</a></p>
          </div>";
} else {
    echo "<div class='success mb-4'>
            <h4><i class='fas fa-check-circle me-2'></i>System Initialized</h4>
            <p>Admin user exists. System is ready for use.</p>
          </div>";
}

echo "
                    <h2>New User Management Workflow</h2>
                    
                    <div class='step-card'>
                        <div class='card'>
                            <div class='card-header'>
                                <h4><i class='fas fa-user-shield me-2'></i>1. Admin Assignment</h4>
                            </div>
                            <div class='card-body'>
                                <p><strong>Admins are NOT created through registration.</strong> They are assigned through:</p>
                                <ul>
                                    <li>Database initialization script (<code>setup_admin.php</code>)</li>
                                    <li>Direct database insertion by system administrators</li>
                                    <li>Existing admin creating new admin accounts through the dashboard</li>
                                </ul>
                                <div class='warning'>
                                    <strong>Security Note:</strong> Change default admin passwords immediately after setup!
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class='step-card'>
                        <div class='card'>
                            <div class='card-header'>
                                <h4><i class='fas fa-user-plus me-2'></i>2. Staff Account Creation</h4>
                            </div>
                            <div class='card-body'>
                                <p><strong>Only administrators can create staff accounts:</strong></p>
                                <ul>
                                    <li><strong>Doctors:</strong> Created by admin with specialization details</li>
                                    <li><strong>Nurses:</strong> Created by admin with department assignment</li>
                                    <li><strong>Pharmacists:</strong> Created by admin with license information</li>
                                    <li><strong>Receptionists:</strong> Created by admin for appointment management</li>
                                    <li><strong>Additional Admins:</strong> Created by existing admins</li>
                                </ul>
                                <p>Staff accounts are created through: <strong>Admin Dashboard → User Management → Add User</strong></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class='step-card'>
                        <div class='card'>
                            <div class='card-header'>
                                <h4><i class='fas fa-user-injured me-2'></i>3. Patient Registration</h4>
                            </div>
                            <div class='card-body'>
                                <p><strong>Patients can self-register:</strong></p>
                                <ul>
                                    <li>Patients register themselves through the public registration form</li>
                                    <li>Only 'Patient' role is available in public registration</li>
                                    <li>Patients can be managed (edited/removed) by administrators</li>
                                </ul>
                                <p>Registration is available on the main page: <strong>Homepage → Register</strong></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class='step-card'>
                        <div class='card'>
                            <div class='card-header'>
                                <h4><i class='fas fa-calendar-check me-2'></i>4. Role-Based Dashboard Access</h4>
                            </div>
                            <div class='card-body'>
                                <p><strong>Shared Dashboard with Role Restrictions:</strong></p>
                                <ul>
                                    <li><strong>Admin:</strong> Full access to all features (User Management, System Settings, Statistics, Database Management, Appointments)</li>
                                    <li><strong>Receptionist:</strong> Limited to Dashboard and Appointment Management only</li>
                                    <li><strong>Other Staff:</strong> Access their respective dashboards (Doctor, Nurse, Pharmacist)</li>
                                    <li><strong>Patients:</strong> Access patient dashboard</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class='step-card'>
                        <div class='card'>
                            <div class='card-header'>
                                <h4><i class='fas fa-trash-alt me-2'></i>5. Account Management</h4>
                            </div>
                            <div class='card-body'>
                                <p><strong>Administrators can manage all accounts:</strong></p>
                                <ul>
                                    <li><strong>Remove Patient Accounts:</strong> Yes, admins can delete patient accounts</li>
                                    <li><strong>Remove Staff Accounts:</strong> Yes, admins can remove any staff member</li>
                                    <li><strong>Self-Protection:</strong> Admins cannot delete their own accounts</li>
                                    <li><strong>Edit All Accounts:</strong> Admins can edit any user's information</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class='step-card'>
                        <div class='card'>
                            <div class='card-header'>
                                <h4><i class='fas fa-key me-2'></i>6. Security Features</h4>
                            </div>
                            <div class='card-body'>
                                <ul>
                                    <li><strong>Role-based Access Control:</strong> Each role has specific permissions</li>
                                    <li><strong>Session Management:</strong> Secure login/logout functionality</li>
                                    <li><strong>Input Validation:</strong> All forms validate user input</li>
                                    <li><strong>SQL Injection Protection:</strong> Prepared statements used throughout</li>
                                    <li><strong>File Upload Security:</strong> Profile pictures are validated and secured</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class='alert alert-info'>
                        <h5><i class='fas fa-info-circle me-2'></i>Quick Start Checklist</h5>
                        <ol>
                            <li>Run <code>setup_admin.php</code> to create the first admin</li>
                            <li>Login as admin and change the default password</li>
                            <li>Create staff accounts (doctors, nurses, receptionists) through User Management</li>
                            <li>Test appointment management with receptionist account</li>
                            <li>Verify that patients can self-register</li>
                        </ol>
                    </div>
                    
                    <div class='text-center mt-4'>
                        <a href='index.php' class='btn btn-primary me-2'>Go to Login</a>
                        <a href='admin_dashboard.php' class='btn btn-success'>Admin Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>";
?>

