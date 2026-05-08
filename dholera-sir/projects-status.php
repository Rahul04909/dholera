<?php
/**
 * Dholera SIR - Infrastructure Projects Status
 * Running & Completed Projects Overview
 */
$seo_title = "Running & Completed Projects - Dholera SIR | Infrastructure Status";
$seo_desc = "Track the development of Dholera SIR. Detailed status of completed and ongoing infrastructure projects including ABCD Building, Roads, Services, and Water Treatment Plants.";

require_once __DIR__ . '/../database/db_config.php';
require_once __DIR__ . '/../includes/header.php';

// Project Data
$projects = [
    [
        'title' => 'Design & Construction of ABCD Building',
        'desc' => 'Design, Procurement, Construction, Installation, Testing and Commissioning of ABCD Building in Dholera.',
        'contractor' => 'M/s Cube Construction & Engineering Ltd',
        'value' => '72.31',
        'status' => 'Completed'
    ],
    [
        'title' => 'Raw Water Transmission Main (RWTM – 10 MLD)',
        'desc' => '10 MLD Raw water pumping station and Raw Water Transmission Main from Pipli Pumping Station to Water Treatment Plant at TP1.',
        'contractor' => 'M/s D. R. Agarwal Infra Pvt Ltd',
        'value' => '29.67',
        'status' => 'Completed'
    ],
    [
        'title' => 'Adhiya River Bunding Phase-1',
        'desc' => 'Flood Protection of Adhiya River between SH-06 and Khun village.',
        'contractor' => 'M/s Jugalkishore Ramkishan Agrawal Pvt Ltd',
        'value' => '11.87',
        'status' => 'Completed'
    ],
    [
        'title' => 'Interior Works of BEC Building',
        'desc' => 'Interior Works of Business and Exhibition Centre (BEC) building in ABCD Complex in DSIR.',
        'contractor' => 'New Concept',
        'value' => '19.44',
        'status' => 'Completed'
    ],
    [
        'title' => 'Experience Zone at ABCD Building',
        'desc' => 'State-of-the-art Experience Zone with Physical Model, Projection Mapping and digital walls.',
        'contractor' => 'Tagbin',
        'value' => '4.84',
        'status' => 'Completed'
    ],
    [
        'title' => 'Design & Construction of Roads & Services',
        'desc' => 'Road network, Potable/Recycled water, Sewage, Effluent, Storm water, ICT ducts, Power, Bridges, etc.',
        'contractor' => 'M/s Larsen & Toubro Ltd',
        'value' => '1801.07',
        'status' => 'Ongoing'
    ],
    [
        'title' => 'Canal Front Development Zone',
        'desc' => 'Construction of Canal Front Development including Land Filling, Civil, and MEP works.',
        'contractor' => 'M/s P.R.Patel & Company',
        'value' => '41.42',
        'status' => 'Ongoing'
    ],
    [
        'title' => 'Service Area Buildings (with Porta Cabins)',
        'desc' => 'Design and Construction of 17 nos. of Service Area buildings and 5-year O&M.',
        'contractor' => 'M/s Bridge & Roof Co. India Ltd',
        'value' => '32.82',
        'status' => 'Ongoing'
    ],
    [
        'title' => 'Common Effluent Treatment Plant (CETP – 20 MLD)',
        'desc' => 'CETP, 14 Effluent Pumping stations, RO reject disposal pipeline, and MBR for Recycled water.',
        'contractor' => 'M/s Larsen & Toubro Ltd',
        'value' => '156.86',
        'status' => 'Ongoing'
    ],
    [
        'title' => 'Sewage Treatment Plant (STP – 10 MLD)',
        'desc' => '10 MLD STP, 6 Intermediate Sewage Pumping Stations, and 70 MLD Pumping Station.',
        'contractor' => 'M/s Larsen & Toubro Ltd',
        'value' => '53.13',
        'status' => 'Ongoing'
    ],
    [
        'title' => 'Balance Works of WTP (WTP – 50 MLD)',
        'desc' => '50 MLD Water Treatment Plant, Clear Water Reservoir, and Potable Water Transmission Main.',
        'contractor' => 'MS Khurana Engineering Ltd',
        'value' => '87.97',
        'status' => 'Ongoing'
    ],
    [
        'title' => 'Earth filling in Selected Plots of Activation Area',
        'desc' => 'Soil filling in Plot-A (70 Ha) and Plot-B (92 Ha) with average depth of 2.0m.',
        'contractor' => 'M/s Montecarlo Ltd',
        'value' => '86.01',
        'status' => 'Ongoing'
    ],
    [
        'title' => 'ICT MSI Project',
        'desc' => 'ICT Components in Cluster A1 of Activation Area - Design, Install, Integrate, and 5-year O&M.',
        'contractor' => 'M/s D. R. Agarwal Infra Pvt Ltd',
        'value' => '68.99',
        'status' => 'Ongoing'
    ],
    [
        'title' => 'Interior Works of SPV Building',
        'desc' => 'Interior Works of Special Purpose Vehicle(SPV) building at ABCD Complex in DSIR.',
        'contractor' => 'New Concept',
        'value' => '15.58',
        'status' => 'Ongoing'
    ]
];
?>

