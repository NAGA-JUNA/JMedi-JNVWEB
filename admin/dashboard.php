<?php
$pageTitle = 'Dashboard';
require_once __DIR__ . '/../includes/admin_header.php';

$totalDoctors = getCount($pdo, 'doctors');
$totalDepts = getCount($pdo, 'departments');
$totalAppointments = getCount($pdo, 'appointments');
$totalPosts = getCount($pdo, 'posts');

$recentAppointments = $pdo->query("SELECT a.*, d.name as doctor_name, dep.name as department_name FROM appointments a LEFT JOIN doctors d ON a.doctor_id = d.doctor_id LEFT JOIN departments dep ON a.department_id = dep.department_id ORDER BY a.created_at DESC LIMIT 5")->fetchAll();

$pendingCount = (int)$pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'")->fetchColumn();
?>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number"><?= $totalDoctors ?></div>
                    <div class="stat-label">Total Doctors</div>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #0D6EFD, #0b5ed7);">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number"><?= $totalDepts ?></div>
                    <div class="stat-label">Departments</div>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #20C997, #1aae82);">
                    <i class="fas fa-hospital"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number"><?= $totalAppointments ?></div>
                    <div class="stat-label">Appointments</div>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #ffc107, #e0a800);">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-number"><?= $totalPosts ?></div>
                    <div class="stat-label">Blog Posts</div>
                </div>
                <div class="stat-icon" style="background: linear-gradient(135deg, #6f42c1, #5a32a3);">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($pendingCount > 0): ?>
<div class="alert alert-warning d-flex align-items-center mb-4">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <span>You have <strong><?= $pendingCount ?></strong> pending appointment(s) awaiting review.</span>
    <a href="/admin/appointments.php?status=pending" class="btn btn-warning btn-sm ms-auto">View Pending</a>
</div>
<?php endif; ?>

<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Recent Appointments</h5>
        <a href="/admin/appointments.php" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentAppointments)): ?>
                <tr><td colspan="5" class="text-center text-muted py-4">No appointments yet</td></tr>
                <?php else: ?>
                <?php foreach ($recentAppointments as $apt): ?>
                <tr>
                    <td><?= e($apt['patient_name']) ?></td>
                    <td><?= e($apt['doctor_name'] ?? 'Not specified') ?></td>
                    <td><?= e($apt['department_name'] ?? 'Not specified') ?></td>
                    <td><?= formatDate($apt['appointment_date']) ?></td>
                    <td><span class="badge badge-<?= $apt['status'] ?>"><?= ucfirst($apt['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
