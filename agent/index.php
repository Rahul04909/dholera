<?php
/**
 * Agent Dashboard Overview
 * Dholera Smart City Agent Panel
 */
include 'includes/header.php';

$agent_id = $_SESSION['agent_id'];

// Initial stats
$total_assigned_projects = 0;
$total_assigned_leads = 0;
$total_site_visits = 0;

try {
    // 1. Fetch Total Assigned Projects
    $proj_stmt = $conn->prepare("
        SELECT COUNT(*) 
        FROM agent_projects ap 
        INNER JOIN projects p ON ap.project_id = p.id 
        WHERE ap.agent_id = :agent_id AND p.status = 'active'
    ");
    $proj_stmt->execute(['agent_id' => $agent_id]);
    $total_assigned_projects = $proj_stmt->fetchColumn();

    // 2. Fetch Total Assigned Leads
    $leads_stmt = $conn->prepare("SELECT COUNT(*) FROM agent_leads WHERE agent_id = :agent_id");
    $leads_stmt->execute(['agent_id' => $agent_id]);
    $total_assigned_leads = $leads_stmt->fetchColumn();

    // 3. Fetch Total Site Visits
    $visits_stmt = $conn->prepare("SELECT COUNT(*) FROM agent_site_visits WHERE agent_id = :agent_id");
    $visits_stmt->execute(['agent_id' => $agent_id]);
    $total_site_visits = $visits_stmt->fetchColumn();

    // 4. Fetch Recent Leads
    $recent_leads_stmt = $conn->prepare("
        SELECT al.*, 
               CASE WHEN al.source_type = 'enquiry' THEN e.name ELSE c.name END as customer_name,
               CASE WHEN al.source_type = 'enquiry' THEN e.phone ELSE c.phone END as customer_phone
        FROM agent_leads al
        LEFT JOIN enquiries e ON al.source_id = e.id AND al.source_type = 'enquiry'
        LEFT JOIN callbacks c ON al.source_id = c.id AND al.source_type = 'callback'
        WHERE al.agent_id = :agent_id
        ORDER BY al.created_at DESC
        LIMIT 5
    ");
    $recent_leads_stmt->execute(['agent_id' => $agent_id]);
    $recent_leads = $recent_leads_stmt->fetchAll();

    // 5. Fetch Recent Site Visits
    $recent_visits_stmt = $conn->prepare("
        SELECT asv.*, sv.name, sv.project_name
        FROM agent_site_visits asv
        JOIN site_visits sv ON asv.site_visit_id = sv.id
        WHERE asv.agent_id = :agent_id
        ORDER BY asv.created_at DESC
        LIMIT 5
    ");
    $recent_visits_stmt->execute(['agent_id' => $agent_id]);
    $recent_visits = $recent_visits_stmt->fetchAll();

} catch (PDOException $e) {
    error_log("Dashboard Data Error: " . $e->getMessage());
}
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 35px;">
        <h1 style="font-size: 32px; font-weight: 800; background: linear-gradient(45deg, #2d3748, var(--primary-gold)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Hello, <?php echo explode(' ', $current_agent['full_name'])[0]; ?>!
        </h1>
        <p style="color: #718096; font-size: 16px; margin-top: 8px;">Welcome to your personalized growth command center.</p>
    </div>

    <!-- Live Metrics Grid -->
    <style>
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .metric-card {
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid #f0f4f8;
            text-decoration: none;
        }

        .metric-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(184, 134, 11, 0.1);
            border-color: rgba(184, 134, 11, 0.2);
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gold);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .metric-card:hover::before {
            opacity: 1;
        }

        .metric-icon {
            width: 65px;
            height: 65px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            background: #f8fafc;
            color: #2d3748;
            transition: all 0.3s;
        }

        .metric-card:hover .metric-icon {
            background: var(--primary-gold);
            color: #fff;
        }

        .metric-info .label {
            font-size: 13px;
            font-weight: 700;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 5px;
        }

        .metric-info .value {
            font-size: 32px;
            font-weight: 800;
            color: #1a202c;
            line-height: 1;
        }

        .activity-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .activity-panel {
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: 1px solid #f0f4f8;
        }

        .activity-panel h2 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #2d3748;
        }

        .activity-panel h2 i {
            color: var(--primary-gold);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            background: #f8fafc;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .activity-item:hover {
            background: #f1f5f9;
            transform: translateX(5px);
        }

        .activity-details .name {
            font-weight: 700;
            color: #2d3748;
            font-size: 15px;
        }

        .activity-details .meta {
            font-size: 12px;
            color: #718096;
            margin-top: 3px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        .dot-gold { background: var(--primary-gold); }
        .dot-blue { background: #3182ce; }

        .btn-view-all {
            display: inline-block;
            margin-top: 25px;
            color: var(--primary-gold);
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-view-all:hover {
            color: #966d09;
            padding-left: 5px;
        }

        @media (max-width: 992px) {
            .activity-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="metrics-grid">
        <a href="my-projects.php" class="metric-card">
            <div class="metric-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="metric-info">
                <div class="label">Assigned Projects</div>
                <div class="value"><?php echo number_format($total_assigned_projects); ?></div>
            </div>
        </a>
        <a href="leads.php" class="metric-card">
            <div class="metric-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="metric-info">
                <div class="label">My Leads</div>
                <div class="value"><?php echo number_format($total_assigned_leads); ?></div>
            </div>
        </a>
        <a href="site-visits.php" class="metric-card">
            <div class="metric-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="metric-info">
                <div class="label">Site Visits</div>
                <div class="value"><?php echo number_format($total_site_visits); ?></div>
            </div>
        </a>
    </div>

    <div class="activity-grid">
        <!-- Recent Leads Panel -->
        <div class="activity-panel">
            <h2><i class="fas fa-user-plus"></i> Recent Leads</h2>
            <div class="activity-list">
                <?php if (!empty($recent_leads)): ?>
                    <?php foreach ($recent_leads as $lead): ?>
                        <div class="activity-item">
                            <div class="activity-details">
                                <div class="name"><?php echo htmlspecialchars($lead['customer_name']); ?></div>
                                <div class="meta">
                                    <span class="status-dot dot-blue"></span>
                                    <?php echo ucfirst($lead['source_type']); ?> Lead • <?php echo date('d M', strtotime($lead['created_at'])); ?>
                                </div>
                            </div>
                            <div style="font-size: 13px; font-weight: 600; color: #4a5568;">
                                <?php echo htmlspecialchars($lead['customer_phone']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #a0aec0; text-align: center; padding: 20px;">No recent leads assigned.</p>
                <?php endif; ?>
            </div>
            <a href="leads.php" class="btn-view-all">View All Leads <i class="fas fa-arrow-right"></i></a>
        </div>

        <!-- Recent Site Visits Panel -->
        <div class="activity-panel">
            <h2><i class="fas fa-map-marked-alt"></i> Recent Site Visits</h2>
            <div class="activity-list">
                <?php if (!empty($recent_visits)): ?>
                    <?php foreach ($recent_visits as $visit): ?>
                        <div class="activity-item">
                            <div class="activity-details">
                                <div class="name"><?php echo htmlspecialchars($visit['name']); ?></div>
                                <div class="meta">
                                    <span class="status-dot dot-gold"></span>
                                    <?php echo htmlspecialchars($visit['project_name']); ?> • <?php echo date('d M', strtotime($visit['created_at'])); ?>
                                </div>
                            </div>
                            <div style="font-size: 13px; font-weight: 600; color: #4a5568;">
                                <span style="background: rgba(184, 134, 11, 0.1); color: var(--primary-gold); padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                                    <?php echo strtoupper($visit['status']); ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #a0aec0; text-align: center; padding: 20px;">No site visits scheduled.</p>
                <?php endif; ?>
            </div>
            <a href="site-visits.php" class="btn-view-all">Manage All Visits <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
