<?php
/**
 * Agent Dashboard Overview
 */
include 'includes/header.php';

// Fetch some stats for the agent
$total_projects = 0;
$my_leads = 0;

try {
    // Total Active Projects
    $proj_stmt = $conn->query("SELECT COUNT(*) FROM projects WHERE status = 'active'");
    $total_projects = $proj_stmt->fetchColumn();

    // Leads assigned to this agent (Placeholder for now until we have a leads table with agent_id)
    // $lead_stmt = $conn->prepare("SELECT COUNT(*) FROM leads WHERE agent_id = ?");
    // $lead_stmt->execute([$_SESSION['agent_id']]);
    // $my_leads = $lead_stmt->fetchColumn();
} catch (PDOException $e) {
    error_log("Dashboard Stats Error: " . $e->getMessage());
}
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <h1>Welcome back, <?php echo explode(' ', $current_agent['full_name'])[0]; ?>!</h1>
        <p style="color: #718096; margin-top: 5px;">Here's an overview of your real estate business today.</p>
    </div>

    <!-- Quick Stats Grid -->
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            border-bottom: 4px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-bottom-color: var(--primary-gold);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .icon-gold { background: rgba(184, 134, 11, 0.1); color: var(--primary-gold); }
        .icon-blue { background: rgba(66, 153, 225, 0.1); color: #3182ce; }
        .icon-green { background: rgba(72, 187, 120, 0.1); color: #38a169; }

        .stat-info .label {
            font-size: 13px;
            font-weight: 600;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info .value {
            font-size: 28px;
            font-weight: 800;
            color: #2d3748;
            line-height: 1.2;
        }

        .info-panel {
            background: #fff;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .info-panel h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-panel h2 i {
            color: var(--primary-gold);
        }
    </style>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-gold">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-info">
                <div class="label">Total Projects</div>
                <div class="value"><?php echo number_format($total_projects); ?></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="fas fa-user-friends"></i>
            </div>
            <div class="stat-info">
                <div class="label">My Leads</div>
                <div class="value"><?php echo number_format($my_leads); ?></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-info">
                <div class="label">Commission</div>
                <div class="value">₹ 0</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <div class="info-panel">
                <h2><i class="fas fa-info-circle"></i> Quick Actions</h2>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <a href="profile.php" class="btn-gold" style="text-align: center;">Update My Profile</a>
                    <a href="#" class="btn-gold" style="text-align: center; background: #2d3748;">Browse New Projects</a>
                    <a href="#" class="btn-gold" style="text-align: center; background: #718096;">Marketing Materials</a>
                </div>
            </div>
            
            <div class="info-panel">
                <h2><i class="fas fa-bullhorn"></i> Important Notices</h2>
                <div style="color: #4a5568; line-height: 1.8;">
                    <div style="padding-bottom: 15px; border-bottom: 1px solid #edf2f7; margin-bottom: 15px;">
                        <span style="font-weight: 700; color: var(--primary-gold);">[NEW]</span> Phase 3 Plot registration is now open. Agents get extra 1% bonus this month!
                    </div>
                    <div>
                        <span style="font-weight: 700; color: #4a5568;">[REMINDER]</span> Please update your profile with correct banking details for timely commission payout.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
