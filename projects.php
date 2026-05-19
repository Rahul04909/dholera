<?php
/**
 * Professional Real Estate Projects Listing Page
 * Dholera Smart City Portal
 * Replicates premium features of Housing.com and Square Yards
 */
require_once 'database/db_config.php';

// Active filters from GET
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$selected_types = isset($_GET['types']) ? (array)$_GET['types'] : [];
$rera_only = isset($_GET['rera']) ? (int)$_GET['rera'] : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Fetch unique project types dynamically for the filter sidebar
try {
    $types_stmt = $conn->query("SELECT DISTINCT project_type FROM projects WHERE status = 'active' AND project_type IS NOT NULL AND project_type != ''");
    $all_types = $types_stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $all_types = ['Residential Plots', 'Commercial Land', 'Industrial Land'];
}

// Pagination setup
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Build SQL filters
$where_clauses = ["status = 'active'"];
$params = [];

if ($search !== '') {
    $where_clauses[] = "(title LIKE :search OR location LIKE :search OR about_project LIKE :search)";
    $params['search'] = '%' . $search . '%';
}

if (!empty($selected_types)) {
    $type_placeholders = [];
    foreach ($selected_types as $idx => $t) {
        $key = "type_" . $idx;
        $type_placeholders[] = ":" . $key;
        $params[$key] = $t;
    }
    $where_clauses[] = "project_type IN (" . implode(", ", $type_placeholders) . ")";
}

if ($rera_only) {
    $where_clauses[] = "(legitimate LIKE :rera OR label LIKE :rera OR title LIKE :rera)";
    $params['rera'] = '%RERA%';
}

$where_sql = implode(" AND ", $where_clauses);

// Count total matches
try {
    $count_stmt = $conn->prepare("SELECT COUNT(*) FROM projects WHERE $where_sql");
    $count_stmt->execute($params);
    $total_projects = $count_stmt->fetchColumn();
} catch (PDOException $e) {
    $total_projects = 0;
}

$total_pages = ceil($total_projects / $limit);
if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
$offset = ($page - 1) * $limit;

// Sorting logic
$order_by = "created_at DESC";
if ($sort === 'price_asc') {
    $order_by = "CAST(REPLACE(REPLACE(price_range, 'Lac', ''), 'Cr', '*100') AS DECIMAL(10,2)) ASC, price_range ASC";
} elseif ($sort === 'price_desc') {
    $order_by = "CAST(REPLACE(REPLACE(price_range, 'Lac', ''), 'Cr', '*100') AS DECIMAL(10,2)) DESC, price_range DESC";
}

