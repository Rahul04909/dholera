<?php
/**
 * Admin Dashboard
 * Dholera Smart City
 */
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require_once '../database/db_config.php';
include 'includes/header.php'; 

// Fetch Real-time Stats
$stats = [
    'projects' => [
        'total' => $conn->query("SELECT COUNT(*) FROM projects")->fetchColumn(),
        'active' => $conn->query("SELECT COUNT(*) FROM projects WHERE status = 'active'")->fetchColumn()
    ],
    'enquiries' => [
        'total' => $conn->query("SELECT COUNT(*) FROM enquiries")->fetchColumn(),
        'pending' => $conn->query("SELECT COUNT(*) FROM enquiries WHERE status = 'pending'")->fetchColumn()
    ],
    'visits' => [
        'total' => $conn->query("SELECT COUNT(*) FROM site_visits")->fetchColumn(),
        'pending' => $conn->query("SELECT COUNT(*) FROM site_visits WHERE status = 'pending'")->fetchColumn()
    ],
    'agents' => [
        'total' => $conn->query("SELECT COUNT(*) FROM agents")->fetchColumn(),
        'active' => $conn->query("SELECT COUNT(*) FROM agents WHERE status = 'active'")->fetchColumn()
    ]
];

// Fetch Recent Enquiries (Latest 5)
$recent_enquiries = $conn->query("SELECT * FROM enquiries ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Fetch Recent Site Visits (Latest 5)
$recent_visits = $conn->query("SELECT sv.*, p.title as project_title FROM site_visits sv LEFT JOIN projects p ON sv.project_id = p.id ORDER BY sv.created_at DESC LIMIT 5")->fetchAll();
?>

<style>
    :root {
        --primary-gold: #b8860b;
        --dark-bg: #0b1622;
        --text-dark: #2d3748;
        --text-muted: #718096;
        --section-bg: #f8fafc;
    }

    .main-content { padding: 30px; background-color: #f4f7f6; }

    .dashboard-welcome h1 { 
        font-size: 30px; 
        font-weight: 800; 
        color: var(--dark-bg);
        margin-bottom: 8px;
    }
    .dashboard-welcome p { color: var(--text-muted); font-size: 16px; margin-bottom: 40px; }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        border-color: var(--primary-gold);
    }

    .stat-icon {
        width: 65px;
        height: 65px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .bg-blue { background: rgba(49, 130, 206, 0.1); color: #3182ce; }
    .bg-gold { background: rgba(184, 134, 11, 0.1); color: var(--primary-gold); }
    .bg-green { background: rgba(56, 161, 105, 0.1); color: #38a169; }
    .bg-purple { background: rgba(128, 90, 213, 0.1); color: #805ad5; }

    .stat-info .label { font-size: 13px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }
    .stat-info .value { font-size: 28px; font-weight: 800; color: var(--dark-bg); line-height: 1.2; }
    .stat-info .sub-val { font-size: 12px; color: var(--text-muted); margin-top: 4px; }

    /* Tables Grid */
    .activity-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 25px;
    }

    .card-box {
        background: #fff;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .card-header h2 { font-size: 20px; font-weight: 800; color: var(--dark-bg); }
    .btn-view-all { 
        font-size: 13px; 
        font-weight: 700; 
        color: var(--primary-gold); 
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 6px;
        background: rgba(184, 134, 11, 0.05);
        transition: all 0.2s;
    }
    .btn-view-all:hover { background: var(--primary-gold); color: #fff; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { text-align: left; padding: 15px; color: var(--text-muted); font-size: 12px; font-weight: 700; text-transform: uppercase; border-bottom: 1.5px solid #edf2f7; }
    .data-table td { padding: 15px; border-bottom: 1px solid #edf2f7; font-size: 14px; }

    .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .badge-pending { background: #fffaf0; color: #b7791f; }
    .badge-closed { background: #f0fff4; color: #38a169; }
    .badge-contacted { background: #ebf8ff; color: #2b6cb0; }

    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .activity-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="main-content">
    <div class="dashboard-welcome">
        <h1>Live Dashboard</h1>
        <p>Real-time analytics and activity for Dholera Smart City management.</p>
    </div>

    <!-- Quick Stats -->
    <div class="stats-grid">
        <div class="stat-card" onclick="location.href='projects/index.php'">
            <div class="stat-icon bg-blue"><i class="fas fa-building"></i></div>
            <div class="stat-info">
                <div class="label">Projects</div>
                <div class="value"><?php echo number_format($stats['projects']['total']); ?></div>
                <div class="sub-val"><?php echo $stats['projects']['active']; ?> Active Status</div>
            </div>
        </div>
        <div class="stat-card" onclick="location.href='enquiries/manage-enquiries.php'">
            <div class="stat-icon bg-gold"><i class="fas fa-envelope-open-text"></i></div>
            <div class="stat-info">
                <div class="label">Contact Requests</div>
                <div class="value"><?php echo number_format($stats['enquiries']['total']); ?></div>
                <div class="sub-val"><?php echo $stats['enquiries']['pending']; ?> Pending Inquiry</div>
            </div>
        </div>
        <div class="stat-card" onclick="location.href='site-requests/index.php'">
            <div class="stat-icon bg-purple"><i class="fas fa-map-marked-alt"></i></div>
            <div class="stat-info">
                <div class="label">Site Visits</div>
                <div class="value"><?php echo number_format($stats['visits']['total']); ?></div>
                <div class="sub-val"><?php echo $stats['visits']['pending']; ?> Awaiting Visits</div>
            </div>
        </div>
        <div class="stat-card" onclick="location.href='agents/index.php'">
            <div class="stat-icon bg-green"><i class="fas fa-user-tie"></i></div>
            <div class="stat-info">
                <div class="label">Company Agents</div>
                <div class="value"><?php echo number_format($stats['agents']['total']); ?></div>
                <div class="sub-val"><?php echo $stats['agents']['active']; ?> Active Agents</div>
            </div>
        </div>
    </div>

    <!-- Live Activity -->
    <div class="activity-grid">
        <!-- Recent Enquiries -->
        <div class="card-box">
            <div class="card-header">
                <h2>Recent Contact Requests</h2>
                <a href="enquiries/manage-enquiries.php" class="btn-view-all">Manage All</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Received On</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($recent_enquiries) > 0): ?>
                            <?php foreach ($recent_enquiries as $enq): ?>
                                <tr>
                                    <td>
                                        <div style="font-weight:600;"><?php echo date('d M', strtotime($enq['created_at'])); ?></div>
                                        <small style="color:#a0aec0;"><?php echo date('h:i A', strtotime($enq['created_at'])); ?></small>
                                    </td>
                                    <td>
                                        <div style="font-weight:700; color:#2d3748;"><?php echo htmlspecialchars($enq['name']); ?></div>
                                        <small style="color:#718096;"><?php echo htmlspecialchars($enq['phone']); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo $enq['status']; ?>">
                                            <?php echo $enq['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="enquiries/manage-enquiries.php" style="color:var(--primary-gold);"><i class="fas fa-arrow-right"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="text-align:center; padding:30px; color:#a0aec0;">No recent requests.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Site Visits -->
        <div class="card-box">
            <div class="card-header">
                <h2>Recent Site Visits</h2>
                <a href="site-requests/index.php" class="btn-view-all">View All</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Project</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($recent_visits) > 0): ?>
                            <?php foreach ($recent_visits as $visit): ?>
                                <tr>
                                    <td>
                                        <div style="font-weight:700; color:#2d3748;"><?php echo htmlspecialchars($visit['name']); ?></div>
                                        <small style="color:#a0aec0;"><?php echo date('d M, Y', strtotime($visit['created_at'])); ?></small>
                                    </td>
                                    <td>
                                        <div style="font-size:12px; color:#718096; font-weight:600;"><?php echo htmlspecialchars($visit['project_title'] ?? 'N/A'); ?></div>
                                    </td>
                                    <td>
                                        <a href="site-requests/index.php" style="color:var(--primary-gold);"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" style="text-align:center; padding:30px; color:#a0aec0;">No recent visits.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
