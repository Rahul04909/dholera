<?php
/**
 * AJAX Site Visit Request Handler
 * Dholera Smart City
 */

header('Content-Type: application/json');
require_once '../database/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = (int)($_POST['project_id'] ?? 0);
    $project_name = trim($_POST['project_name'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $visit_date = trim($_POST['visit_date'] ?? '');
    $visit_time = trim($_POST['visit_time'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic Validation
    if (empty($name) || empty($email) || empty($phone) || empty($visit_date) || empty($visit_time)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO site_visits (project_id, project_name, name, email, phone, visit_date, visit_time, message) 
                                VALUES (:project_id, :project_name, :name, :email, :phone, :visit_date, :visit_time, :message)");
        
        $stmt->execute([
            'project_id' => $project_id,
            'project_name' => $project_name,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'visit_date' => $visit_date,
            'visit_time' => $visit_time,
            'message' => $message
        ]);

        $site_visit_id = $conn->lastInsertId();
        $debug_file = '../debug_site_routing.txt';
        $log_entry = date('Y-m-d H:i:s') . " - Site Visit Created: ID $site_visit_id for Project ID $project_id\n";

        // Route to Assigned Agents
        $agents_stmt = $conn->prepare("SELECT agent_id FROM agent_projects WHERE project_id = ?");
        $agents_stmt->execute([$project_id]);
        $assigned_agents = $agents_stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $log_entry .= "Assigned Agents Found: " . implode(', ', $assigned_agents) . "\n";

        if (!empty($assigned_agents)) {
            $route_stmt = $conn->prepare("INSERT INTO agent_site_visits (agent_id, site_visit_id) VALUES (:agent_id, :site_visit_id)");
            foreach ($assigned_agents as $agent_id) {
                $status = $route_stmt->execute([
                    'agent_id' => $agent_id,
                    'site_visit_id' => $site_visit_id
                ]);
                $log_entry .= "Routing to Agent $agent_id: " . ($status ? "Success" : "Failed") . "\n";
            }
        } else {
            $log_entry .= "No agents assigned to project $project_id\n";
        }
        
        file_put_contents($debug_file, $log_entry, FILE_APPEND);
        
        echo json_encode(['status' => 'success', 'message' => 'Your site visit request has been scheduled! Our team will contact you shortly to confirm.']);
        
    } catch (PDOException $e) {
        error_log("Site Visit Error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'A technical error occurred while processing your request.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
