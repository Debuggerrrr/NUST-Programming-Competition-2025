<?php
require_once '../../utils/Auth.php';
require_once '../../utils/Response.php';
require_once '../../models/User.php';
require_once '../../models/Patient.php';
require_once '../../models/Diagnosis.php';

// Authenticate request
$auth_data = Auth::requireAuth([ROLE_PATIENT, ROLE_DOCTOR, ROLE_NURSE]);

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::error('Method not allowed', HTTP_BAD_REQUEST);
}

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($input['symptoms']) || !is_array($input['symptoms']) || empty($input['symptoms'])) {
    Response::error('Symptoms are required', HTTP_BAD_REQUEST);
}

// Get patient ID (either from request or from user's patient profile)
$patient_id = isset($input['patient_id']) ? $input['patient_id'] : null;

if (!$patient_id && $auth_data['role'] === ROLE_PATIENT) {
    // If patient is diagnosing themselves, find their patient record
    $patient_model = new Patient();
    if ($patient_model->getByUserId($auth_data['sub'])) {
        $patient_id = $patient_model->id;
    }
}

if (!$patient_id) {
    Response::error('Patient ID is required', HTTP_BAD_REQUEST);
}

// Get symptoms details from database
$db = new Database();
$symptom_ids = array_map(function($s) { return $s['id']; }, $input['symptoms']);
$placeholders = implode(',', array_fill(0, count($symptom_ids), '?'));
$sql = "SELECT * FROM symptoms WHERE id IN ($placeholders)";
$symptoms_details = $db->fetchAll($sql, $symptom_ids);

// Expert system rules for diagnosis
$malaria_score = 0;
$typhoid_score = 0;

foreach ($symptoms_details as $symptom) {
    if ($symptom['category'] == 'malaria') {
        switch ($symptom['severity']) {
            case 'very_strong': $malaria_score += 4; break;
            case 'strong': $malaria_score += 3; break;
            case 'weak': $malaria_score += 2; break;
            default: $malaria_score += 1;
        }
    } else if ($symptom['category'] == 'typhoid') {
        switch ($symptom['severity']) {
            case 'very_strong': $typhoid_score += 4; break;
            case 'strong': $typhoid_score += 3; break;
            case 'weak': $typhoid_score += 2; break;
            default: $typhoid_score += 1;
        }
    }
}

// Determine condition based on scores
$condition = 'none';
$confidence = 0;
$requires_xray = false;

if ($malaria_score >= 8 && $typhoid_score >= 8) {
    $condition = 'both';
    $confidence = min(90, ($malaria_score + $typhoid_score) * 3);
    $requires_xray = true;
} else if ($malaria_score >= 8) {
    $condition = 'malaria';
    $confidence = min(95, $malaria_score * 4);
    $requires_xray = $malaria_score >= 12;
} else if ($typhoid_score >= 8) {
    $condition = 'typhoid';
    $confidence = min(95, $typhoid_score * 4);
    $requires_xray = $typhoid_score >= 12;
} else if ($malaria_score >= 4 || $typhoid_score >= 4) {
    $condition = 'none';
    $confidence = max($malaria_score, $typhoid_score) * 5;
} else {
    $condition = 'none';
    $confidence = 0;
}

// Get doctor ID if available (current user if doctor)
$doctor_id = null;
if ($auth_data['role'] === ROLE_DOCTOR) {
    $doctor = $db->fetch("SELECT id FROM doctors WHERE user_id = ?", [$auth_data['sub']]);
    if ($doctor) {
        $doctor_id = $doctor['id'];
    }
}

// Save diagnosis to database
$diagnosis_model = new Diagnosis();
$diagnosis_data = [
    'patient_id' => $patient_id,
    'doctor_id' => $doctor_id,
    'symptoms' => json_encode($input['symptoms']),
    'condition' => $condition,
    'confidence_level' => $confidence,
    'requires_xray' => $requires_xray,
    'notes' => isset($input['notes']) ? $input['notes'] : ''
];

if ($diagnosis_model->create($diagnosis_data)) {
    Response::success('Diagnosis completed', [
        'diagnosis' => $diagnosis_model->toArray(),
        'requires_xray' => $requires_xray
    ]);
} else {
    Response::error('Failed to save diagnosis', HTTP_SERVER_ERROR);
}
?>