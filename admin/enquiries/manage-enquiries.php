<?php
/**
 * Manage Enquiries
 * Dholera Smart City
 */

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../../database/db_config.php';

$success_msg = "";
$error_msg = "";

// Handle Update Enquiry (AJAX or POST)
if (isset($_POST['update_enquiry'])) {
    $id = (int)$_POST['enquiry_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $subject = trim($_POST['subject']);
    $status = $_POST['status'];
    $message = trim($_POST['message']);

    try {
        $stmt = $conn->prepare("UPDATE enquiries SET name = ?, email = ?, phone = ?, subject = ?, status = ?, message = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone, $subject, $status, $message, $id]);
        $success_msg = "Enquiry updated successfully!";
    } catch (PDOException $e) {
        $error_msg = "Error updating enquiry: " . $e->getMessage();
    }
}

// Handle Status Update (Quick Action)
if (isset($_GET['action']) && $_GET['action'] == 'update_status' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $new_status = $_GET['status'];
    $allowed = ['pending', 'contacted', 'closed'];
    
    if (in_array($new_status, $allowed)) {
        try {
            $stmt = $conn->prepare("UPDATE enquiries SET status = :status WHERE id = :id");
            $stmt->bindParam(':status', $new_status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $success_msg = "Status updated!";
        } catch (PDOException $e) {
            $error_msg = "Error updating status.";
        }
    }
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM enquiries WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $success_msg = "Enquiry deleted successfully!";
    } catch (PDOException $e) {
        $error_msg = "Error deleting enquiry.";
    }
}

// Handle Lead Forwarding
if (isset($_POST['forward_lead'])) {
    $agent_id = (int)$_POST['agent_id'];
    $source_id = (int)$_POST['source_id'];
    $source_type = $_POST['source_type'];
    $admin_note = trim($_POST['admin_note']);

    try {
        $stmt = $conn->prepare("INSERT INTO agent_leads (agent_id, source_type, source_id, admin_note) VALUES (:agent_id, :source_type, :source_id, :admin_note)");
        $stmt->execute([
            'agent_id' => $agent_id,
            'source_type' => $source_type,
            'source_id' => $source_id,
            'admin_note' => $admin_note
        ]);
        $success_msg = "Lead forwarded to agent successfully!";
    } catch (PDOException $e) {
        $error_msg = "Error forwarding lead: " . $e->getMessage();
    }
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

try {
    // Get total count
    $count_stmt = $conn->query("SELECT COUNT(*) FROM enquiries");
    $total_items = $count_stmt->fetchColumn();
    $total_pages = ceil($total_items / $limit);

    // Fetch enquiries
    $stmt = $conn->prepare("SELECT * FROM enquiries ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $enquiries = $stmt->fetchAll();

    // Fetch active agents for forwarding
    $agents_stmt = $conn->query("SELECT id, full_name FROM agents WHERE status = 'active' ORDER BY full_name ASC");
    $active_agents = $agents_stmt->fetchAll();

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<style>
    :root {
        --primary-gold: #b8860b;
        --success-green: #38a169;
        --pending-yellow: #b7791f;
        --contacted-blue: #3182ce;
        --danger-red: #e53e3e;
    }

    .main-content { padding: 30px; }
    
    .manage-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        padding: 30px;
    }

    .table-responsive { overflow-x: auto; }
    
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 15px;
        text-align: left;
        font-size: 13px;
        font-weight: 700;
        color: #718096;
        text-transform: uppercase;
        border-bottom: 2px solid #edf2f7;
    }

    .custom-table td {
        padding: 15px;
        border-bottom: 1px solid #edf2f7;
        font-size: 14px;
        vertical-align: middle;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-pending { background: #fffaf0; color: #b7791f; border: 1px solid #fbd38d; }
    .status-contacted { background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8; }
    .status-closed { background: #f0fff4; color: #38a169; border: 1px solid #9ae6b4; }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid #e2e8f0;
        background: #fff;
        font-size: 14px;
    }

    .btn-edit { color: #3182ce; }
    .btn-forward { color: #805ad5; }
    .btn-delete { color: #e53e3e; }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: #fff;
        width: 600px;
        max-width: 95%;
        border-radius: 16px;
        padding: 35px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    .modal-header {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #edf2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 { margin: 0; font-size: 22px; font-weight: 800; }

    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 700; font-size: 14px; margin-bottom: 8px; color: #4a5568; }
    .form-control {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
    }

    .btn-gold {
        background: var(--primary-gold);
        color: #fff;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
    }
</style>

<div class="main-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 800; color: #2d3748;">Customer Enquiries</h1>
            <p style="color: #718096;">Manage and respond to website enquiries effectively.</p>
        </div>
        <div style="background: var(--primary-gold); color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 700;">
            Total Logs: <?php echo $total_items; ?>
        </div>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 5px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <div class="manage-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Received On</th>
                        <th>Customer Info</th>
                        <th>Subject & Message</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($enquiries) > 0): ?>
                        <?php foreach ($enquiries as $row): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 700;"><?php echo date('d M Y', strtotime($row['created_at'])); ?></div>
                                    <small style="color: #a0aec0;"><?php echo date('h:i A', strtotime($row['created_at'])); ?></small>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #2d3748;"><?php echo htmlspecialchars($row['name']); ?></div>
                                    <div style="font-size: 12px; color: #4a5568; margin-top: 3px;">
                                        <i class="fas fa-phone-alt" style="width: 15px;"></i> <?php echo htmlspecialchars($row['phone']); ?><br>
                                        <i class="fas fa-envelope" style="width: 15px;"></i> <?php echo htmlspecialchars($row['email']); ?>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--primary-gold); margin-bottom: 5px;">
                                        <?php echo htmlspecialchars($row['subject'] ?? 'General Enquiry'); ?>
                                    </div>
                                    <div style="font-size: 13px; color: #718096; max-width: 250px; line-height: 1.4;">
                                        <?php echo mb_strimwidth(htmlspecialchars($row['message']), 0, 100, "..."); ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $row['status']; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 8px;">
                                        <a href="javascript:void(0)" class="action-btn btn-edit" onclick="openEditModal(<?php echo htmlspecialchars(json_encode($row)); ?>)" title="Edit Details">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="action-btn btn-forward" onclick="openForwardModal(<?php echo $row['id']; ?>, 'enquiry', '<?php echo addslashes($row['name']); ?>')" title="Forward to Agent">
                                            <i class="fas fa-share"></i>
                                        </a>
                                        <a href="?action=delete&id=<?php echo $row['id']; ?>" class="action-btn btn-delete" onclick="return confirm('Delete this record permanently?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 50px; color: #a0aec0;">No enquiries recorded yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
            <div style="margin-top: 30px; display: flex; justify-content: center; gap: 10px;">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" style="padding: 8px 15px; border-radius: 6px; background: <?php echo $page == $i ? 'var(--primary-gold)' : '#fff'; ?>; color: <?php echo $page == $i ? '#fff' : '#4a5568'; ?>; border: 1px solid #e2e8f0; font-weight: 700; text-decoration: none;">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Edit Enquiry Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit Customer Enquiry</h2>
            <button onclick="closeEditModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #a0aec0;"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST">
            <input type="hidden" name="enquiry_id" id="edit_id">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" id="edit_phone" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="subject" id="edit_subject" class="form-control">
                </div>
                <div class="form-group">
                    <label>Process Status</label>
                    <select name="status" id="edit_status" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="contacted">Contacted</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Customer Message</label>
                <textarea name="message" id="edit_message" class="form-control" rows="4"></textarea>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px;">
                <button type="submit" name="update_enquiry" class="btn-gold" style="flex: 1;">Update Information</button>
                <button type="button" onclick="closeEditModal()" style="flex: 1; background: #f7fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Forward Modal -->
<div id="forwardModal" class="modal">
    <div class="modal-content" style="width: 450px;">
        <div class="modal-header">
            <h2 id="forwardTitle">Forward Lead</h2>
            <button onclick="closeForwardModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #a0aec0;"><i class="fas fa-times"></i></button>
        </div>
        <form method="POST">
            <input type="hidden" name="source_id" id="forward_source_id">
            <input type="hidden" name="source_type" id="forward_source_type">
            
            <div class="form-group">
                <label>Assign to Agent</label>
                <select name="agent_id" class="form-control" required>
                    <option value="">-- Choose Agent --</option>
                    <?php foreach ($active_agents as $agent): ?>
                        <option value="<?php echo $agent['id']; ?>"><?php echo htmlspecialchars($agent['full_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Internal Notes for Agent</label>
                <textarea name="admin_note" class="form-control" rows="3" placeholder="Explain requirements to agent..."></textarea>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" name="forward_lead" class="btn-gold" style="flex: 1;">Forward Lead</button>
                <button type="button" onclick="closeForwardModal()" style="background: #f7fafc; border: 1px solid #e2e8f0; padding: 10px 20px; border-radius: 8px; font-weight: 700; cursor: pointer;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(data) {
        document.getElementById('edit_id').value = data.id;
        document.getElementById('edit_name').value = data.name;
        document.getElementById('edit_email').value = data.email;
        document.getElementById('edit_phone').value = data.phone;
        document.getElementById('edit_subject').value = data.subject || 'General Enquiry';
        document.getElementById('edit_status').value = data.status;
        document.getElementById('edit_message').value = data.message;
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function openForwardModal(id, type, name) {
        document.getElementById('forward_source_id').value = id;
        document.getElementById('forward_source_type').value = type;
        document.getElementById('forwardTitle').innerText = 'Forwarding: ' + name;
        document.getElementById('forwardModal').style.display = 'flex';
    }

    function closeForwardModal() {
        document.getElementById('forwardModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('editModal')) closeEditModal();
        if (event.target == document.getElementById('forwardModal')) closeForwardModal();
    }
</script>

<?php include '../includes/footer.php'; ?>
