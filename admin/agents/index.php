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

$total_stmt = $conn->query("SELECT COUNT(*) FROM agents");
$total_records = $total_stmt->fetchColumn();
$total_pages = ceil($total_records / $limit);

$stmt = $conn->prepare("SELECT * FROM agents ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$agents = $stmt->fetchAll();

include '../includes/header.php';
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Manage Agents</h4>
                    <p class="mb-0">Listing of all registered real estate agents</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <a href="add-agent.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New Agent</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-md">
                                <thead>
                                    <tr>
                                        <th style="width:80px;"><strong>#</strong></th>
                                        <th><strong>PROFILE</strong></th>
                                        <th><strong>NAME</strong></th>
                                        <th><strong>CONTACT</strong></th>
                                        <th><strong>LOCATION</strong></th>
                                        <th><strong>STATUS</strong></th>
                                        <th><strong>ACTION</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($agents)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No agents found.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php 
                                        $count = $offset + 1;
                                        foreach($agents as $agent): 
                                        ?>
                                        <tr>
                                            <td><strong><?php echo $count++; ?></strong></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo $agent['profile_image'] ? '../../'.$agent['profile_image'] : '../../assets/images/placeholder-user.png'; ?>" class="rounded-circle" width="35" height="35" alt="">
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($agent['full_name']); ?></td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="text-dark"><i class="fa fa-envelope fs-12 mr-1"></i> <?php echo htmlspecialchars($agent['email']); ?></span>
                                                    <span class="text-muted"><i class="fa fa-phone fs-12 mr-1"></i> <?php echo htmlspecialchars($agent['mobile']); ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-light"><?php echo htmlspecialchars($agent['city'] ?: 'N/A'); ?>, <?php echo htmlspecialchars($agent['state'] ?: 'N/A'); ?></span>
                                            </td>
                                            <td>
                                                <span class="badge badge-<?php echo $agent['status'] === 'active' ? 'success' : 'danger'; ?>">
                                                    <?php echo ucfirst($agent['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="edit-agent.php?id=<?php echo $agent['id']; ?>" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                    <a href="?action=toggle&id=<?php echo $agent['id']; ?>" class="btn btn-info shadow btn-xs sharp mr-1" title="Toggle Status"><i class="fa fa-refresh"></i></a>
                                                    <a href="?action=delete&id=<?php echo $agent['id']; ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Are you sure you want to delete this agent?')"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if($total_pages > 1): ?>
                        <div class="d-flex justify-content-center mt-3">
                            <nav>
                                <ul class="pagination pagination-gutter pagination-primary no-bg">
                                    <li class="page-item page-indicator <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                    </li>
                                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item page-indicator <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">
                                            <i class="la la-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
