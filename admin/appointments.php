<?php
$pageTitle = 'Manage Appointments';
require_once __DIR__ . '/../includes/admin_header.php';

$filterStatus = $_GET['status'] ?? '';
$search = $_GET['search'] ?? '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyCSRFToken($_POST['csrf_token'] ?? '')) {
    $aptId = (int)($_POST['appointment_id'] ?? 0);
    $aptAction = $_POST['apt_action'] ?? '';
    if ($aptId && $aptAction === 'approve') {
        $pdo->prepare("UPDATE appointments SET status = 'approved' WHERE appointment_id = :id")->execute([':id' => $aptId]);
        header('Location: /admin/appointments.php?msg=approved');
        exit;
    } elseif ($aptId && $aptAction === 'cancel') {
        $pdo->prepare("UPDATE appointments SET status = 'cancelled' WHERE appointment_id = :id")->execute([':id' => $aptId]);
        header('Location: /admin/appointments.php?msg=cancelled');
        exit;
    } elseif ($aptId && $aptAction === 'delete') {
        $pdo->prepare("DELETE FROM appointments WHERE appointment_id = :id")->execute([':id' => $aptId]);
        header('Location: /admin/appointments.php?msg=deleted');
        exit;
    }
}

$msgMap = ['approved'=>'Appointment approved.', 'cancelled'=>'Appointment cancelled.', 'deleted'=>'Appointment deleted.'];
$success = $msgMap[$_GET['msg'] ?? ''] ?? '';

$appointments = getAppointments($pdo, $filterStatus ?: null, $search ?: null);
$csrfToken = generateCSRFToken();
?>

<?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="table-card">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h5 class="mb-0">Appointments (<?= count($appointments) ?>)</h5>
        <div class="d-flex gap-2">
            <form method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="<?= e($search) ?>" style="width:180px;">
                <select name="status" class="form-select form-select-sm" style="width:140px;" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="pending" <?= $filterStatus === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= $filterStatus === 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="cancelled" <?= $filterStatus === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
                <button class="btn btn-sm btn-primary">Filter</button>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($appointments)): ?>
                <tr><td colspan="10" class="text-center text-muted py-4">No appointments found</td></tr>
                <?php else: ?>
                <?php foreach ($appointments as $apt): ?>
                <tr>
                    <td><?= $apt['appointment_id'] ?></td>
                    <td><?= e($apt['patient_name']) ?></td>
                    <td><?= e($apt['email']) ?></td>
                    <td><?= e($apt['phone']) ?></td>
                    <td><?= e($apt['doctor_name'] ?? '–') ?></td>
                    <td><?= e($apt['department_name'] ?? '–') ?></td>
                    <td><?= formatDate($apt['appointment_date']) ?></td>
                    <td><?= e($apt['appointment_time']) ?></td>
                    <td><span class="badge badge-<?= $apt['status'] ?>"><?= ucfirst($apt['status']) ?></span></td>
                    <td class="d-flex gap-1">
                        <?php if ($apt['status'] === 'pending'): ?>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="appointment_id" value="<?= $apt['appointment_id'] ?>">
                            <input type="hidden" name="apt_action" value="approve">
                            <button class="btn btn-sm btn-success" title="Approve"><i class="fas fa-check"></i></button>
                        </form>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="appointment_id" value="<?= $apt['appointment_id'] ?>">
                            <input type="hidden" name="apt_action" value="cancel">
                            <button class="btn btn-sm btn-warning" title="Cancel"><i class="fas fa-times"></i></button>
                        </form>
                        <?php endif; ?>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this appointment?')">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="appointment_id" value="<?= $apt['appointment_id'] ?>">
                            <input type="hidden" name="apt_action" value="delete">
                            <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
