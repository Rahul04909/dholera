<?php include 'includes/header.php'; ?>

<div class="main-content">
    <div class="dashboard-welcome" style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700;">Dashboard Overview</h1>
        <p style="color: #666;">Welcome back, Administrator. Here's what's happening today.</p>
    </div>

    <!-- Stats Cards -->
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
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

        .icon-blue { background-color: rgba(66, 153, 225, 0.1); color: #4299e1; }
        .icon-gold { background-color: rgba(184, 134, 11, 0.1); color: var(--primary-gold); }
        .icon-green { background-color: rgba(72, 187, 120, 0.1); color: #48bb78; }
        .icon-purple { background-color: rgba(159, 122, 234, 0.1); color: #9f7aea; }

        .stat-info h3 {
            font-size: 14px;
            font-weight: 500;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info .value {
            font-size: 24px;
            font-weight: 800;
            color: #2d3748;
        }

        /* Recent Table */
        .table-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            padding: 30px;
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .table-header h2 {
            font-size: 20px;
            font-weight: 700;
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
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-new { background-color: #ebf8ff; color: #3182ce; }
        .badge-pending { background-color: #fffaf0; color: #dd6b20; }
        .badge-completed { background-color: #f0fff4; color: #38a169; }

        .action-btn {
            padding: 6px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            background: transparent;
            color: #718096;
            cursor: pointer;
            transition: all 0.2s;
        }

        .action-btn:hover {
            border-color: var(--primary-gold);
            color: var(--primary-gold);
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-info">
                <h3>Total Projects</h3>
                <div class="value">24</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-gold">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Total Leads</h3>
                <div class="value">1,284</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div class="stat-info">
                <h3>Revenue</h3>
                <div class="value">₹ 4.2 Cr</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-purple">
                <i class="fas fa-bell"></i>
            </div>
            <div class="stat-info">
                <h3>New Alerts</h3>
                <div class="value">12</div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h2>Recent Enquiries</h2>
            <button class="action-btn" style="border-radius: 4px; padding: 10px 20px;">View All Enquiries</button>
        </div>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Ref ID</th>
                    <th>Customer Name</th>
                    <th>Interest Area</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#82341</td>
                    <td style="font-weight: 600;">Rahul Sharma</td>
                    <td>Dholera Smart City Phase 1</td>
                    <td>Oct 20, 2023</td>
                    <td><span class="status-badge badge-new">New</span></td>
                    <td>
                        <button class="action-btn"><i class="fas fa-eye"></i></button>
                        <button class="action-btn"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#82339</td>
                    <td style="font-weight: 600;">Amit Patel</td>
                    <td>Residential Plots Zone 2</td>
                    <td>Oct 19, 2023</td>
                    <td><span class="status-badge badge-pending">Pending</span></td>
                    <td>
                        <button class="action-btn"><i class="fas fa-eye"></i></button>
                        <button class="action-btn"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#82335</td>
                    <td style="font-weight: 600;">Suresh Gupta</td>
                    <td>Commercial Complex</td>
                    <td>Oct 18, 2023</td>
                    <td><span class="status-badge badge-completed">Completed</span></td>
                    <td>
                        <button class="action-btn"><i class="fas fa-eye"></i></button>
                        <button class="action-btn"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>#82331</td>
                    <td style="font-weight: 600;">Priya Verma</td>
                    <td>Studio Apartments</td>
                    <td>Oct 18, 2023</td>
                    <td><span class="status-badge badge-new">New</span></td>
                    <td>
                        <button class="action-btn"><i class="fas fa-eye"></i></button>
                        <button class="action-btn"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
