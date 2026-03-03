<?php
/**
 * Manage Floor Plans
 * Dholera Smart City Frontend Management
 */
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../../database/db_config.php';

$success_msg = "";
$error_msg = "";

// 1. Handle Settings Update (Titles)
if (isset($_POST['update_settings'])) {
    $sketch_title = $_POST['sketch_title'];
    $main_title = $_POST['main_title'];
    
    try {
        $stmt = $conn->prepare("UPDATE floor_plan_settings SET sketch_title = ?, main_title = ? WHERE id = 1");
        $stmt->execute([$sketch_title, $main_title]);
        $success_msg = "Section titles updated!";
    } catch (PDOException $e) {
        $error_msg = "Error: " . $e->getMessage();
    }
}

// 2. Handle Add New Floor Plan
if (isset($_POST['add_plan'])) {
    $tab_title = $_POST['tab_title'];
    $plan_title = $_POST['plan_title'];
    $plan_desc = $_POST['plan_desc'];
    
    try {
        $conn->beginTransaction();
        
        $image_path = 'assets/floor-plans/default.jpg'; // Fallback
        
        // Handle Image Upload
        if (isset($_FILES['plan_image']) && $_FILES['plan_image']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $filename = $_FILES['plan_image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $new_name = 'floor_plan_' . time() . '.' . $ext;
                $upload_dir = '../../assets/floor-plans/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                if (move_uploaded_file($_FILES['plan_image']['tmp_name'], $upload_dir . $new_name)) {
                    $image_path = 'assets/floor-plans/' . $new_name;
                }
            }
        }

        // Insert Plan
        $stmt = $conn->prepare("INSERT INTO floor_plans (tab_title, plan_title, plan_desc, image_path, sort_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$tab_title, $plan_title, $plan_desc, $image_path, $_POST['sort_order'] ?? 0]);
        $plan_id = $conn->lastInsertId();

        // Insert Specs
        if (isset($_POST['spec_labels'])) {
            foreach ($_POST['spec_labels'] as $key => $label) {
                if (!empty($label)) {
                    $value = $_POST['spec_values'][$key];
                    $stmt = $conn->prepare("INSERT INTO floor_plan_specs (plan_id, label, value, sort_order) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$plan_id, $label, $value, $key]);
                }
            }
        }

        $conn->commit();
        $success_msg = "New Floor Plan added successfully!";
    } catch (PDOException $e) {
        $conn->rollBack();
        $error_msg = "Error: " . $e->getMessage();
    }
}

// 3. Handle Update Existing Plan
if (isset($_POST['update_plan'])) {
    $plan_id = $_POST['plan_id'];
    $tab_title = $_POST['tab_title'];
    $plan_title = $_POST['plan_title'];
    $plan_desc = $_POST['plan_desc'];
    
    try {
        $conn->beginTransaction();
        
        // Update Text Fields
        $stmt = $conn->prepare("UPDATE floor_plans SET tab_title = ?, plan_title = ?, plan_desc = ?, sort_order = ? WHERE id = ?");
        $stmt->execute([$tab_title, $plan_title, $plan_desc, $_POST['sort_order'], $plan_id]);

        // Handle Image Upload
        if (isset($_FILES['plan_image']) && $_FILES['plan_image']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $filename = $_FILES['plan_image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $new_name = 'floor_plan_' . time() . '.' . $ext;
                $upload_dir = '../../assets/floor-plans/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                if (move_uploaded_file($_FILES['plan_image']['tmp_name'], $upload_dir . $new_name)) {
                    $image_path = 'assets/floor-plans/' . $new_name;
                    $stmt = $conn->prepare("UPDATE floor_plans SET image_path = ? WHERE id = ?");
                    $stmt->execute([$image_path, $plan_id]);
                }
            }
        }

        // Delete Old Specs and Insert New
        $conn->prepare("DELETE FROM floor_plan_specs WHERE plan_id = ?")->execute([$plan_id]);
        if (isset($_POST['spec_labels'])) {
            foreach ($_POST['spec_labels'] as $key => $label) {
                if (!empty($label)) {
                    $value = $_POST['spec_values'][$key];
                    $stmt = $conn->prepare("INSERT INTO floor_plan_specs (plan_id, label, value, sort_order) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$plan_id, $label, $value, $key]);
                }
            }
        }

        $conn->commit();
        $success_msg = "Floor Plan updated successfully!";
    } catch (PDOException $e) {
        $conn->rollBack();
        $error_msg = "Error: " . $e->getMessage();
    }
}

// 4. Handle Delete Plan
if (isset($_GET['delete_id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM floor_plans WHERE id = ?");
        $stmt->execute([$_GET['delete_id']]);
        $success_msg = "Floor Plan deleted!";
    } catch (PDOException $e) {
        $error_msg = "Error: " . $e->getMessage();
    }
}

// Fetch Data
try {
    $settings = $conn->query("SELECT * FROM floor_plan_settings WHERE id = 1")->fetch();
    $plans = $conn->query("SELECT * FROM floor_plans ORDER BY sort_order ASC")->fetchAll();
    
    $all_plans_data = [];
    foreach ($plans as $p) {
        $p['specs'] = $conn->prepare("SELECT * FROM floor_plan_specs WHERE plan_id = ? ORDER BY sort_order ASC")->execute([$p['id']]) ? [] : []; // Fix logic below
        $stmt_specs = $conn->prepare("SELECT * FROM floor_plan_specs WHERE plan_id = ? ORDER BY sort_order ASC");
        $stmt_specs->execute([$p['id']]);
        $p['specs'] = $stmt_specs->fetchAll();
        $all_plans_data[] = $p;
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include '../includes/header.php';
?>

<div class="main-content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700;">Manage Floor Plans</h1>
            <p style="color: #666;">Configure apartment plans, specifications, and layout images.</p>
        </div>
        <button onclick="openModal('addPlanModal')" class="btn-add" style="background:var(--primary-gold); color:#fff; border:none; padding:12px 25px; border-radius:4px; font-weight:700; cursor:pointer;">
            <i class="fas fa-plus"></i> Add New Plan
        </button>
    </div>

    <?php if ($success_msg): ?>
        <div style="background: #f0fff4; color: #38a169; padding: 15px; border-radius: 4px; margin-bottom: 25px;"><?php echo $success_msg; ?></div>
    <?php endif; ?>
    <?php if ($error_msg): ?>
        <div style="background: #fff5f5; color: #e53e3e; padding: 15px; border-radius: 4px; margin-bottom: 25px;"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <style>
        .mgmt-card { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px; color: #2d3748; }
        .input-box { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 5px; }
        .plans-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; }
        .plan-item { background: #fff; border: 1px solid #edf2f7; border-radius: 8px; overflow: hidden; transition: all 0.3s; }
        .plan-item:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .plan-img-preview { width: 100%; height: 180px; background: #000; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .plan-img-preview img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .plan-details { padding: 20px; }
        .plan-actions { display: flex; gap: 10px; margin-top: 15px; }
        .btn-edit { flex: 1; background: #edf2f7; color: #4a5568; border: none; padding: 8px; border-radius: 4px; cursor: pointer; text-align: center; text-decoration: none; font-size: 14px; font-weight: 600; }
        .btn-delete { background: #fff5f5; color: #e53e3e; padding: 8px 12px; border-radius: 4px; border: none; cursor: pointer; }
        
        /* Modal Styles */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); overflow-y: auto; }
        .modal-content { background: #fff; margin: 5% auto; padding: 40px; border-radius: 8px; width: 80%; max-width: 900px; position: relative; }
        .close-modal { position: absolute; top: 20px; right: 20px; font-size: 24px; cursor: pointer; }
        .spec-row { display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; margin-bottom: 10px; }
    </style>

    <!-- Section Settings -->
    <div class="mgmt-card">
        <h2 style="font-size: 18px; margin-bottom: 20px; color: var(--primary-gold);">Section Titles</h2>
        <form method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Small Title (Sketch)</label>
                    <input type="text" name="sketch_title" class="input-box" value="<?php echo htmlspecialchars($settings['sketch_title']); ?>">
                </div>
                <div class="form-group">
                    <label>Main Title</label>
                    <input type="text" name="main_title" class="input-box" value="<?php echo htmlspecialchars($settings['main_title']); ?>">
                </div>
            </div>
            <button type="submit" name="update_settings" class="btn-add" style="background:var(--dark-bg); color:#fff; border:none; padding:10px 20px; border-radius:4px; cursor:pointer;">Save Header Settings</button>
        </form>
    </div>

    <!-- Floor Plans Grid -->
    <div class="plans-list">
        <?php foreach ($all_plans_data as $p): ?>
            <div class="plan-item">
                <div class="plan-img-preview">
                    <img src="<?php echo strpos($p['image_path'], 'http') === 0 ? $p['image_path'] : BASE_URL . $p['image_path']; ?>" alt="Plan">
                </div>
                <div class="plan-details">
                    <div style="font-size: 12px; color: var(--primary-gold); font-weight: 700; text-transform: uppercase;"><?php echo htmlspecialchars($p['tab_title']); ?></div>
                    <h3 style="font-size: 18px; margin: 5px 0 10px;"><?php echo htmlspecialchars($p['plan_title']); ?></h3>
                    <p style="font-size: 13px; color: #666; height: 40px; overflow: hidden;"><?php echo substr(htmlspecialchars($p['plan_desc']), 0, 100); ?>...</p>
                    
                    <div class="plan-actions">
                        <button onclick='editPlan(<?php echo json_encode($p); ?>)' class="btn-edit"><i class="fas fa-edit"></i> Edit Details</button>
                        <a href="?delete_id=<?php echo $p['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Add Plan Modal -->
    <div id="addPlanModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('addPlanModal')">&times;</span>
            <h2 style="margin-bottom: 25px;">Add New Floor Plan</h2>
            <form method="POST" enctype="multipart/form-data">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Tab Title (e.g. Studio)</label>
                        <input type="text" name="tab_title" class="input-box" required>
                    </div>
                    <div class="form-group">
                        <label>Plan Full Title (e.g. The Studio)</label>
                        <input type="text" name="plan_title" class="input-box" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="plan_desc" class="input-box" rows="3" required></textarea>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Floor Plan Image</label>
                        <input type="file" name="plan_image" class="input-box" required>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="input-box" value="0">
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <label>Specifications (Key-Value)</label>
                    <div id="add-spec-container">
                        <div class="spec-row">
                            <input type="text" name="spec_labels[]" class="input-box" placeholder="Label (e.g. Area)">
                            <input type="text" name="spec_values[]" class="input-box" placeholder="Value (e.g. 1500 Sq.Ft)">
                            <button type="button" class="btn-delete" onclick="$(this).parent().remove()"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button type="button" onclick="addSpecRow('add-spec-container')" style="background:none; border:1px dashed #cbd5e0; padding:10px; width:100%; border-radius:4px; color:#4a5568; cursor:pointer; font-weight:600;">+ Add Specification Row</button>
                </div>

                <div style="text-align: right; margin-top: 30px;">
                    <button type="submit" name="add_plan" class="btn-add" style="background:var(--primary-gold); color:#fff; border:none; padding:12px 40px; border-radius:4px; cursor:pointer; font-weight:700;">Create Floor Plan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Plan Modal -->
    <div id="editPlanModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('editPlanModal')">&times;</span>
            <h2 style="margin-bottom: 25px;">Edit Floor Plan</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="plan_id" id="edit_plan_id">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Tab Title</label>
                        <input type="text" name="tab_title" id="edit_tab_title" class="input-box" required>
                    </div>
                    <div class="form-group">
                        <label>Plan Full Title</label>
                        <input type="text" name="plan_title" id="edit_plan_title" class="input-box" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="plan_desc" id="edit_plan_desc" class="input-box" rows="3" required></textarea>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Floor Plan Image (Leave blank to keep current)</label>
                        <input type="file" name="plan_image" class="input-box">
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" id="edit_sort_order" class="input-box">
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <label>Specifications (Key-Value)</label>
                    <div id="edit-spec-container">
                        <!-- Dynamic specs -->
                    </div>
                    <button type="button" onclick="addSpecRow('edit-spec-container')" style="background:none; border:1px dashed #cbd5e0; padding:10px; width:100%; border-radius:4px; color:#4a5568; cursor:pointer; font-weight:600;">+ Add Specification Row</button>
                </div>

                <div style="text-align: right; margin-top: 30px;">
                    <button type="submit" name="update_plan" class="btn-add" style="background:var(--primary-gold); color:#fff; border:none; padding:12px 40px; border-radius:4px; cursor:pointer; font-weight:700;">Update Floor Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).style.display = 'block'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }

    function addSpecRow(containerId, label = '', value = '') {
        const html = `
            <div class="spec-row">
                <input type="text" name="spec_labels[]" class="input-box" value="${label}" placeholder="Label">
                <input type="text" name="spec_values[]" class="input-box" value="${value}" placeholder="Value">
                <button type="button" class="btn-delete" onclick="$(this).parent().remove()"><i class="fas fa-times"></i></button>
            </div>
        `;
        document.getElementById(containerId).insertAdjacentHTML('beforeend', html);
    }

    function editPlan(plan) {
        document.getElementById('edit_plan_id').value = plan.id;
        document.getElementById('edit_tab_title').value = plan.tab_title;
        document.getElementById('edit_plan_title').value = plan.plan_title;
        document.getElementById('edit_plan_desc').value = plan.plan_desc;
        document.getElementById('edit_sort_order').value = plan.sort_order;

        const container = document.getElementById('edit-spec-container');
        container.innerHTML = '';
        plan.specs.forEach(s => {
            addSpecRow('edit-spec-container', s.label, s.value);
        });

        openModal('editPlanModal');
    }

    // Close modal on outside click
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>

</body>
</html>
