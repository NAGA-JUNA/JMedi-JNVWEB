<?php
$pageTitle = 'Website Settings';
require_once __DIR__ . '/../includes/admin_header.php';

$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $settingKeys = ['site_name', 'tagline', 'phone', 'emergency_phone', 'email', 'address', 'facebook', 'twitter', 'instagram', 'linkedin', 'primary_color', 'secondary_color', 'footer_text'];
        foreach ($settingKeys as $key) {
            if (isset($_POST[$key])) {
                updateSetting($pdo, $key, trim($_POST[$key]));
            }
        }
        $success = 'Settings saved successfully.';
        $settings = getSettings($pdo);
    }
}

$s = getSettings($pdo);
?>

<?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>

<div class="form-card">
    <form method="POST">
        <?= csrfField() ?>
        <div class="row g-4">
            <div class="col-12"><h5 class="border-bottom pb-2">General</h5></div>
            <div class="col-md-6">
                <label class="form-label">Hospital / Site Name</label>
                <input type="text" name="site_name" class="form-control" value="<?= e($s['site_name'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Tagline</label>
                <input type="text" name="tagline" class="form-control" value="<?= e($s['tagline'] ?? '') ?>">
            </div>

            <div class="col-12 mt-4"><h5 class="border-bottom pb-2">Contact Information</h5></div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="<?= e($s['phone'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Emergency Phone</label>
                <input type="text" name="emergency_phone" class="form-control" value="<?= e($s['emergency_phone'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= e($s['email'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="<?= e($s['address'] ?? '') ?>">
            </div>

            <div class="col-12 mt-4"><h5 class="border-bottom pb-2">Social Media</h5></div>
            <div class="col-md-6">
                <label class="form-label">Facebook</label>
                <input type="url" name="facebook" class="form-control" value="<?= e($s['facebook'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Twitter</label>
                <input type="url" name="twitter" class="form-control" value="<?= e($s['twitter'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Instagram</label>
                <input type="url" name="instagram" class="form-control" value="<?= e($s['instagram'] ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">LinkedIn</label>
                <input type="url" name="linkedin" class="form-control" value="<?= e($s['linkedin'] ?? '') ?>">
            </div>

            <div class="col-12 mt-4"><h5 class="border-bottom pb-2">Appearance</h5></div>
            <div class="col-md-4">
                <label class="form-label">Primary Color</label>
                <input type="color" name="primary_color" class="form-control form-control-color" value="<?= e($s['primary_color'] ?? '#0D6EFD') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Secondary Color</label>
                <input type="color" name="secondary_color" class="form-control form-control-color" value="<?= e($s['secondary_color'] ?? '#20C997') ?>">
            </div>
            <div class="col-md-4"></div>
            <div class="col-12">
                <label class="form-label">Footer Text</label>
                <input type="text" name="footer_text" class="form-control" value="<?= e($s['footer_text'] ?? '') ?>">
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary btn-lg px-5">Save Settings</button>
            </div>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
