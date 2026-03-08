<?php
$pageTitle = 'Book Appointment';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

$departments = getDepartments($pdo);
$doctors = getDoctors($pdo);
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_appointment'])) {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid form submission. Please try again.';
    } else {
        $name = trim($_POST['patient_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $deptId = (int)($_POST['department_id'] ?? 0);
        $docId = (int)($_POST['doctor_id'] ?? 0);
        $date = $_POST['appointment_date'] ?? '';
        $time = $_POST['appointment_time'] ?? '';
        $message = trim($_POST['message'] ?? '');

        if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time)) {
            $error = 'Please fill in all required fields.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO appointments (patient_name, email, phone, department_id, doctor_id, appointment_date, appointment_time, message) VALUES (:name, :email, :phone, :dept, :doc, :date, :time, :msg)");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':dept' => $deptId ?: null,
                ':doc' => $docId ?: null,
                ':date' => $date,
                ':time' => $time,
                ':msg' => $message
            ]);
            $success = 'Your appointment request has been submitted successfully! We will confirm it within 24 hours.';
            $_SESSION['csrf_token'] = '';
        }
    }
}

$preselectedDoctor = (int)($_GET['doctor'] ?? 0);
?>

<div class="page-header">
    <div class="container">
        <h1>Book an Appointment</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Appointment</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if ($success): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= e($success) ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= e($error) ?></div>
                <?php endif; ?>

                <div class="bg-white rounded-3 p-4 shadow-sm">
                    <h4 class="mb-4">Schedule Your Visit</h4>
                    <form method="POST" class="needs-validation" novalidate>
                        <?= csrfField() ?>
                        <input type="hidden" name="book_appointment" value="1">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="patient_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <select name="department_id" id="department_id" class="form-select">
                                    <option value="">Select Department</option>
                                    <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept['department_id'] ?>"><?= e($dept['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Doctor</label>
                                <select name="doctor_id" id="doctor_id" class="form-select">
                                    <option value="">Select Doctor</option>
                                    <?php foreach ($doctors as $doc): ?>
                                    <option value="<?= $doc['doctor_id'] ?>" <?= $preselectedDoctor == $doc['doctor_id'] ? 'selected' : '' ?>><?= e($doc['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="appointment_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Time <span class="text-danger">*</span></label>
                                <input type="time" name="appointment_time" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="Describe your symptoms or reason for visit..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg px-5">Submit Appointment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="bg-primary text-white rounded-3 p-4 mb-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Important Info</h5>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><i class="fas fa-check me-2"></i>Confirmation within 24 hours</li>
                        <li class="mb-2"><i class="fas fa-check me-2"></i>Free initial consultation</li>
                        <li class="mb-2"><i class="fas fa-check me-2"></i>All major insurance accepted</li>
                        <li><i class="fas fa-check me-2"></i>Easy rescheduling available</li>
                    </ul>
                </div>
                <div class="bg-light rounded-3 p-4">
                    <h5><i class="fas fa-phone-alt me-2 text-primary"></i>Need Help?</h5>
                    <p class="text-muted">Call us for immediate assistance</p>
                    <p class="h5 text-primary"><?= e($settings['phone'] ?? '') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
