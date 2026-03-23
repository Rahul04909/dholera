<?php
/**
 * Manage Agent Packages
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

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    try {
        $stmt = $conn->prepare("DELETE FROM agent_packages WHERE id = ?");
        $stmt->execute([$id]);
        $success_msg = "Package deleted successfully!";
    } catch (PDOException $e) {
        $error_msg = "Error deleting package: " . $e->getMessage();
    }
}

// Fetch Packages
try {
    $stmt = $conn->query("SELECT * FROM agent_packages ORDER BY created_at DESC");
    $packages = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="main-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700;">Agent Subscription Packages</h1>
            <p style="color: #666;">Create and manage subscription plans for agents.</p>
        </div>
        <a href="add-package.php" style="background: var(--primary-gold); color: #fff; padding: 12px 25px; border-radius: 4px; text-decoration: none; font-weight: 700;">
            <i class="fas fa-plus"></i> Add New Package
        </a>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <?php if ($error_msg): ?>
        <div style="background: #fff5f5; color: #e53e3e; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid #e53e3e;">
            <i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?>
        </div>
    <?php endif; ?>

    <style>
        .package-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .package-table { width: 100%; border-collapse: collapse; }
        .package-table th { text-align: left; padding: 15px; border-bottom: 2px solid #edf2f7; color: #718096; font-size: 14px; }
        .package-table td { padding: 15px; border-bottom: 1px solid #edf2f7; vertical-align: middle; }
        .action-btns { display: flex; gap: 15px; font-size: 18px; }
        .btn-edit { color: #3182ce; }
        .btn-delete { color: #e53e3e; }
        .badge-status { padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .status-active { background: #e6fffa; color: #38a169; }
        .status-inactive { background: #fff5f5; color: #e53e3e; }
    </style>

    <div class="package-card">
        <div style="overflow-x: auto;">
            <table class="package-table">
                <thead>
                    <tr>
                        <th>Package Name</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($packages) > 0): ?>
                        <?php foreach ($packages as $row): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($row['package_name']); ?></strong></td>
                                <td>₹ <?php echo number_format($row['price'], 2); ?></td>
                                <td><?php echo $row['duration_months']; ?> Month<?php echo $row['duration_months'] > 1 ? 's' : ''; ?></td>
                                <td>
                                    <span class="badge-status status-<?php echo $row['status']; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="edit-package.php?id=<?php echo $row['id']; ?>" class="btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn-delete" title="Delete" onclick="return confirm('Delete this package?')"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align: center; padding: 50px; color: #a0aec0;">No packages found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
