<?php
/**
 * Manage Callback Requests
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
    $allowed_status = ['pending', 'completed', 'closed'];
    
    if (in_array($status, $allowed_status)) {
        try {
            $stmt = $conn->prepare("UPDATE callbacks SET status = :status WHERE id = :id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $success_msg = "Callback status updated!";
        } catch (PDOException $e) {
            $error_msg = "Error updating status.";
        }
    }
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM callbacks WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $success_msg = "Request deleted successfully!";
    } catch (PDOException $e) {
        $error_msg = "Error deleting request.";
    }
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

try {
    // Get total count
    $count_stmt = $conn->query("SELECT COUNT(*) FROM callbacks");
    $total_items = $count_stmt->fetchColumn();
    $total_pages = ceil($total_items / $limit);

    // Fetch requests
    $stmt = $conn->prepare("SELECT * FROM callbacks ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
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
            <h1 style="font-size: 28px; font-weight: 700;">Callback Requests</h1>
            <p style="color: #666;">Manage scheduled call requests from the footer.</p>
        </div>
        <div style="background: #000; color: #fff; padding: 10px 20px; border-radius: 4px; font-weight: 600;">
            Pending: <?php echo $total_items; ?>
        </div>
    </div>

    <?php if ($success_msg): ?>
        <div style="background-color: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <style>
        .callback-list-card {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .callback-table {
            width: 100%;
            border-collapse: collapse;
        }

        .callback-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #edf2f7;
            color: #718096;
            font-size: 14px;
        }

        .callback-table td {
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
        .status-completed { background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8; }
        .status-closed { background: #f7fafc; color: #718096; border: 1px solid #e2e8f0; }

        .time-tag {
            background: #f7fafc;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #4a5568;
            font-weight: 600;
            display: inline-block;
            margin-top: 5px;
            border: 1px solid #e2e8f0;
        }

        .action-btns {
            display: flex;
            gap: 12px;
            font-size: 18px;
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
            background: #000;
            color: #fff;
            border-color: #000;
        }
    </style>

    <div class="callback-list-card">
        <div style="overflow-x: auto;">
            <table class="callback-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Requester</th>
                        <th>Timing</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($requests) > 0): ?>
                        <?php foreach ($requests as $row): ?>
                            <tr>
                                <td>
                                    <strong><?php echo date('d M Y', strtotime($row['created_at'])); ?></strong><br>
                                    <small style="color: #999;"><?php echo date('h:i A', strtotime($row['created_at'])); ?></small>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #2d3748;"><?php echo htmlspecialchars($row['name']); ?></div>
                                    <div style="font-size: 13px; color: #4a5568;"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($row['phone']); ?></div>
                                    <div style="font-size: 13px; color: #4a5568;"><i class="fas fa-envelope"></i> <small><?php echo htmlspecialchars($row['email']); ?></small></div>
                                </td>
                                <td>
                                    <span class="time-tag"><i class="far fa-clock"></i> <?php echo htmlspecialchars($row['preferred_time']); ?></span>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $row['status']; ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <?php if ($row['status'] == 'pending'): ?>
                                            <a href="?action=update_status&id=<?php echo $row['id']; ?>&status=completed" class="btn-status-update" title="Mark Completed"><i class="fas fa-check-circle"></i></a>
                                        <?php elseif ($row['status'] == 'completed'): ?>
                                            <a href="?action=update_status&id=<?php echo $row['id']; ?>&status=closed" class="btn-status-update" title="Close Request" style="color: #718096;"><i class="fas fa-archive"></i></a>
                                        <?php endif; ?>
                                        
                                        <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn-delete" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 50px; color: #a0aec0;">No callback requests found.</td>
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

</body>
</html>
