<?php
/**
 * Agent Site Visit Management
 * Dholera Smart City Agent Panel
 */
include 'includes/header.php';

$success_msg = "";
$error_msg = "";

// Handle Status Update
if (isset($_POST['update_status'])) {
    $visit_id = (int)$_POST['visit_id'];
    $new_status = $_POST['status'];
    $notes = trim($_POST['notes']);

    try {
        $stmt = $conn->prepare("UPDATE agent_site_visits SET status = ?, agent_notes = ? WHERE id = ? AND agent_id = ?");
        $stmt->execute([$new_status, $notes, $visit_id, $_SESSION['agent_id']]);
        $success_msg = "Status updated successfully!";
    } catch (PDOException $e) {
        $error_msg = "Update Error: " . $e->getMessage();
    }
}

// Fetch Assigned Site Visits
try {
    $visits_stmt = $conn->prepare("
        SELECT asv.*, sv.project_name, sv.name, sv.email, sv.phone, sv.visit_date, sv.visit_time, sv.message 
        FROM agent_site_visits asv
        JOIN site_visits sv ON asv.site_visit_id = sv.id
        WHERE asv.agent_id = ?
        ORDER BY asv.created_at DESC
    ");
    $visits_stmt->execute([$_SESSION['agent_id']]);
    $site_visits = $visits_stmt->fetchAll();
} catch (PDOException $e) {
    $site_visits = [];
    $error_msg = "Error fetching site visits.";
}
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <h1>Site Visit Requests</h1>
        <p style="color: #718096; margin-top: 5px;">Manage site visit requests assigned to your projects.</p>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 5px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <?php if ($error_msg): ?>
        <div style="background: #fff5f5; color: #c53030; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 5px solid #c53030;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?>
        </div>
    <?php endif; ?>

    <style>
        .visits-table-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            padding: 15px 20px;
            text-align: left;
            font-size: 13px;
            font-weight: 700;
            color: #4a5568;
            text-transform: uppercase;
            border-bottom: 2px solid #edf2f7;
        }

        td {
            padding: 15px 20px;
            border-bottom: 1px solid #edf2f7;
            font-size: 14px;
            vertical-align: middle;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .status-pending { background: #fffaf0; color: #b7791f; }
        .status-contacted { background: #ebf8ff; color: #2b6cb0; }
        .status-completed { background: #f0fff4; color: #2f855a; }
        .status-cancelled { background: #fff5f5; color: #c53030; }

        .btn-action {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #4a5568;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background: #f7fafc;
            color: var(--primary-gold);
            border-color: var(--primary-gold);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: #fff;
            padding: 35px;
            border-radius: 16px;
            width: 550px;
            max-width: 95%;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }

        .modal-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #edf2f7;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            color: #2d3748;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #4a5568;
            margin-bottom: 10px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            color: #2d3748;
            box-sizing: border-box;
            background: #f8fafc;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-gold);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.1);
        }

        .lead-info-box {
            padding: 18px;
            background: #f7fafc;
            border-radius: 10px;
            font-size: 14px;
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 25px;
            border-left: 4px solid var(--primary-gold);
        }
    </style>

    <div class="visits-table-card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Lead Details</th>
                        <th>Project</th>
                        <th>Preferred Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($site_visits)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #a0aec0;">
                                <i class="fas fa-calendar-times" style="font-size: 40px; margin-bottom: 15px; display: block;"></i>
                                No site visit requests assigned to you yet.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($site_visits as $visit): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 700;"><?php echo htmlspecialchars($visit['name']); ?></div>
                                    <div style="font-size: 12px; color: #718096; margin-top: 2px;">
                                        <i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($visit['phone']); ?><br>
                                        <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($visit['email']); ?>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600;"><?php echo htmlspecialchars($visit['project_name']); ?></div>
                                    <div style="font-size: 12px; color: #718096;">Created: <?php echo date('d M Y', strtotime($visit['created_at'])); ?></div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--primary-gold);">
                                        <?php echo date('d M Y', strtotime($visit['visit_date'])); ?>
                                    </div>
                                    <div style="font-size: 12px; color: #718096;"><?php echo htmlspecialchars($visit['visit_time']); ?></div>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $visit['status']; ?>">
                                        <?php echo ucfirst($visit['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn-action" onclick="openUpdateModal(<?php echo htmlspecialchars(json_encode($visit)); ?>)">
                                        <i class="fas fa-edit"></i> Update Plan
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <h2 style="margin-top: 0; font-size: 20px; border-bottom: 1px solid #edf2f7; padding-bottom: 15px; margin-bottom: 20px;">Update Request Status</h2>
        <form action="" method="POST">
            <input type="hidden" name="visit_id" id="modal_visit_id">
            
            <div class="form-group">
                <label>Lead Information</label>
                <div id="modal_lead_info" style="padding: 10px; background: #f8fafc; border-radius: 6px; font-size: 13px; color: #4a5568;"></div>
            </div>

            <div class="form-group">
                <label>Update Status</label>
                <select name="status" id="modal_status" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="contacted">Contacted</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="form-group">
                <label>Professional Notes</label>
                <textarea name="notes" id="modal_notes" class="form-control" rows="4" placeholder="Enter follow-up details..."></textarea>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" name="update_status" class="btn-gold" style="flex: 1;">Save Updates</button>
                <button type="button" class="btn-action" style="flex: 1;" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('updateModal');

    function openUpdateModal(visit) {
        document.getElementById('modal_visit_id').value = visit.id;
        document.getElementById('modal_status').value = visit.status;
        document.getElementById('modal_notes').value = visit.agent_notes || '';
        document.getElementById('modal_lead_info').innerHTML = `
            <strong>${visit.name}</strong> - ${visit.phone}<br>
            Project: ${visit.project_name}<br>
            Visit Date: ${visit.visit_date} (${visit.visit_time})<br>
            Message: ${visit.message || 'No specific requirements.'}
        `;
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    // Close modal on click outside
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

<?php include 'includes/footer.php'; ?>
