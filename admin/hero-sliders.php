<?php
$pageTitle = 'Hero Sliders';
require_once __DIR__ . '/../includes/admin_header.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = 'Invalid form submission.';
    } elseif (isset($_POST['delete_id'])) {
        $pdo->prepare("DELETE FROM hero_slides WHERE id = :id")->execute([':id' => (int)$_POST['delete_id']]);
        header('Location: /admin/hero-sliders.php?msg=deleted');
        exit;
    } elseif (isset($_POST['toggle_id'])) {
        $pdo->prepare("UPDATE hero_slides SET status = CASE WHEN status = 1 THEN 0 ELSE 1 END WHERE id = :id")
            ->execute([':id' => (int)$_POST['toggle_id']]);
        header('Location: /admin/hero-sliders.php?msg=toggled');
        exit;
    } else {
        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $buttonText = trim($_POST['button_text'] ?? 'Learn More');
        $buttonLink = trim($_POST['button_link'] ?? '#');
        $overlayColor = trim($_POST['overlay_color'] ?? 'rgba(15,33,55,0.7)');
        $textAnimation = $_POST['text_animation'] ?? 'fadeIn';
        $transitionEffect = $_POST['transition_effect'] ?? 'slide';
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $status = (int)($_POST['status'] ?? 1);

        $bgImage = null;
        if (!empty($_FILES['background_image']['name'])) {
            $bgImage = uploadImage($_FILES['background_image'], 'uploads/slides');
        }

        if (empty($title)) {
            $error = 'Slide title is required.';
        } else {
            if (isset($_POST['slide_id']) && $_POST['slide_id']) {
                $sql = "UPDATE hero_slides SET title=:title, subtitle=:subtitle, description=:description, button_text=:btn_text, button_link=:btn_link, overlay_color=:overlay, text_animation=:anim, transition_effect=:trans, sort_order=:sort, status=:status";
                $data = [
                    ':title' => $title, ':subtitle' => $subtitle, ':description' => $description,
                    ':btn_text' => $buttonText, ':btn_link' => $buttonLink, ':overlay' => $overlayColor,
                    ':anim' => $textAnimation, ':trans' => $transitionEffect,
                    ':sort' => $sortOrder, ':status' => $status, ':id' => (int)$_POST['slide_id']
                ];
                if ($bgImage) {
                    $sql .= ", background_image=:img";
                    $data[':img'] = $bgImage;
                }
                $sql .= " WHERE id=:id";
                $pdo->prepare($sql)->execute($data);
                $success = 'Slide updated successfully.';
            } else {
                $pdo->prepare("INSERT INTO hero_slides (title, subtitle, description, button_text, button_link, background_image, overlay_color, text_animation, transition_effect, sort_order, status) VALUES (:title, :subtitle, :description, :btn_text, :btn_link, :img, :overlay, :anim, :trans, :sort, :status)")
                    ->execute([
                        ':title' => $title, ':subtitle' => $subtitle, ':description' => $description,
                        ':btn_text' => $buttonText, ':btn_link' => $buttonLink, ':img' => $bgImage,
                        ':overlay' => $overlayColor, ':anim' => $textAnimation, ':trans' => $transitionEffect,
                        ':sort' => $sortOrder, ':status' => $status
                    ]);
                $success = 'Slide created successfully.';
            }
            $action = 'list';
        }
    }
}

$editSlide = null;
if ($action === 'edit' && $id) {
    $editSlide = getHeroSlide($pdo, $id);
    if (!$editSlide) { $error = 'Slide not found.'; $action = 'list'; }
}

if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'deleted') $success = 'Slide deleted.';
    if ($_GET['msg'] === 'toggled') $success = 'Slide status updated.';
}

$allSlides = getHeroSlides($pdo);
?>

