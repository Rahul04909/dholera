<?php
/**
 * Manage Site Visit Requests
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

// Handle Status Update
if (isset($_GET['action']) && $_GET['action'] == 'update_status' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['status'];
    $allowed_status = ['pending', 'confirmed', 'cancelled', 'completed'];
    
    if (in_array($status, $allowed_status)) {
        try {
            $stmt = $conn->prepare("UPDATE site_visits SET status = :status WHERE id = :id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $success_msg = "Visit status updated successfully!";
        } catch (PDOException $e) {
            $error_msg = "Error updating status.";
        }
    }
}

// Handle Lead Forwarding
if (isset($_POST['forward_lead'])) {
    $agent_id = (int)$_POST['agent_id'];
    $source_id = (int)$_POST['source_id'];
    $source_type = 'enquiry'; // Treating as enquiry for agent leads table for now, or we can add 'site-visit' 
    $admin_note = trim($_POST['admin_note']);

    try {
        // We'll use 'enquiry' as source_type since the agent_leads table has it in enum, 
        // or we could update the enum. For now, let's stick to the current schema.
        $stmt = $conn->prepare("INSERT INTO agent_leads (agent_id, source_type, source_id, admin_note) VALUES (:agent_id, 'enquiry', :source_id, :admin_note)");
        $stmt->execute([
            'agent_id' => $agent_id,
            'source_id' => $source_id,
            'admin_note' => "SITE VISIT REQUEST: " . $admin_note
        ]);
        $success_msg = "Site visit request forwarded to agent!";
    } catch (PDOException $e) {
        $error_msg = "Error forwarding: " . $e->getMessage();
    }
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM site_visits WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $success_msg = "Request deleted successfully!";
    } catch (PDOException $e) {
        $error_msg = "Error deleting request.";
    }
}

// Fetch active agents for forwarding
try {
    $agents_stmt = $conn->query("SELECT id, full_name FROM agents WHERE status = 'active' ORDER BY full_name ASC");
    $active_agents = $agents_stmt->fetchAll();
} catch (PDOException $e) {
    $active_agents = [];
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

try {
    // Get total count
    $count_stmt = $conn->query("SELECT COUNT(*) FROM site_visits");
    $total_items = $count_stmt->fetchColumn();
    $total_pages = ceil($total_items / $limit);

    // Fetch requests
    $stmt = $conn->prepare("SELECT * FROM site_visits ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $requests = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700;">Site Visit Requests</h1>
            <p style="color: #666;">Manage scheduled project tours from interested customers.</p>
        </div>
        <div style="background: var(--primary-gold); color: #fff; padding: 10px 20px; border-radius: 4px; font-weight: 600;">
            Total: <?php echo $total_items; ?>
        </div>
    </div>

    <?php if ($success_msg): ?>
        <div style="background-color: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <style>
        .visit-list-card {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .visit-table {
            width: 100%;
            border-collapse: collapse;
        }

        .visit-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #edf2f7;
            color: #718096;
            font-size: 14px;
        }

        .visit-table td {
            padding: 15px;
            border-bottom: 1px solid #edf2f7;
            vertical-align: top;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending { background: #fffaf0; color: #b7791f; border: 1px solid #fbd38d; }
        .status-confirmed { background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8; }
        .status-cancelled { background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
        .status-completed { background: #f0fff4; color: #38a169; border: 1px solid #9ae6b4; }

        .action-btns {
            display: flex;
            gap: 12px;
            font-size: 18px;
        }

        .action-btns a {
            transition: color 0.3s;
        }

        .btn-status-update { color: #3182ce; }
        .btn-delete { color: #e53e3e; }

        .pagination {
            display: flex;
            gap: 5px;
            margin-top: 30px;
            justify-content: center;
        }

        .page-link {
            padding: 8px 15px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            text-decoration: none;
            color: #4a5568;
            font-weight: 600;
        }

        .page-link.active {
            background: var(--primary-gold);
            color: #fff;
            border-color: var(--primary-gold);
        }
    </style>

    <div class="visit-list-card">
        <div style="overflow-x: auto;">
            <table class="visit-table">
                <thead>
                    <tr>
                        <th>Visit Timing</th>
                        <th>Project</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($requests) > 0): ?>
                        <?php foreach ($requests as $row): ?>
                            <tr>
                                <td>
                                    <strong><i class="far fa-calendar-alt"></i> <?php echo date('d M Y', strtotime($row['visit_date'])); ?></strong><br>
                                    <span style="font-size: 13px; color: #3182ce;"><i class="far fa-clock"></i> <?php echo htmlspecialchars($row['visit_time']); ?></span>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--primary-gold);"><?php echo htmlspecialchars($row['project_name']); ?></div>
                                    <small style="color: #999;">Request on: <?php echo date('d M, h:i A', strtotime($row['created_at'])); ?></small>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #2d3748;"><?php echo htmlspecialchars($row['name']); ?></div>
                                    <div style="font-size: 13px; color: #4a5568;"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($row['phone']); ?></div>
                                    <div style="font-size: 13px; color: #4a5568;"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?></div>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $row['status']; ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <!-- Forward Lead -->
                                        <a href="javascript:void(0)" class="btn-status-update" title="Forward to Agent" onclick="openForwardModal(<?php echo $row['id']; ?>, 'visit', '<?php echo addslashes($row['name']); ?>')"><i class="fas fa-share-square"></i></a>
                                        
                                        <!-- Status Updates -->
                                        <?php if ($row['status'] == 'pending'): ?>
                                            <a href="?action=update_status&id=<?php echo $row['id']; ?>&status=confirmed" style="color: #2b6cb0;" title="Confirm Visit"><i class="fas fa-check-circle"></i></a>
                                        <?php elseif ($row['status'] == 'confirmed'): ?>
                                            <a href="?action=update_status&id=<?php echo $row['id']; ?>&status=completed" style="color: #38a169;" title="Mark Completed"><i class="fas fa-flag-checkered"></i></a>
                                        <?php endif; ?>
                                        
                                        <?php if ($row['status'] != 'cancelled'): ?>
                                            <a href="?action=update_status&id=<?php echo $row['id']; ?>&status=cancelled" style="color: #e53e3e;" title="Cancel visit"><i class="fas fa-times-circle"></i></a>
                                        <?php endif; ?>

                                        <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn-delete" title="Delete" onclick="return confirm('Delete this request permanentally?')"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 50px; color: #a0aec0;">No site visit requests found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="page-link <?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Forward Modal -->
<div id="forwardModal" style="display:none; position:fixed; z-index:2000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
    <div style="background:#fff; width:100%; max-width:500px; padding:30px; border-radius:8px; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <h2 id="modalTitle" style="margin-top:0; border-bottom:1px solid #edf2f7; padding-bottom:15px;">Forward Request</h2>
        <form method="POST">
            <input type="hidden" name="source_id" id="modalSourceId">
            <input type="hidden" name="source_type" id="modalSourceType">
            
            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:700; margin-bottom:10px;">Select Agent <span style="color:red">*</span></label>
                <select name="agent_id" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:4px;">
                    <option value="">-- Select Agent --</option>
                    <?php foreach ($active_agents as $agent): ?>
                        <option value="<?php echo $agent['id']; ?>"><?php echo htmlspecialchars($agent['full_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div style="margin-bottom:20px;">
                <label style="display:block; font-weight:700; margin-bottom:10px;">Visit Note for Agent</label>
                <textarea name="admin_note" rows="3" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:4px;" placeholder="Tell agent about visit timing or project priority..."></textarea>
            </div>
            
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="closeForwardModal()" style="padding:10px 20px; background:#f7fafc; border:1px solid #e2e8f0; border-radius:4px; cursor:pointer;">Cancel</button>
                <button type="submit" name="forward_lead" style="padding:10px 20px; background:var(--primary-gold); color:#fff; border:none; border-radius:4px; font-weight:700; cursor:pointer;">Assign Visit to Agent</button>
            </div>
        </form>
    </div>
</div>

<script>
function openForwardModal(id, type, name) {
    document.getElementById('modalSourceId').value = id;
    document.getElementById('modalSourceType').value = type;
    document.getElementById('modalTitle').innerHTML = 'Assign: ' + name;
    document.getElementById('forwardModal').style.display = 'flex';
}

function closeForwardModal() {
    document.getElementById('forwardModal').style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('forwardModal');
    if (event.target == modal) {
        closeForwardModal();
    }
}
</script>

</body>
</html>