// Fetch results
try {
    $query_sql = "SELECT * FROM projects WHERE $where_sql ORDER BY $order_by LIMIT :limit OFFSET :offset";
    
    // We prepare manually to bind integers correctly for LIMIT and OFFSET in older MySQL versions
    $stmt = $conn->prepare($query_sql);
    
    foreach ($params as $key => $val) {
        $stmt->bindValue(':' . $key, $val);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    $projects = [];
}

// SEO Overrides
$seo_title = "Residential & Commercial Projects in Dholera SIR - Verified Listings";
$seo_desc = "Browse verified developer projects, planned plots, and commercial schemes in Dholera Smart City. Filter by budget, RERA status, and layout format.";
$seo_keywords = "Projects in Dholera, Dholera SIR Plots, Dholera Real Estate Listings, Housing Dholera";

include 'includes/header.php';
?>

<style>
    /* Projects Listing Page Container */
    .projects-container {
        max-width: 1200px;
        margin: 40px auto 80px;
        padding: 0 20px;
        font-family: 'Outfit', sans-serif;
    }

    /* Page Heading section */
    .listing-heading {
        margin-bottom: 30px;
        text-align: left;
    }

    .listing-heading h1 {
        font-size: 32px;
        font-weight: 800;
        color: #1c335a;
        margin-bottom: 5px;
    }

    .listing-heading p {
        font-size: 15px;
        color: #718096;
        font-family: 'Inter', sans-serif;
    }

    /* Main Flex/Grid wrapper */
    .projects-page-wrapper {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
        align-items: start;
    }

    /* Professional Filter Sidebar */
    .projects-sidebar {
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(28, 51, 90, 0.03);
        position: sticky;
        top: 20px;
        z-index: 10;
        text-align: left;
    }

    .sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 22px;
        padding-bottom: 12px;
        border-bottom: 1.5px solid #f1f5f9;
    }

    .sidebar-header h3 {
        font-size: 18px;
        font-weight: 800;
        color: #1c335a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .reset-filters-btn {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--primary-color);
        text-decoration: none;
        transition: 0.2s;
    }

    .reset-filters-btn:hover {
        color: #966d09;
    }

    .filter-group {
        margin-bottom: 22px;
    }

    .filter-label {
        font-size: 14px;
        font-weight: 700;
        color: #1c335a;
        margin-bottom: 10px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Search input box styling */
    .sidebar-search-box {
        position: relative;
    }

    .sidebar-search-box input {
        width: 100%;
        padding: 10px 35px 10px 12px;
        border: 1.5px solid #edf2f7;
        border-radius: 8px;
        font-size: 13.5px;
        transition: 0.3s;
        font-family: 'Inter', sans-serif;
    }

    .sidebar-search-box input:focus {
        border-color: var(--primary-color);
        outline: none;
    }

    .sidebar-search-box i {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        font-size: 14px;
    }

    /* Checkbox Group */
    .checkbox-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #4a5568;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
    }

    .checkbox-item input {
        width: 16px;
        height: 16px;
        accent-color: #1c335a;
        cursor: pointer;
    }

    .apply-filters-btn {
        width: 100%;
        background: #1c335a;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s ease;
        margin-top: 10px;
    }

    .apply-filters-btn:hover {
        background: var(--primary-color);
        box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2);
    }

    /* Right Main Feed Section */
    .projects-feed-wrapper {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    /* Feed Header Row: Count & Formats */
    .feed-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 12px;
        padding: 12px 20px;
        box-shadow: 0 4px 15px rgba(28, 51, 90, 0.02);
    }

    .feed-count {
        font-size: 14.5px;
        font-weight: 700;
        color: #1c335a;
    }

    .feed-controls {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    /* Sorting Dropdown */
    .sort-dropdown select {
        padding: 8px 12px;
        border: 1.5px solid #edf2f7;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #4a5568;
        outline: none;
        cursor: pointer;
        background: #fff;
        transition: 0.3s;
    }

    .sort-dropdown select:focus {
        border-color: var(--primary-color);
    }

    /* Layout Toggle Format Switchers */
    .layout-switchers {
        display: flex;
        border: 1.5px solid #edf2f7;
        border-radius: 8px;
        overflow: hidden;
        background: #f8fafc;
    }

    .layout-btn {
        border: none;
        background: none;
        padding: 8px 12px;
        cursor: pointer;
        color: #a0aec0;
        font-size: 14px;
        transition: 0.3s;
    }

    .layout-btn.active {
        background: #1c335a;
        color: #fff;
    }

    /* Dynamic Feed Layout states */
    .projects-feed.layout-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    /* Standard Card Reuse with Outfitted UI details */
    .project-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(28, 51, 90, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #edf2f7;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .project-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(28, 51, 90, 0.12);
        border-color: rgba(184, 134, 11, 0.3);
    }

    .project-img-wrapper {
        position: relative;
        height: 200px;
        overflow: hidden;
        margin: 0;
    }

    .project-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .project-card:hover .project-img {
        transform: scale(1.08);
    }

    .project-badge-logo {
        position: absolute;
        bottom: -15px;
        right: 15px;
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        z-index: 2;
        border: 2px solid #fff;
    }

    .project-badge-logo img {
        width: 100%;
        height: auto;
    }

    .project-badge-status {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--primary-color);
        color: #fff;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 10px rgba(184, 134, 11, 0.3);
    }

    .project-content {
        padding: 20px 18px;
        text-align: left;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .project-verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #2e7d32;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .project-title {
        font-size: 18px;
        font-weight: 800;
        color: #1c335a;
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .project-location {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #718096;
        font-size: 13px;
        margin-bottom: 15px;
    }

    .project-location i {
        color: var(--primary-color);
    }

    .project-price-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        border-top: 1px solid #f1f5f9;
        padding-top: 15px;
        margin-bottom: 12px;
    }

    .price-value {
        font-size: 18px;
        font-weight: 800;
        color: var(--primary-color);
    }

    .price-sub {
        font-size: 11px;
        color: #a0aec0;
        text-transform: uppercase;
        font-weight: 600;
    }

    .project-specs-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 18px;
    }

    .spec-item {
        background: #f8fafc;
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 12px;
        color: #4a5568;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .spec-item i {
        color: #1c335a;
    }

    .project-cta-row {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 10px;
        margin-top: auto;
    }

    .cta-btn {
        padding: 10px 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
        text-align: center;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .cta-secondary {
        background: transparent;
        color: #1c335a;
        border: 1.5px solid #edf2f7;
    }

    .cta-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .cta-primary {
        background: #1c335a;
        color: #fff;
        border: 1.5px solid #1c335a;
    }

    .cta-primary:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(184, 134, 11, 0.2);
    }

    /* -------------------------------------------------------------
       PREMIUM LIST FORMAT OVERRIDES (Housing.com/Square Yards style)
       ------------------------------------------------------------- */
    .projects-feed.layout-list {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .projects-feed.layout-list .project-card {
        flex-direction: row;
        width: 100%;
        height: 240px;
        overflow: hidden;
    }

    .projects-feed.layout-list .project-img-wrapper {
        width: 35%;
        height: 100%;
    }

    .projects-feed.layout-list .project-content {
        width: 65%;
        padding: 22px 25px;
    }

    .projects-feed.layout-list .project-specs-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 12px;
    }

    .projects-feed.layout-list .project-price-row {
        border-top: none;
        padding-top: 0;
        margin-bottom: 12px;
    }

    .projects-feed.layout-list .project-cta-row {
        margin-top: 5px;
        max-width: 350px;
    }

    /* Centered Pagination Elements */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 40px;
        font-family: 'Inter', sans-serif;
    }

    .pagination-link {
        min-width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1.5px solid #edf2f7;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14.5px;
        color: #4a5568;
        transition: 0.3s;
    }

    .pagination-link:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #1c335a;
    }

    .pagination-link.active {
        background: #1c335a;
        border-color: #1c335a;
        color: #fff;
    }

    .pagination-link.disabled {
        pointer-events: none;
        color: #cbd5e1;
        background: #f8fafc;
    }

    /* Empty state */
    .empty-state {
        grid-column: 1/-1;
        text-align: center;
        background: #fff;
        border: 1px solid #edf2f7;
        border-radius: 16px;
        padding: 80px 20px;
        color: #718096;
        box-shadow: 0 10px 30px rgba(28, 51, 90, 0.02);
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    /* Mobile Responsive adaptabilities */
    @media (max-width: 1024px) {
        .projects-page-wrapper {
            grid-template-columns: 1fr;
        }

        .projects-sidebar {
            position: relative;
            top: 0;
            width: 100%;
        }

        .projects-feed.layout-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .listing-heading h1 {
            font-size: 28px;
            text-align: center;
        }

        .listing-heading p {
            text-align: center;
        }

        .feed-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .projects-feed.layout-grid {
            grid-template-columns: 1fr;
        }

        /* Enforce vertical stacking on list card format for mobile screen sizes */
        .projects-feed.layout-list .project-card {
            flex-direction: column;
            height: auto;
        }

        .projects-feed.layout-list .project-img-wrapper {
            width: 100%;
            height: 200px;
        }

        .projects-feed.layout-list .project-content {
            width: 100%;
            padding: 20px 18px;
        }

        .projects-feed.layout-list .project-specs-grid {
            grid-template-columns: 1fr 1fr;
        }

        .projects-feed.layout-list .project-cta-row {
            max-width: 100%;
        }
    }
</style>

<div class="projects-container">
    <!-- Header Summary -->
    <div class="listing-heading">
        <h1>Exclusive Properties & Projects</h1>
        <p>Browse, filter, and discover verified residential, commercial, and industrial plots inside the Planned Dholera SIR Corridor.</p>
    </div>

    <!-- Main Listing Workspace -->
    <div class="projects-page-wrapper">
        
        <!-- Professional Search & Filter Sidebar -->
        <aside class="projects-sidebar">
            <form action="" method="GET" id="filter-form">
                <!-- Keep existing page and layout state intact during submits -->
                <input type="hidden" name="page" value="1">
                <input type="hidden" name="sort" id="sort-hidden-input" value="<?php echo htmlspecialchars($sort); ?>">

                <div class="sidebar-header">
                    <h3><i class="fa-solid fa-sliders"></i> Filters</h3>
                    <a href="projects.php" class="reset-filters-btn">Reset All</a>
                </div>

                <!-- 1. Search Bar Filter -->
                <div class="filter-group">
                    <span class="filter-label">Search Keywords</span>
                    <div class="sidebar-search-box">
                        <input type="text" name="search" placeholder="Type project name..." value="<?php echo htmlspecialchars($search); ?>">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>

                <!-- 2. Property Type Select -->
                <div class="filter-group">
                    <span class="filter-label">Property Type</span>
                    <div class="checkbox-list">
                        <?php foreach ($all_types as $type): ?>
                            <label class="checkbox-item">
                                <input type="checkbox" name="types[]" value="<?php echo htmlspecialchars($type); ?>" 
                                    <?php if (in_array($type, $selected_types)) echo 'checked'; ?>>
                                <?php echo htmlspecialchars($type); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 3. RERA Approval Filter -->
                <div class="filter-group">
                    <span class="filter-label">RERA verification</span>
                    <div class="checkbox-list">
                        <label class="checkbox-item">
                            <input type="checkbox" name="rera" value="1" <?php if ($rera_only) echo 'checked'; ?>>
                            RERA Approved Only
                        </label>
                    </div>
                </div>

                <button type="submit" class="apply-filters-btn">Apply Filters</button>
            </form>
        </aside>

        <!-- Right Main Projects Feed Workspace -->
        <div class="projects-feed-wrapper">
            
            <!-- Feed Control Bar: Switchers & Sorts -->
            <div class="feed-header">
                <div class="feed-count">
                    Showing <?php echo count($projects); ?> of <?php echo $total_projects; ?> projects matching search
                </div>

                <div class="feed-controls">
                    <!-- Dropdown Sort -->
                    <div class="sort-dropdown">
                        <select id="sort-select" onchange="applySorting(this.value)">
                            <option value="newest" <?php if ($sort === 'newest') echo 'selected'; ?>>Newest First</option>
                            <option value="price_asc" <?php if ($sort === 'price_asc') echo 'selected'; ?>>Price: Low to High</option>
                            <option value="price_desc" <?php if ($sort === 'price_desc') echo 'selected'; ?>>Price: High to Low</option>
                        </select>
                    </div>

                    <!-- Dynamic Layout switch buttons -->
                    <div class="layout-switchers">
                        <button type="button" class="layout-btn" id="layout-grid-btn" onclick="toggleFeedLayout('grid')">
                            <i class="fa-solid fa-grid-2"></i> Grid
                        </button>
                        <button type="button" class="layout-btn" id="layout-list-btn" onclick="toggleFeedLayout('list')">
                            <i class="fa-solid fa-list"></i> List
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Items Feed -->
            <div class="projects-feed layout-grid" id="projects-feed">
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                        <div class="project-card">
                            <div class="project-img-wrapper">
                                <?php if ($project['featured_image']): ?>
                                    <img src="<?php echo BASE_URL . $project['featured_image']; ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="project-img" loading="lazy">
                                <?php else: ?>
                                    <img src="https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Placeholder" class="project-img" loading="lazy">
                                <?php endif; ?>
                                
                                <div class="project-badge-logo">
                                    <img src="<?php echo BASE_URL; ?>assets/logo.webp" alt="Dholera Logo">
                                </div>
                                
                                <span class="project-badge-status"><?php echo htmlspecialchars($project['label'] ?: 'Featured'); ?></span>
                            </div>
                            
                            <div class="project-content">
                                <div class="project-verified-badge">
                                    <i class="fa-solid fa-circle-check"></i> RERA Approved
                                </div>
                                
                                <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                                
                                <div class="project-location">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($project['location']); ?>
                                </div>

                                <div class="project-specs-grid">
                                    <div class="spec-item">
                                        <i class="fa-solid fa-chart-area"></i> <?php echo htmlspecialchars($project['project_type'] ?: 'Plots & Land'); ?>
                                    </div>
                                    <div class="spec-item">
                                        <i class="fa-solid fa-shield-halved"></i> 100% Safe
                                    </div>
                                </div>
                                
                                <div class="project-price-row">
                                    <span class="price-value">₹ <?php echo htmlspecialchars($project['price_range'] ?: 'On Request'); ?></span>
                                    <span class="price-sub">Est. Price</span>
                                </div>
                                
                                <div class="project-cta-row">
                                    <a href="<?php echo BASE_URL; ?>project/<?php echo $project['slug'] ? $project['slug'] : $project['id']; ?>" class="cta-btn cta-secondary">
                                        Details
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>contact.php" class="cta-btn cta-primary">
                                        Inquire <i class="fas fa-arrow-right" style="font-size: 10px; margin-left: 6px;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fa-solid fa-building-circle-exclamation"></i>
                        <h3>No Projects Match Your Search</h3>
                        <p>Try resetting filters, searching different keywords, or adjusting checkboxes in the sidebar.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Proper Dynamic Pagination Bar -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination-wrapper">
                    <!-- Prev Button Link -->
                    <a href="<?php echo updateQueryParam('page', $page - 1); ?>" class="pagination-link <?php if ($page <= 1) echo 'disabled'; ?>">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>

                    <!-- Render numbered buttons -->
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="<?php echo updateQueryParam('page', $i); ?>" class="pagination-link <?php if ($i == $page) echo 'active'; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Next Button Link -->
                    <a href="<?php echo updateQueryParam('page', $page + 1); ?>" class="pagination-link <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    // Handles changing of layouts dynamically
    function toggleFeedLayout(format) {
        const feedElement = document.getElementById('projects-feed');
        const gridBtn = document.getElementById('layout-grid-btn');
        const listBtn = document.getElementById('layout-list-btn');

        if (format === 'list') {
            feedElement.classList.remove('layout-grid');
            feedElement.classList.add('layout-list');
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
            localStorage.setItem('projects-layout-preference', 'list');
        } else {
            feedElement.classList.remove('layout-list');
            feedElement.classList.add('layout-grid');
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            localStorage.setItem('projects-layout-preference', 'grid');
        }
    }

    // Handles active sort submissions
    function applySorting(sortValue) {
        document.getElementById('sort-hidden-input').value = sortValue;
        document.getElementById('filter-form').submit();
    }

    // Read cached layout format preference on page load
    document.addEventListener('DOMContentLoaded', () => {
        const preference = localStorage.getItem('projects-layout-preference') || 'grid';
        toggleFeedLayout(preference);
    });
</script>

<?php 
// Helper function to dynamically modify single query parameters in current URL
function updateQueryParam($paramName, $paramValue) {
    $queryParams = $_GET;
    $queryParams[$paramName] = $paramValue;
    return 'projects.php?' . http_build_query($queryParams);
}
?>

<?php include 'includes/footer.php'; ?>
