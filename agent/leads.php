<?php
/**
 * Agent Leads Management
 * Dholera Smart City Agent Panel
 */
include 'includes/header.php';

$agent_id = $_SESSION['agent_id'];
$success_msg = "";
$error_msg = "";

// Handle status and feedback updates
if (isset($_POST['update_lead'])) {
    $lead_id = (int)$_POST['lead_id'];
    $new_status = $_POST['status'];
    $feedback = trim($_POST['feedback']);

    try {
        $stmt = $conn->prepare("UPDATE agent_leads SET status = ?, agent_feedback = ? WHERE id = ? AND agent_id = ?");
        $stmt->execute([$new_status, $feedback, $lead_id, $agent_id]);
        $success_msg = "Lead feedback updated successfully!";
    } catch (PDOException $e) {
        $error_msg = "Error updating lead: " . $e->getMessage();
    }
}

// Fetch all assigned leads with source details
try {
    // We join with enquiries and callbacks based on source_type
    // This is a bit complex for a single query due to different source tables.
    // We'll fetch the leads first and then augment with source data if needed, 
    // but for the UI we'll use a UNION or subqueries to get contact info.
    
    $query = "
        SELECT 
            al.*,
            CASE 
                WHEN al.source_type = 'enquiry' THEN e.name
                WHEN al.source_type = 'callback' THEN c.name
            END as customer_name,
            CASE 
                WHEN al.source_type = 'enquiry' THEN e.phone
                WHEN al.source_type = 'callback' THEN c.phone
            END as customer_phone,
            CASE 
                WHEN al.source_type = 'enquiry' THEN e.email
                WHEN al.source_type = 'callback' THEN c.email
            END as customer_email,
            CASE 
                WHEN al.source_type = 'enquiry' THEN e.message
                WHEN al.source_type = 'callback' THEN c.preferred_time
            END as source_detail
        FROM agent_leads al
        LEFT JOIN enquiries e ON al.source_id = e.id AND al.source_type = 'enquiry'
        LEFT JOIN callbacks c ON al.source_id = c.id AND al.source_type = 'callback'
        WHERE al.agent_id = ?
        ORDER BY al.created_at DESC
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$agent_id]);
    $leads = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <h1>My Assigned Leads</h1>
        <p style="color: #718096; margin-top: 5px;">Manage and follow up on customer leads assigned to you.</p>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 5px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <style>
        .lead-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .lead-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 25px;
            display: flex;
            flex-direction: column;
            border-top: 4px solid #edf2f7;
        }

        .lead-card.status-new { border-top-color: #3182ce; }
        .lead-card.status-in-progress { border-top-color: #d69e2e; }
        .lead-card.status-junk { border-top-color: #e53e3e; }
        .lead-card.status-converted { border-top-color: #38a169; }

        .lead-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .source-tag {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 4px;
            background: #f7fafc;
            color: #4a5568;
            letter-spacing: 0.5px;
        }

        .customer-name {
            font-size: 20px;
            font-weight: 700;
            margin: 5px 0;
            color: #2d3748;
        }

        .contact-info {
            font-size: 14px;
            color: #718096;
            margin-bottom: 15px;
        }

        .contact-info div {
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .admin-note {
            background: #fffaf0;
            border: 1px dashed #fbd38d;
            padding: 12px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
            color: #744210;
        }

        .feedback-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            margin-bottom: 12px;
            resize: none;
        }

        .feedback-form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .btn-save {
            background: var(--primary-gold);
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
        }

        @media (max-width: 600px) {
            .lead-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="lead-grid">
        <?php if (empty($leads)): ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: #fff; border-radius: 12px;">
                <i class="fas fa-user-clock" style="font-size: 40px; color: #e2e8f0; margin-bottom: 15px;"></i>
                <p style="color: #718096;">Waiting for new leads? They'll appear here as soon as they're assigned to you!</p>
            </div>
        <?php else: ?>
            <?php foreach ($leads as $lead): ?>
                <div class="lead-card status-<?php echo $lead['status']; ?>">
                    <div class="lead-header">
                        <span class="source-tag">Source: <?php echo ucfirst($lead['source_type']); ?></span>
                        <div style="font-size: 12px; color: #a0aec0;"><?php echo date('M d, Y', strtotime($lead['created_at'])); ?></div>
                    </div>

                    <div class="customer-name"><?php echo htmlspecialchars($lead['customer_name'] ?: 'N/A'); ?></div>
                    <div class="contact-info">
                        <div><i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($lead['customer_phone'] ?: 'N/A'); ?></div>
                        <div><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($lead['customer_email'] ?: 'N/A'); ?></div>
                        <?php if ($lead['source_type'] == 'callback'): ?>
                            <div style="font-weight: 600; color: #3182ce;"><i class="far fa-clock"></i> Preferred: <?php echo htmlspecialchars($lead['source_detail']); ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if ($lead['admin_note']): ?>
                        <div class="admin-note">
                            <strong>Note from Admin:</strong><br>
                            <?php echo nl2br(htmlspecialchars($lead['admin_note'])); ?>
                        </div>
                    <?php endif; ?>

                    <form class="feedback-form" method="POST">
                        <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                        <label style="font-size: 13px; font-weight: 700; color: #4a5568; display: block; margin-bottom: 5px;">Lead Feedback</label>
                        <textarea name="feedback" rows="3" placeholder="Enter your follow-up notes..."><?php echo htmlspecialchars($lead['agent_feedback']); ?></textarea>
                        
                        <label style="font-size: 13px; font-weight: 700; color: #4a5568; display: block; margin-bottom: 5px;">Current Status</label>
                        <select name="status">
                            <option value="new" <?php echo $lead['status'] == 'new' ? 'selected' : ''; ?>>New Assigned</option>
                            <option value="in-progress" <?php echo $lead['status'] == 'in-progress' ? 'selected' : ''; ?>>In Follow-up</option>
                            <option value="junk" <?php echo $lead['status'] == 'junk' ? 'selected' : ''; ?>>Junk / Not Interested</option>
                            <option value="converted" <?php echo $lead['status'] == 'converted' ? 'selected' : ''; ?>>Successfully Converted</option>
                        </select>
                        
                        <button type="submit" name="update_lead" class="btn-save">Save Updates</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