<style>
    .proj-hero {
        background: linear-gradient(rgba(28, 51, 90, 0.9), rgba(28, 51, 90, 0.9)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920');
        background-size: cover;
        background-position: center;
        width: 100%;
        min-height: 300px;
        padding: 60px 5%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
    }

    .proj-hero h1 {
        font-size: 38px;
        font-weight: 800;
        margin-bottom: 15px;
    }

    .proj-container {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 20px;
    }

    .status-section {
        margin-bottom: 80px;
    }

    .status-title {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 3px solid #eee;
    }

    .status-title h2 {
        font-size: 28px;
        color: var(--secondary-color);
        font-weight: 700;
    }

    .status-badge-count {
        background: var(--primary-color);
        color: #fff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 700;
    }

    /* Project Cards */
    .proj-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }

    .proj-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        border-top: 5px solid #ddd;
    }

    .proj-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .proj-card.completed {
        border-top-color: #28a745;
    }

    .proj-card.ongoing {
        border-top-color: var(--primary-color);
    }

    .proj-status-tag {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 3px 8px;
        border-radius: 4px;
        margin-bottom: 15px;
        width: fit-content;
    }

    .tag-completed { background: #e8f5e9; color: #2e7d32; }
    .tag-ongoing { background: #fff3e0; color: #ef6c00; }

    .proj-card h3 {
        font-size: 19px;
        color: var(--secondary-color);
        margin-bottom: 15px;
        line-height: 1.4;
        font-weight: 700;
    }

    .proj-card p {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .proj-meta {
        border-top: 1px solid #f0f0f0;
        padding-top: 15px;
        margin-top: auto;
    }

    .meta-item {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .meta-label { color: #888; }
    .meta-value { color: #333; font-weight: 600; text-align: right; }

    .value-highlight {
        color: var(--primary-color);
        font-weight: 700;
    }

    @media (max-width: 768px) {
        .proj-grid { grid-template-columns: 1fr; }
        .proj-hero h1 { font-size: 28px; }
    }
</style>

<section class="proj-hero">
    <h1>Dholera SIR Infrastructure Status</h1>
    <p>Official report of completed and ongoing infrastructure development projects.</p>
</section>

<div class="proj-container">

    <!-- Ongoing Projects -->
    <section class="status-section">
        <div class="status-title">
            <h2>Ongoing Infrastructure Projects</h2>
            <?php 
                $ongoing_count = count(array_filter($projects, function($p) { return $p['status'] == 'Ongoing'; }));
            ?>
            <span class="status-badge-count"><?php echo $ongoing_count; ?> Projects</span>
        </div>
        <div class="proj-grid">
            <?php foreach($projects as $p): ?>
                <?php if($p['status'] == 'Ongoing'): ?>
                <div class="proj-card ongoing">
                    <span class="proj-status-tag tag-ongoing">Ongoing Work</span>
                    <h3><?php echo $p['title']; ?></h3>
                    <p><?php echo $p['desc']; ?></p>
                    <div class="proj-meta">
                        <div class="meta-item">
                            <span class="meta-label">Contractor</span>
                            <span class="meta-value"><?php echo $p['contractor']; ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Contract Value</span>
                            <span class="meta-value value-highlight">₹<?php echo $p['value']; ?> Cr</span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Completed Projects -->
    <section class="status-section">
        <div class="status-title">
            <h2>Completed Infrastructure Projects</h2>
            <?php 
                $completed_count = count(array_filter($projects, function($p) { return $p['status'] == 'Completed'; }));
            ?>
            <span class="status-badge-count"><?php echo $completed_count; ?> Projects</span>
        </div>
        <div class="proj-grid">
            <?php foreach($projects as $p): ?>
                <?php if($p['status'] == 'Completed'): ?>
                <div class="proj-card completed">
                    <span class="proj-status-tag tag-completed">Project Completed</span>
                    <h3><?php echo $p['title']; ?></h3>
                    <p><?php echo $p['desc']; ?></p>
                    <div class="proj-meta">
                        <div class="meta-item">
                            <span class="meta-label">Contractor</span>
                            <span class="meta-value"><?php echo $p['contractor']; ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Contract Value</span>
                            <span class="meta-value value-highlight">₹<?php echo $p['value']; ?> Cr</span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
