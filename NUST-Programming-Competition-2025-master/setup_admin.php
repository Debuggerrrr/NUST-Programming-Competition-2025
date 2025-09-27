<?php
/**
 * Database Initialization Script
 * This script creates the first admin user and sets up the system
 * Run this script once to initialize the system with an admin account
 */

require_once 'config/database.php';

// Check if admin already exists
$stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
$adminCount = $stmt->fetch()['count'];

if ($adminCount > 0) {
    echo "Admin user already exists. System is already initialized.\n";
    exit;
}

echo "Initializing MESMTF System...\n";
echo "Creating first admin user...\n";

// Default admin credentials (should be changed after first login)
$adminData = [
    'username' => 'admin',
    'password' => password_hash('admin123', PASSWORD_DEFAULT), // Change this password!
    'email' => 'admin@mesmtf.com',
    'first_name' => 'System',
    'last_name' => 'Administrator',
    'title' => 'Dr.',
    'role' => 'admin',
    'profile_picture' => null
];

try {
    // Insert admin user (new schema - users table only has auth data)
    $stmt = $pdo->prepare("
        INSERT INTO users (username, password_hash, email, role, created_at) 
        VALUES (?, ?, ?, ?, NOW())
    ");
    
    $stmt->execute([
        $adminData['username'],
        $adminData['password'],
        $adminData['email'],
        $adminData['role']
    ]);
    
    $adminUserId = $pdo->lastInsertId();
    
    // Create admin profile in admins table
    $stmt = $pdo->prepare("
        INSERT INTO admins (user_id, first_name, last_name, title, admin_level) 
        VALUES (?, ?, ?, ?, 'super')
    ");
    
    $stmt->execute([
        $adminUserId,
        $adminData['first_name'],
        $adminData['last_name'],
        $adminData['title']
    ]);
    
    echo "✅ Admin user created successfully!\n";
    echo "Username: admin\n";
    echo "Password: admin123\n";
    echo "⚠️  IMPORTANT: Please change the default password after first login!\n\n";
    
    // Create some sample data for testing
    echo "Creating sample data...\n";
    
    // Create a sample doctor
    $doctorData = [
        'username' => 'doctor1',
        'password' => password_hash('doctor123', PASSWORD_DEFAULT),
        'email' => 'doctor@mesmtf.com',
        'role' => 'doctor'
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO users (username, password_hash, email, role, created_at) 
        VALUES (?, ?, ?, ?, NOW())
    ");
    
    $stmt->execute([
        $doctorData['username'],
        $doctorData['password'],
        $doctorData['email'],
        $doctorData['role']
    ]);
    
    $doctorUserId = $pdo->lastInsertId();
    
    // Create doctor profile
    $stmt = $pdo->prepare("
        INSERT INTO doctors (user_id, first_name, last_name, title, specialization, license_number) 
        VALUES (?, 'John', 'Smith', 'Dr.', 'General Medicine', 'DOC123456')
    ");
    $stmt->execute([$doctorUserId]);
    
    echo "✅ Sample doctor created!\n";
    echo "Username: doctor1\n";
    echo "Password: doctor123\n\n";
    
    // Create a sample receptionist
    $receptionistData = [
        'username' => 'receptionist1',
        'password' => password_hash('receptionist123', PASSWORD_DEFAULT),
        'email' => 'receptionist@mesmtf.com',
        'role' => 'receptionist'
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO users (username, password_hash, email, role, created_at) 
        VALUES (?, ?, ?, ?, NOW())
    ");
    
    $stmt->execute([
        $receptionistData['username'],
        $receptionistData['password'],
        $receptionistData['email'],
        $receptionistData['role']
    ]);
    
    $receptionistUserId = $pdo->lastInsertId();
    
    // Create receptionist profile
    $stmt = $pdo->prepare("
        INSERT INTO receptionists (user_id, first_name, last_name, title) 
        VALUES (?, 'Jane', 'Doe', 'Ms.')
    ");
    $stmt->execute([$receptionistUserId]);
    
    echo "✅ Sample receptionist created!\n";
    echo "Username: receptionist1\n";
    echo "Password: receptionist123\n\n";
    
    echo "🎉 System initialization completed!\n";
    echo "You can now login with the admin credentials to manage the system.\n";
    echo "Remember to change all default passwords!\n";
    
} catch (Exception $e) {
    echo "❌ Error during initialization: " . $e->getMessage() . "\n";
    exit(1);
}
?>

