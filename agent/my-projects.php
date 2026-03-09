<?php
/**
 * My Assigned Projects
 * Agent Dashboard
 */
include 'includes/header.php';

$agent_id = $_SESSION['agent_id'];

// Fetch projects assigned to this agent
try {
    $stmt = $conn->prepare("
        SELECT p.* 
        FROM projects p 
        INNER JOIN agent_projects ap ON p.id = ap.project_id 
        WHERE ap.agent_id = :agent_id AND p.status = 'active'
        ORDER BY p.created_at DESC
    ");
    $stmt->execute(['agent_id' => $agent_id]);
    $assigned_projects = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("My Projects Error: " . $e->getMessage());
    $assigned_projects = [];
}
?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>My Projects</h1>
                <p style="color: #718096; margin-top: 5px;">View projects assigned to you for management and sales.</p>
            </div>
            <div style="font-weight: 700; color: var(--primary-gold); background: rgba(184, 134, 11, 0.1); padding: 10px 20px; border-radius: 50px;">
                Total: <?php echo count($assigned_projects); ?> Projects
            </div>
        </div>
    </div>

    <style>
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .project-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .project-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.1);
        }

        .project-img {
            height: 200px;
            width: 100%;
            object-fit: cover;
            background: #eee;
        }

        .project-details {
            padding: 20px;
            flex-grow: 1;
        }

        .project-type {
            font-size: 11px;
            font-weight: 800;
            color: var(--primary-gold);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .project-title {
            font-size: 18px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
            display: block;
            text-decoration: none;
        }

        .project-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #718096;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .project-meta i {
            color: var(--primary-gold);
            font-size: 14px;
        }

        .project-footer {
            padding: 15px 20px;
            background: #f8fafc;
            border-top: 1px solid #edf2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            background: #f0fff4;
            color: #38a169;
        }

        .btn-details {
            color: var(--primary-gold);
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        @media (max-width: 576px) {
            .projects-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="projects-grid">
        <?php if (!empty($assigned_projects)): ?>
            <?php foreach ($assigned_projects as $proj): ?>
                <div class="project-card">
                    <img src="<?php echo BASE_URL . ($proj['featured_image'] ?: 'assets/images/placeholder-project.jpg'); ?>" class="project-img" alt="<?php echo htmlspecialchars($proj['title']); ?>">
                    <div class="project-details">
                        <div class="project-type"><?php echo htmlspecialchars($proj['type'] ?? 'Real Estate'); ?> Project</div>
                        <a href="#" class="project-title"><?php echo htmlspecialchars($proj['title']); ?></a>
                        <div class="project-meta">
                            <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($proj['location'] ?? 'Dholera, Gujarat'); ?></span>
                        </div>
                        <p style="font-size: 14px; color: #4a5568; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo htmlspecialchars(strip_tags($proj['short_description'] ?? 'Explore the future of urban living in India\'s first smart city project.')); ?>
                        </p>
                    </div>
                    <div class="project-footer">
                        <span class="status-badge"><?php echo strtoupper($proj['status']); ?></span>
                        <a href="<?php echo BASE_URL; ?>project-details.php?id=<?php echo $proj['id']; ?>" target="_blank" class="btn-details">
                            View Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 100px 20px; background: #fff; border-radius: 12px; border: 2px dashed #cbd5e0;">
                <i class="fas fa-building" style="font-size: 60px; color: #cbd5e0; margin-bottom: 20px;"></i>
                <h2 style="color: #4a5568;">No Projects Assigned Yet</h2>
                <p style="color: #718096; margin-top: 10px;">Please contact the administrator to assign projects to your account.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
