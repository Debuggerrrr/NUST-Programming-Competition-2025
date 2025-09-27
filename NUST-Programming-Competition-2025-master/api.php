<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$role = $_SESSION['role'];

require_once __DIR__ . '/config/database.php';

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'stats':
            // Receptionist: show appointment stats; Admin: include total patients
            $today = date('Y-m-d');
            $todayAppointments = (int)$pdo->query("SELECT COUNT(*) FROM appointments WHERE DATE(appointment_datetime) = '{$today}'")->fetchColumn();
            // Example checked-in count: completed today
            $checkedIn = (int)$pdo->query("SELECT COUNT(*) FROM appointments WHERE DATE(appointment_datetime) = '{$today}' AND status = 'completed'")->fetchColumn();
            $totalPatients = ($role === 'admin') ? (int)$pdo->query("SELECT COUNT(*) FROM patients")->fetchColumn() : 0;
            echo json_encode(['success' => true, 'data' => [
                'today_appointments' => $todayAppointments,
                'checked_in' => $checkedIn,
                'total_patients' => $totalPatients
            ]]);
            break;

        case 'upcoming_appointments':
            $sql = "SELECT a.appointment_id,
                           DATE_FORMAT(a.appointment_datetime, '%Y-%m-%d %H:%i') AS time,
                           CONCAT(pat.first_name,' ',pat.last_name) AS patient,
                           a.status
                    FROM appointments a
                    LEFT JOIN patients pat ON pat.patient_id = a.patient_id
                    WHERE a.appointment_datetime >= NOW()
                    ORDER BY a.appointment_datetime ASC
                    LIMIT 10";
            $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $rows]);
            break;

        case 'recent_patients':
            // Patients seen recently: latest medical_records or by created_at
            $sql = "SELECT CONCAT(p.first_name,' ',p.last_name) AS name,
                           COALESCE(MAX(DATE_FORMAT(mr.created_at,'%Y-%m-%d')), '—') AS last_visit
                    FROM patients p
                    LEFT JOIN medical_records mr ON mr.patient_id = p.patient_id
                    GROUP BY p.patient_id
                    ORDER BY MAX(mr.created_at) DESC NULLS LAST
                    LIMIT 10";
            $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $rows]);
            break;

        case 'list_users':
            if ($role !== 'admin') {
                echo json_encode(['success' => false, 'message' => 'Forbidden']);
                break;
            }
            $sql = "SELECT u.user_id,
                           u.role,
                           COALESCE(
                               CONCAT(pat.first_name,' ',pat.last_name),
                               CONCAT(doc.first_name,' ',doc.last_name),
                               CONCAT(nur.first_name,' ',nur.last_name),
                               CONCAT(pha.first_name,' ',pha.last_name),
                               CONCAT(rec.first_name,' ',rec.last_name),
                               CONCAT(adm.first_name,' ',adm.last_name)
                           ) AS name
                    FROM users u
                    LEFT JOIN patients pat ON pat.user_id = u.user_id
                    LEFT JOIN doctors doc ON doc.user_id = u.user_id
                    LEFT JOIN nurses nur ON nur.user_id = u.user_id
                    LEFT JOIN pharmacists pha ON pha.user_id = u.user_id
                    LEFT JOIN receptionists rec ON rec.user_id = u.user_id
                    LEFT JOIN admins adm ON adm.user_id = u.user_id
                    ORDER BY u.user_id DESC
                    LIMIT 10";
            $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $rows]);
            break;

        case 'activity':
            // Simple activity based on latest appointments created/updated
            $sql = "SELECT DATE_FORMAT(a.appointment_datetime, '%Y-%m-%d %H:%i') AS time,
                           CONCAT('Appointment ', a.status, ' for patient #', a.patient_id) AS msg
                    FROM appointments a
                    ORDER BY a.appointment_datetime DESC
                    LIMIT 10";
            $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $rows]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Unknown action']);
    }
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>