<?php if ($success): ?><div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= e($success) ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= e($error) ?></div><?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="form-card">
    <h5 class="mb-4"><i class="fas fa-<?= $editSlide ? 'edit' : 'plus' ?> me-2"></i><?= $editSlide ? 'Edit' : 'Add New' ?> Slide</h5>
    <form method="POST" enctype="multipart/form-data">
        <?= csrfField() ?>
        <?php if ($editSlide): ?><input type="hidden" name="slide_id" value="<?= $editSlide['id'] ?>"><?php endif; ?>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="<?= e($editSlide['title'] ?? '') ?>" required placeholder="Main headline text">
            </div>
            <div class="col-md-12">
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle" class="form-control" value="<?= e($editSlide['subtitle'] ?? '') ?>" placeholder="Smaller text above title">
            </div>
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Slide description text"><?= e($editSlide['description'] ?? '') ?></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Button Text</label>
                <input type="text" name="button_text" class="form-control" value="<?= e($editSlide['button_text'] ?? 'Learn More') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Button Link</label>
                <input type="text" name="button_link" class="form-control" value="<?= e($editSlide['button_link'] ?? '#') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">Background Image</label>
                <input type="file" name="background_image" class="form-control" accept="image/*">
                <?php if (!empty($editSlide['background_image'])): ?>
                    <small class="text-muted">Current: <?= e(basename($editSlide['background_image'])) ?></small>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label class="form-label">Overlay Color</label>
                <input type="text" name="overlay_color" class="form-control" value="<?= e($editSlide['overlay_color'] ?? 'rgba(15,33,55,0.7)') ?>" placeholder="rgba(15,33,55,0.7)">
            </div>
            <div class="col-md-4">
                <label class="form-label">Text Animation</label>
                <select name="text_animation" class="form-select">
                    <?php foreach (['fadeIn'=>'Fade In','slideUp'=>'Slide Up','slideLeft'=>'Slide Left','zoomIn'=>'Zoom In'] as $val=>$lbl): ?>
                    <option value="<?= $val ?>" <?= ($editSlide['text_animation'] ?? 'fadeIn') === $val ? 'selected' : '' ?>><?= $lbl ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Transition Effect</label>
                <select name="transition_effect" class="form-select">
                    <?php foreach (['slide'=>'Slide','fade'=>'Fade','zoom'=>'Zoom'] as $val=>$lbl): ?>
                    <option value="<?= $val ?>" <?= ($editSlide['transition_effect'] ?? 'slide') === $val ? 'selected' : '' ?>><?= $lbl ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="<?= (int)($editSlide['sort_order'] ?? 0) ?>" min="0">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="1" <?= ($editSlide['status'] ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= ($editSlide['status'] ?? 1) == 0 ? 'selected' : '' ?>>Disabled</option>
                </select>
            </div>
            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Save Slide</button>
                <a href="/admin/hero-sliders.php" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </div>
    </form>
</div>
<?php else: ?>
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Hero Slides (<?= count($allSlides) ?>)</h5>
        <a href="/admin/hero-sliders.php?action=add" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Slide</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>Order</th><th>Title</th><th>Animation</th><th>Image</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php if (empty($allSlides)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No slides yet. Click "Add Slide" to create one.</td></tr>
                <?php endif; ?>
                <?php foreach ($allSlides as $s): ?>
                <tr>
                    <td><span class="badge bg-secondary"><?= $s['sort_order'] ?></span></td>
                    <td>
                        <strong><?= e($s['title']) ?></strong>
                        <?php if ($s['subtitle']): ?><br><small class="text-muted"><?= e($s['subtitle']) ?></small><?php endif; ?>
                    </td>
                    <td><span class="badge bg-info"><?= e($s['text_animation']) ?></span></td>
                    <td>
                        <?php if ($s['background_image']): ?>
                            <img src="<?= e($s['background_image']) ?>" alt="Slide" style="width:80px;height:45px;object-fit:cover;border-radius:6px;">
                        <?php else: ?>
                            <span class="text-muted"><i class="fas fa-image"></i> Gradient</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST" class="d-inline">
                            <?= csrfField() ?>
                            <input type="hidden" name="toggle_id" value="<?= $s['id'] ?>">
                            <button class="btn btn-sm <?= $s['status'] ? 'btn-success' : 'btn-outline-secondary' ?>">
                                <i class="fas fa-<?= $s['status'] ? 'eye' : 'eye-slash' ?>"></i>
                                <?= $s['status'] ? 'Active' : 'Disabled' ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="/admin/hero-sliders.php?action=edit&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this slide?')">
                            <?= csrfField() ?>
                            <input type="hidden" name="delete_id" value="<?= $s['id'] ?>">
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
