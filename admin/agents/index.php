<?php
/**
 * Manage Agents
 * Dholera Smart City Admin
 */
session_start();
require_once '../../database/db_config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

// Handle Status Toggle or Delete
if (isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] === 'toggle') {
        $stmt = $conn->prepare("UPDATE agents SET status = IF(status='active', 'inactive', 'active') WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($_GET['action'] === 'delete') {
        // Fetch image path to delete file
        $img_stmt = $conn->prepare("SELECT profile_image FROM agents WHERE id = ?");
        $img_stmt->execute([$id]);
        $row = $img_stmt->fetch();
        if ($row && $row['profile_image'] && file_exists('../../' . $row['profile_image'])) {
            unlink('../../' . $row['profile_image']);
        }
        $stmt = $conn->prepare("DELETE FROM agents WHERE id = ?");
        $stmt->execute([$id]);
    }
    header("Location: index.php");
    exit();
}

// Pagination Logic
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

try {
    $total_stmt = $conn->query("SELECT COUNT(*) FROM agents");
    $total_records = $total_stmt->fetchColumn();
    $total_pages = ceil($total_records / $limit);

    $stmt = $conn->prepare("SELECT * FROM agents ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $agents = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700;">Manage Agents</h1>
            <p style="color: #666;">View and manage registered real estate agents.</p>
        </div>
        <a href="add-agent.php" class="btn-update" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-user-plus"></i> Add New Agent
        </a>
    </div>

    <style>
        .table-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 30px;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #edf2f7;
            font-size: 14px;
            color: #718096;
            text-transform: uppercase;
        }

        .admin-table td {
            padding: 15px;
            border-bottom: 1px solid #edf2f7;
            font-size: 15px;
            vertical-align: middle;
        }

        .agent-profile {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #edf2f7;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-active { background-color: #f0fff4; color: #38a169; }
        .badge-inactive { background-color: #fff5f5; color: #c53030; }

        .action-btn {
            padding: 8px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            background: transparent;
            color: #718096;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
        }

        .action-btn:hover {
            border-color: var(--primary-gold);
            color: var(--primary-gold);
        }

        .action-btn.btn-delete:hover {
            border-color: #e53e3e;
            color: #e53e3e;
        }

        .pagination-nav {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .page-link {
            padding: 8px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            color: #2d3748;
            text-decoration: none;
            transition: all 0.2s;
        }

        .page-link:hover, .page-link.active {
            background: var(--primary-gold);
            color: #fff;
            border-color: var(--primary-gold);
        }

        .page-link.disabled {
            background: #f7fafc;
            color: #a0aec0;
            cursor: not-allowed;
            pointer-events: none;
        }
        
        .btn-update {
            background-color: var(--primary-gold);
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
    </style>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Agent</th>
                    <th>Contact Info</th>
                    <th>Location</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($agents)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #718096;">No agents found. Start by adding one!</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($agents as $agent): ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <img src="<?php echo $agent['profile_image'] ? '../../'.$agent['profile_image'] : '../../assets/images/placeholder-user.png'; ?>" class="agent-profile">
                                    <div style="font-weight: 700; color: #2d3748;"><?php echo htmlspecialchars($agent['full_name']); ?></div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 14px;">
                                    <div><i class="far fa-envelope" style="width: 20px; color: var(--primary-gold);"></i> <?php echo htmlspecialchars($agent['email']); ?></div>
                                    <div style="color: #718096; margin-top: 4px;"><i class="fas fa-phone-alt" style="width: 20px; color: var(--primary-gold);"></i> <?php echo htmlspecialchars($agent['mobile']); ?></div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 14px;">
                                    <?php echo htmlspecialchars($agent['city'] ?: 'N/A'); ?>, <?php echo htmlspecialchars($agent['state'] ?: 'N/A'); ?>
                                </div>
                            </td>
                            <td style="color: #718096; font-size: 14px;">
                                <?php echo date('M d, Y', strtotime($agent['created_at'])); ?>
                            </td>
                            <td>
                                <span class="status-badge badge-<?php echo $agent['status']; ?>">
                                    <?php echo ucfirst($agent['status']); ?>
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="edit-agent.php?id=<?php echo $agent['id']; ?>" class="action-btn" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="?action=toggle&id=<?php echo $agent['id']; ?>" class="action-btn" title="Toggle Status"><i class="fas fa-sync-alt"></i></a>
                                    <a href="?action=delete&id=<?php echo $agent['id']; ?>" class="action-btn btn-delete" title="Delete" onclick="return confirm('Are you sure you want to remove this agent?')"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination-nav">
                <a href="?page=<?php echo max(1, $page - 1); ?>" class="page-link <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="page-link <?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                <a href="?page=<?php echo min($total_pages, $page + 1); ?>" class="page-link <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
