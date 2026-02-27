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

// Handle Status Update
if (isset($_GET['action']) && $_GET['action'] == 'update_status' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $new_status = $_GET['status'] == 'closed' ? 'closed' : 'pending';
    try {
        $stmt = $conn->prepare("UPDATE enquiries SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $success_msg = "Enquiry status updated!";
    } catch (PDOException $e) {
        $error_msg = "Error updating status.";
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
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700;">Customer Enquiries</h1>
            <p style="color: #666;">View and manage leads from the website.</p>
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
        .enquiry-list-card {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .enquiry-table {
            width: 100%;
            border-collapse: collapse;
        }

        .enquiry-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #edf2f7;
            color: #718096;
            font-size: 14px;
        }

        .enquiry-table td {
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
        .status-closed { background: #f0fff4; color: #38a169; border: 1px solid #9ae6b4; }

        .action-btns {
            display: flex;
            gap: 15px;
            font-size: 18px;
        }

        .action-btns a {
            transition: color 0.3s;
        }

        .btn-view { color: #3182ce; }
        .btn-delete { color: #e53e3e; }
        .btn-status { color: #805ad5; }

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
            transition: all 0.3s;
        }

        .page-link.active {
            background: var(--primary-gold);
            color: #fff;
            border-color: var(--primary-gold);
        }

        .page-link:hover:not(.active) {
            background: #f7fafc;
        }
    </style>

    <div class="enquiry-list-card">
        <div style="overflow-x: auto;">
            <table class="enquiry-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($enquiries) > 0): ?>
                        <?php foreach ($enquiries as $row): ?>
                            <tr>
                                <td style="white-space: nowrap;">
                                    <strong><?php echo date('d M Y', strtotime($row['created_at'])); ?></strong><br>
                                    <small style="color: #999;"><?php echo date('h:i A', strtotime($row['created_at'])); ?></small>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #2d3748;"><?php echo htmlspecialchars($row['name']); ?></div>
                                    <div style="font-size: 13px; color: #4a5568;"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?></div>
                                    <div style="font-size: 13px; color: #4a5568;"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($row['phone']); ?></div>
                                </td>
                                <td>
                                    <div style="font-size: 14px; max-width: 300px; color: #4a5568; line-height: 1.5;">
                                        <?php echo !empty($row['message']) ? nl2br(htmlspecialchars($row['message'])) : '<em style="color:#ccc;">No message</em>'; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $row['status']; ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <?php if ($row['status'] == 'pending'): ?>
                                            <a href="?action=update_status&id=<?php echo $row['id']; ?>&status=closed" class="btn-status" title="Mark Closed"><i class="fas fa-check-double"></i></a>
                                        <?php else: ?>
                                            <a href="?action=update_status&id=<?php echo $row['id']; ?>&status=pending" class="btn-status" title="Reopen" style="color: #718096;"><i class="fas fa-undo"></i></a>
                                        <?php endif; ?>
                                        <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this enquiry?')"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 50px; color: #a0aec0;">No enquiries found.</td>
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
