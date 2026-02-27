<?php
/**
 * Project Management Dashboard
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
        // Fetch files to delete from server
        $stmt = $conn->prepare("SELECT featured_image, brochure_pdf, site_plan_image FROM projects WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $project = $stmt->fetch();

        // Delete main record (cascading deletes for slides/amenities if foreign keys set)
        $conn->prepare("DELETE FROM projects WHERE id = :id")->execute(['id' => $id]);

        // Cleanup files
        if ($project) {
            foreach (['featured_image', 'brochure_pdf', 'site_plan_image'] as $field) {
                if ($project[$field] && file_exists('../../' . $project[$field])) {
                    unlink('../../' . $project[$field]);
                }
            }
        }
        $success_msg = "Project and all associated data deleted!";
    } catch (PDOException $e) {
        $error_msg = "Error deleting project.";
    }
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

try {
    $total_items = $conn->query("SELECT COUNT(*) FROM projects")->fetchColumn();
    $total_pages = ceil($total_items / $limit);

    $stmt = $conn->prepare("SELECT * FROM projects ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="main-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700;">Manage Projects</h1>
            <p style="color: #666;">View and manage all real estate projects.</p>
        </div>
        <a href="add-project.php" style="background: var(--primary-gold); color: #fff; padding: 12px 25px; border-radius: 4px; text-decoration: none; font-weight: 700;">
            <i class="fas fa-plus"></i> Add New Project
        </a>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px; border-left: 4px solid #38a169;">
            <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
        </div>
    <?php endif; ?>

    <style>
        .project-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .project-table { width: 100%; border-collapse: collapse; }
        .project-table th { text-align: left; padding: 15px; border-bottom: 2px solid #edf2f7; color: #718096; font-size: 14px; }
        .project-table td { padding: 15px; border-bottom: 1px solid #edf2f7; vertical-align: middle; }
        .thumb { width: 80px; height: 50px; object-fit: cover; border-radius: 4px; background: #eee; }
        .badge-type { background: #edf2f7; color: #4a5568; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .action-btns { display: flex; gap: 15px; font-size: 18px; }
        .btn-edit { color: #3182ce; }
        .btn-delete { color: #e53e3e; }
        .pagination { display: flex; gap:5px; margin-top: 30px; justify-content: center; }
        .page-link { padding: 8px 15px; background: #fff; border: 1px solid #e2e8f0; border-radius: 4px; text-decoration: none; color: #4a5568; }
        .page-link.active { background: var(--primary-gold); color: #fff; border-color: var(--primary-gold); }
    </style>

    <div class="project-card">
        <div style="overflow-x: auto;">
            <table class="project-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Project Name</th>
                        <th>Location / Type</th>
                        <th>Price Range</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($projects) > 0): ?>
                        <?php foreach ($projects as $row): ?>
                            <tr>
                                <td>
                                    <?php if ($row['featured_image']): ?>
                                        <img src="../../<?php echo $row['featured_image']; ?>" class="thumb">
                                    <?php else: ?>
                                        <div class="thumb" style="display: flex; align-items: center; justify-content: center;"><i class="fas fa-image" style="color:#ccc;"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                                    <small style="color: #666;"><?php echo htmlspecialchars($row['label']); ?></small>
                                </td>
                                <td>
                                    <div style="font-size: 13px;"><i class="fas fa-map-marker-alt" style="color:var(--primary-gold);"></i> <?php echo htmlspecialchars($row['location']); ?></div>
                                    <span class="badge-type"><?php echo htmlspecialchars($row['project_type']); ?></span>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #2d3748;">₹ <?php echo htmlspecialchars($row['price_range'] ?: 'N/A'); ?></span>
                                </td>
                                <td>
                                    <span style="color: <?php echo $row['status'] == 'active' ? '#38a169' : '#e53e3e'; ?>; font-weight: 700; font-size: 12px; text-transform: uppercase;">
                                        ● <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="edit-project.php?id=<?php echo $row['id']; ?>" class="btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a href="?action=delete&id=<?php echo $row['id']; ?>" class="btn-delete" title="Delete" onclick="return confirm('Delete this project and all assets?')"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align: center; padding: 50px; color: #a0aec0;">No projects found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php for($i=1; $i<=$total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="page-link <?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
