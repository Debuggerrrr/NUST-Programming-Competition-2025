<?php
session_start();
$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    require_once 'api/auth/login.php';
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['role'] === 'doctor') {
            header('Location: doc_dashboard.php');
        } elseif ($_SESSION['role'] === 'patient') {
            header('Location: patient_dashboard.php');
        } elseif ($_SESSION['role'] === 'nurse') {
            header('Location: nurse_dashboard.php');
        } elseif ($_SESSION['role'] === 'pharmacist') {
            header('Location: pharmacist_dashboard.php');
        } elseif ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'receptionist') {
            header('Location: admin_dashboard.php');
        } else {
            header('Location: dashboard.php');
        }
        exit();
    } else {
        $login_error = 'Invalid username or password.';
    }
}

// Chatbot functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chat_message'])) {
    $user_message = strtolower(trim($_POST['chat_message']));
    
    // Knowledge base for malaria and typhoid
    $knowledge_base = [
        'malaria' => [
            'symptoms' => 'Malaria symptoms include fever, chills, headache, nausea, vomiting, muscle pain, and fatigue. Severe cases may involve anemia, jaundice, and convulsions.',
            'prevention' => 'Prevent malaria by using mosquito nets, insect repellents, wearing protective clothing, and taking antimalarial medication when traveling to high-risk areas.',
            'treatment' => 'Malaria is treated with antimalarial drugs like chloroquine, artemisinin-based combination therapies (ACTs), or quinine. Early diagnosis and treatment are crucial.',
            'transmission' => 'Malaria is transmitted through the bite of infected Anopheles mosquitoes. It cannot spread directly from person to person.',
            'diagnosis' => 'Malaria is diagnosed through blood tests that detect the parasite. Rapid diagnostic tests (RDTs) and microscopic examination are commonly used.',
            'causes' => 'Malaria is caused by Plasmodium parasites transmitted through the bites of infected female Anopheles mosquitoes.',
            'what_is' => 'Malaria is a life-threatening disease caused by parasites transmitted through mosquito bites. It is preventable and curable with proper treatment.'
        ],
        'typhoid' => [
            'symptoms' => 'Typhoid symptoms include sustained high fever, weakness, stomach pain, headache, loss of appetite, and sometimes a rash. Severe cases can lead to intestinal bleeding.',
            'prevention' => 'Prevent typhoid by practicing good hygiene, drinking safe water, getting vaccinated, and avoiding risky foods when traveling to endemic areas.',
            'treatment' => 'Typhoid is treated with antibiotics like azithromycin, ciprofloxacin, or ceftriaxone. Complete the full course of antibiotics as prescribed.',
            'transmission' => 'Typhoid spreads through contaminated food and water. It is caused by Salmonella Typhi bacteria.',
            'diagnosis' => 'Typhoid is diagnosed through blood, stool, or urine tests that detect Salmonella Typhi bacteria.',
            'causes' => 'Typhoid fever is caused by Salmonella Typhi bacteria, usually spread through contaminated food or water.',
            'what_is' => 'Typhoid fever is a serious bacterial infection caused by Salmonella Typhi that affects the intestinal tract and bloodstream.'
        ]
    ];
    
    // System information
    $system_info = [
        'purpose' => "MESMTF (Medical Expert System for Malaria and Typhoid Fever) is an AI-powered platform designed to assist in the diagnosis, treatment, and management of Malaria and Typhoid Fever. It provides healthcare professionals with tools for medical records, appointment scheduling, diagnosis, treatment planning, pharmacy services, and reporting.",
        'diagnosis_process' => "The diagnosis system uses a rule-based expert system that analyzes symptoms according to medical guidelines. It evaluates symptoms based on their strength and provides a preliminary assessment. For accurate diagnosis, it's always recommended to consult a healthcare professional for confirmation and proper treatment.",
        'users' => "The system is designed for multiple user types: 1) Patients - for self-diagnosis and appointment booking, 2) Doctors - for diagnosis and treatment planning, 3) Nurses - for patient care and monitoring, 4) Pharmacists - for drug administration, and 5) Administrators - for system management.",
        'registration' => "You can register as a patient through the registration modal. Other roles require administrative approval. Registration requires basic information like username, password, email, name, and title.",
        'login' => "Use your username and password to login. Select your role (patient, doctor, nurse, etc.) for appropriate dashboard access. Make sure to select the correct role you registered with."
    ];
    
    // General responses for unrelated questions
    $unrelated_responses = [
        "I'm specialized in providing information about malaria and typhoid fever. For questions on other topics, please consult appropriate resources or healthcare professionals.",
        "My expertise is focused on malaria and typhoid fever information. I can help you with symptoms, prevention, treatment, and general information about these diseases.",
        "I'm here to assist with malaria and typhoid fever-related questions. For other medical concerns, please consult a healthcare provider.",
        "As a health assistant for MESMTF, I can provide information about malaria and typhoid fever. For unrelated topics, I recommend seeking specialized resources."
    ];
    
    // Greetings and general questions
    $greetings = ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening'];
    $greeting_responses = [
        "Hello! I'm your MESMTF health assistant. How can I help you with malaria or typhoid fever today?",
        "Hi there! I'm here to assist with malaria and typhoid fever information. What would you like to know?",
        "Welcome! I can help you with questions about malaria symptoms, typhoid prevention, or general health information related to our system."
    ];
    
    // Process the message
    $response = "";
    $found_match = false;
    
    // Check for greetings
    foreach ($greetings as $greeting) {
        if (strpos($user_message, $greeting) !== false) {
            $response = $greeting_responses[array_rand($greeting_responses)];
            $found_match = true;
            break;
        }
    }
    
    // Check for malaria-related questions
    if (!$found_match) {
        $malaria_keywords = ['malaria', 'mosquito', 'fever', 'chills', 'anopheles', 'plasmodium'];
        foreach ($malaria_keywords as $keyword) {
            if (strpos($user_message, $keyword) !== false) {
                if (strpos($user_message, 'symptom') !== false) {
                    $response = $knowledge_base['malaria']['symptoms'];
                } elseif (strpos($user_message, 'prevent') !== false || strpos($user_message, 'avoid') !== false) {
                    $response = $knowledge_base['malaria']['prevention'];
                } elseif (strpos($user_message, 'treat') !== false || strpos($user_message, 'cure') !== false || strpos($user_message, 'medic') !== false) {
                    $response = $knowledge_base['malaria']['treatment'];
                } elseif (strpos($user_message, 'spread') !== false || strpos($user_message, 'transmit') !== false) {
                    $response = $knowledge_base['malaria']['transmission'];
                } elseif (strpos($user_message, 'diagnos') !== false || strpos($user_message, 'test') !== false) {
                    $response = $knowledge_base['malaria']['diagnosis'];
                } elseif (strpos($user_message, 'cause') !== false || strpos($user_message, 'why') !== false) {
                    $response = $knowledge_base['malaria']['causes'];
                } elseif (strpos($user_message, 'what is') !== false || strpos($user_message, 'what\'s') !== false) {
                    $response = $knowledge_base['malaria']['what_is'];
                } else {
                    $response = "Malaria Information:\n\n" . 
                               $knowledge_base['malaria']['what_is'] . "\n\n" .
                               "Key Symptoms: " . $knowledge_base['malaria']['symptoms'] . "\n\n" .
                               "Prevention: " . $knowledge_base['malaria']['prevention'];
                }
                $found_match = true;
                break;
            }
        }
    }
    
    // Check for typhoid-related questions
    if (!$found_match) {
        $typhoid_keywords = ['typhoid', 'salmonella', 'stomach', 'abdominal', 'contaminated', 'bacteria'];
        foreach ($typhoid_keywords as $keyword) {
            if (strpos($user_message, $keyword) !== false) {
                if (strpos($user_message, 'symptom') !== false) {
                    $response = $knowledge_base['typhoid']['symptoms'];
                } elseif (strpos($user_message, 'prevent') !== false || strpos($user_message, 'avoid') !== false) {
                    $response = $knowledge_base['typhoid']['prevention'];
                } elseif (strpos($user_message, 'treat') !== false || strpos($user_message, 'cure') !== false || strpos($user_message, 'medic') !== false) {
                    $response = $knowledge_base['typhoid']['treatment'];
                } elseif (strpos($user_message, 'spread') !== false || strpos($user_message, 'transmit') !== false) {
                    $response = $knowledge_base['typhoid']['transmission'];
                } elseif (strpos($user_message, 'diagnos') !== false || strpos($user_message, 'test') !== false) {
                    $response = $knowledge_base['typhoid']['diagnosis'];
                } elseif (strpos($user_message, 'cause') !== false || strpos($user_message, 'why') !== false) {
                    $response = $knowledge_base['typhoid']['causes'];
                } elseif (strpos($user_message, 'what is') !== false || strpos($user_message, 'what\'s') !== false) {
                    $response = $knowledge_base['typhoid']['what_is'];
                } else {
                    $response = "Typhoid Fever Information:\n\n" . 
                               $knowledge_base['typhoid']['what_is'] . "\n\n" .
                               "Key Symptoms: " . $knowledge_base['typhoid']['symptoms'] . "\n\n" .
                               "Prevention: " . $knowledge_base['typhoid']['prevention'];
                }
                $found_match = true;
                break;
            }
        }
    }
    
    // Check for system-related questions
    if (!$found_match) {
        if (strpos($user_message, 'purpose') !== false || strpos($user_message, 'system') !== false || strpos($user_message, 'what is this') !== false) {
            $response = $system_info['purpose'];
            $found_match = true;
        } elseif (strpos($user_message, 'diagnosis') !== false || strpos($user_message, 'how does it work') !== false) {
            $response = $system_info['diagnosis_process'];
            $found_match = true;
        } elseif (strpos($user_message, 'who can use') !== false || strpos($user_message, 'users') !== false) {
            $response = $system_info['users'];
            $found_match = true;
        } elseif (strpos($user_message, 'register') !== false || strpos($user_message, 'sign up') !== false) {
            $response = $system_info['registration'];
            $found_match = true;
        } elseif (strpos($user_message, 'login') !== false || strpos($user_message, 'sign in') !== false) {
            $response = $system_info['login'];
            $found_match = true;
        } elseif (strpos($user_message, 'help') !== false || strpos($user_message, 'support') !== false) {
            $response = "I can help you with information about malaria, typhoid fever, and how to use the MESMTF system. You can ask me about symptoms, prevention, treatment, or how to navigate the system. What specific help do you need?";
            $found_match = true;
        }
    }
    
    // Check for general health questions that are not related to malaria/typhoid
    if (!$found_match) {
        $unrelated_health_keywords = ['cancer', 'diabetes', 'hiv', 'aids', 'heart', 'covid', 'flu', 'cold', 'headache', 'cough', 'blood pressure', 'asthma'];
        foreach ($unrelated_health_keywords as $keyword) {
            if (strpos($user_message, $keyword) !== false) {
                $response = "I specialize in malaria and typhoid fever information. For questions about " . $keyword . ", please consult a healthcare professional or appropriate medical resources. I can help you with malaria symptoms, typhoid prevention, or information about our MESMTF system.";
                $found_match = true;
                break;
            }
        }
    }
    
    // If no match found, provide unrelated response
    if (!$found_match) {
        $response = $unrelated_responses[array_rand($unrelated_responses)];
    }
    
    echo json_encode(['response' => $response]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MESMTF - Medical Expert System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --success: #27ae60;
            --warning: #f39c12;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar {
            background-color: var(--primary);
        }
        
        .navbar-brand {
            font-weight: 700;
        }
        
        .hero-section {
            background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.8)), url('https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1932&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        
        .module-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .module-card:hover {
            transform: translateY(-5px);
        }
        
        .module-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--secondary);
        }
        
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        
        .dashboard-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .symptom-checkbox {
            margin: 8px 0;
        }
        
        .diagnosis-result {
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        footer {
            background-color: var(--dark);
            color: white;
            padding: 30px 0;
            margin-top: auto;
        }
        
        .dashboard-container {
            display: none;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .prescription-box {
            border: 1px dashed #ccc;
            padding: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        
        .features-section {
            padding: 80px 0;
            background-color: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .section-title p {
            font-size: 1.1rem;
            color: #666;
        }
        
        .feature-card {
            text-align: center;
            padding: 30px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
            font-weight: bold;
        }
        
        .feature-card h4 {
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.6;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .hero-description {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .btn-hero {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 30px;
            margin: 0 10px;
        }
        
        .btn-hero-outline {
            background: transparent;
            border: 2px solid white;
            color: white;
        }
        
        .btn-hero-outline:hover {
            background: white;
            color: var(--primary);
        }
        
        /* Chatbot Styles */
        .chatbot-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
        
        .chatbot-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--secondary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .chatbot-btn:hover {
            transform: scale(1.05);
            background: var(--primary);
        }
        
        .chatbot-window {
            position: absolute;
            bottom: 70px;
            right: 0;
            width: 350px;
            height: 450px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
        }
        
        .chatbot-header {
            background: var(--primary);
            color: white;
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .chatbot-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .chatbot-body {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background: #f9f9f9;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .message {
            max-width: 80%;
            padding: 10px 15px;
            border-radius: 18px;
            margin-bottom: 10px;
            position: relative;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .bot-message {
            background: #e6f7ff;
            align-self: flex-start;
            border-bottom-left-radius: 5px;
        }
        
        .user-message {
            background: var(--secondary);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 5px;
        }
        
        .chatbot-footer {
            padding: 15px;
            border-top: 1px solid #eee;
            display: flex;
            gap: 10px;
        }
        
        .chatbot-input {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 10px 15px;
            outline: none;
        }
        
        .chatbot-send {
            background: var(--secondary);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        .quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }
        
        .quick-reply {
            background: white;
            border: 1px solid var(--secondary);
            color: var(--secondary);
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .quick-reply:hover {
            background: var(--secondary);
            color: white;
        }
        
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #888;
            font-style: italic;
        }
        
        .typing-dot {
            width: 6px;
            height: 6px;
            background: #888;
            border-radius: 50%;
            animation: typingAnimation 1.4s infinite ease-in-out;
        }
        
        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes typingAnimation {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-5px); }
        }
        
        /* Pulse animation for chatbot button */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(52, 152, 219, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(52, 152, 219, 0); }
            100% { box-shadow: 0 0 0 0 rgba(52, 152, 219, 0); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-description {
                font-size: 1.1rem;
            }
            
            .module-card {
                margin-bottom: 20px;
            }
            
            .chatbot-container {
                bottom: 20px;
                right: 20px;
            }
            
            .chatbot-window {
                width: 300px;
                height: 400px;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <div class="logo-placeholder">
                    <img src="images\Logo.jpeg" alt="MESMTF Logo" class="nav-logo">
                </div>
                MESMTF
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.php">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="diagnosis.php">Diagnosis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login to MESMTF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="index.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Login As</label>
                            <select class="form-select" id="role" name="role">
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
                        <div class="text-danger"> <?php echo $login_error; ?> </div>
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
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Mr, Ms, Dr, Prof" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Register As</label>
                            <select class="form-select" id="role" name="role" required onchange="toggleSpecialization(this.value)">
                                <option value="patient">Patient</option>
                            </select>
                        </div>
                        <div class="mb-3" id="specializationField" style="display:none;">
                            <label for="specialization" class="form-label">Specialization (Doctors only)</label>
                            <input type="text" class="form-control" id="specialization" name="specialization" placeholder="e.g. Cardiologist, Pediatrician">
                        </div>
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="api/auth/forgot_password.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reset_email" class="form-label">Enter your email address</label>
                            <input type="email" class="form-control" id="reset_email" name="reset_email" required>
                        </div>
                        <div class="text-muted">We'll send you instructions to reset your password.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Medical Expert System for Malaria and Typhoid Fever</h1>
                <p class="hero-description">A comprehensive e-Health solution for the Ministry of Health and Social Services</p>
                <div class="hero-buttons">
                    <a href="services.php" class="btn btn-hero btn-hero-outline">Learn More</a>
                    <a href="diagnosis.php" class="btn btn-hero btn-hero-outline">Start Diagnosis</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Our System</h2>
                <p>Advanced features designed specifically for healthcare professionals</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span>F</span>
                        </div>
                        <h4>Fast Diagnosis</h4>
                        <p>Quick and accurate identification of malaria and typhoid fever symptoms with our advanced algorithms.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span>S</span>
                        </div>
                        <h4>Secure & Private</h4>
                        <p>Patient data is protected with enterprise-grade security and strict privacy controls.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span>D</span>
                        </div>
                        <h4>Data Analytics</h4>
                        <p>Comprehensive reporting and analytics to track disease patterns and treatment outcomes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
   <!-- Footer -->
       <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-logo">
                        <div class="logo-placeholder">
    <!-- logo Section -->
                            <img src="images\Logo.jpeg" alt="MESMTF Logo" class="footer-logo-img">
                        </div>
                        <div>
                            <h5 class="footer-heading">MESMTF System</h5>
                            <p>Medical Expert System for Malaria and Typhoid Fever - A comprehensive e-Health solution.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="index.php" class="footer-link">Home</a></li>
                        <li><a href="about.php" class="footer-link">About</a></li>
                        <li><a href="services.php" class="footer-link">Services</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="footer-heading">Contact Us</h5>
                    <div class="contact-info">
                        <p><span class="contact-icon"></span> 13 Jackson Kaijieua Street<br>Private Bag 1388, Winbrook, NAMIBIA</p>
                        <p><span class="contact-icon"></span> +264 61 207 2052</p>
                        <p><span class="contact-icon"></span> tfse@nust.na</p>
                    </div>
                </div>

            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; 2025 MESMTF. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p>Developed for Ministry of Health and Social Services</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- AI Chatbot Container -->
    <div class="chatbot-container">
        <div class="chatbot-btn pulse" id="chatbotToggle">
            <i class="fas fa-robot fa-lg"></i>
        </div>
        
        <div class="chatbot-window" id="chatbotWindow">
            <div class="chatbot-header">
                <div class="chatbot-title">
                    <i class="fas fa-robot"></i>
                    <h5 class="mb-0">MESMTF Health Assistant</h5>
                </div>
                <div class="chatbot-actions">
                    <i class="fas fa-times" id="chatbotClose"></i>
                </div>
            </div>
            
            <div class="chatbot-body" id="chatbotMessages">
                <div class="message bot-message">
                    <p>Hello! I'm your MESMTF health assistant. I can help with questions about malaria, typhoid fever, symptoms, prevention, and treatment. How can I assist you today?</p>
                    <div class="quick-replies">
                        <div class="quick-reply" data-reply="What is Malaria?">What is Malaria?</div>
                        <div class="quick-reply" data-reply="What is Typhoid fever?">What is Typhoid?</div>
                        <div class="quick-reply" data-reply="Malaria symptoms">Malaria symptoms</div>
                        <div class="quick-reply" data-reply="Typhoid prevention">Typhoid prevention</div>
                    </div>
                </div>
            </div>
            
            <div class="chatbot-footer">
                <input type="text" class="chatbot-input" id="chatbotInput" placeholder="Ask about malaria, typhoid, or our system...">
                <button class="chatbot-send" id="chatbotSend">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle specialization field for doctor registration
        function toggleSpecialization(role) {
            document.getElementById('specializationField').style.display = (role === 'doctor') ? 'block' : 'none';
        }

        // Chatbot functionality
        document.addEventListener('DOMContentLoaded', function() {
            const chatbotToggle = document.getElementById('chatbotToggle');
            const chatbotWindow = document.getElementById('chatbotWindow');
            const chatbotClose = document.getElementById('chatbotClose');
            const chatbotMessages = document.getElementById('chatbotMessages');
            const chatbotInput = document.getElementById('chatbotInput');
            const chatbotSend = document.getElementById('chatbotSend');
            
            // Toggle chatbot window
            chatbotToggle.addEventListener('click', function() {
                chatbotWindow.style.display = chatbotWindow.style.display === 'flex' ? 'none' : 'flex';
                chatbotInput.focus();
            });
            
            // Close chatbot window
            chatbotClose.addEventListener('click', function() {
                chatbotWindow.style.display = 'none';
            });
            
            // Send message function
            function sendMessage() {
                const message = chatbotInput.value.trim();
                if (message === '') return;
                
                addMessage(message, 'user');
                chatbotInput.value = '';
                
                // Show typing indicator
                const typingIndicator = showTypingIndicator();
                
                // Send message to server
                fetch('index.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'chat_message=' + encodeURIComponent(message)
                })
                .then(response => response.json())
                .then(data => {
                    // Remove typing indicator
                    if (typingIndicator) {
                        typingIndicator.remove();
                    }
                    
                    // Add bot response
                    addMessage(data.response, 'bot');
                    
                    // Add quick replies based on response
                    addQuickReplies(data.response);
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typingIndicator) {
                        typingIndicator.remove();
                    }
                    addMessage('Sorry, I encountered an error. Please try again.', 'bot');
                });
            }
            
            // Send message on button click
            chatbotSend.addEventListener('click', sendMessage);
            
            // Send message on Enter key
            chatbotInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
            
            // Quick replies
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('quick-reply')) {
                    const reply = e.target.getAttribute('data-reply');
                    addMessage(reply, 'user');
                    
                    // Show typing indicator
                    const typingIndicator = showTypingIndicator();
                    
                    // Send quick reply to server
                    fetch('index.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'chat_message=' + encodeURIComponent(reply)
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Remove typing indicator
                        if (typingIndicator) {
                            typingIndicator.remove();
                        }
                        
                        // Add bot response
                        addMessage(data.response, 'bot');
                        
                        // Add quick replies based on response
                        addQuickReplies(data.response);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (typingIndicator) {
                            typingIndicator.remove();
                        }
                        addMessage('Sorry, I encountered an error. Please try again.', 'bot');
                    });
                }
            });
            
            // Add message to chat
            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message');
                messageDiv.classList.add(sender === 'user' ? 'user-message' : 'bot-message');
                
                // Preserve line breaks in the response
                const formattedText = text.replace(/\n/g, '<br>');
                messageDiv.innerHTML = `<p class="mb-0">${formattedText}</p>`;
                
                chatbotMessages.appendChild(messageDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }
            
            // Show typing indicator
            function showTypingIndicator() {
                const typingDiv = document.createElement('div');
                typingDiv.classList.add('typing-indicator');
                typingDiv.id = 'typingIndicator';
                
                typingDiv.innerHTML = `
                    <span>Assistant is typing</span>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                `;
                
                chatbotMessages.appendChild(typingDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
                
                return typingDiv;
            }
            
            // Add quick replies based on the response
            function addQuickReplies(response) {
                const quickRepliesDiv = document.createElement('div');
                quickRepliesDiv.classList.add('quick-replies');
                
                let quickReplies = [];
                
                // Determine which quick replies to show based on the response content
                if (response.toLowerCase().includes('malaria')) {
                    quickReplies = [
                        { text: 'Malaria symptoms', reply: 'What are the symptoms of malaria?' },
                        { text: 'Malaria prevention', reply: 'How can I prevent malaria?' },
                        { text: 'Malaria treatment', reply: 'How is malaria treated?' },
                        { text: 'Typhoid information', reply: 'What is Typhoid fever?' }
                    ];
                } else if (response.toLowerCase().includes('typhoid')) {
                    quickReplies = [
                        { text: 'Typhoid symptoms', reply: 'What are the symptoms of typhoid?' },
                        { text: 'Typhoid prevention', reply: 'How can I prevent typhoid?' },
                        { text: 'Typhoid treatment', reply: 'How is typhoid treated?' },
                        { text: 'Malaria information', reply: 'What is Malaria?' }
                    ];
                } else {
                    quickReplies = [
                        { text: 'Malaria info', reply: 'What is Malaria?' },
                        { text: 'Typhoid info', reply: 'What is Typhoid fever?' },
                        { text: 'System purpose', reply: 'What is the main purpose of this system?' },
                        { text: 'How to use', reply: 'How does the diagnosis system work?' }
                    ];
                }
                
                // Add quick reply buttons
                quickReplies.forEach(qr => {
                    const quickReplyBtn = document.createElement('div');
                    quickReplyBtn.classList.add('quick-reply');
                    quickReplyBtn.setAttribute('data-reply', qr.reply);
                    quickReplyBtn.textContent = qr.text;
                    quickRepliesDiv.appendChild(quickReplyBtn);
                });
                
                // Add to the last bot message
                const lastMessage = chatbotMessages.lastElementChild;
                if (lastMessage && lastMessage.classList.contains('bot-message')) {
                    lastMessage.appendChild(quickRepliesDiv);
                    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
                }
            }
        });
    </script>
</body>
</html>