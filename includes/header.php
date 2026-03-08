<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/auth.php';
$settings = getSettings($pdo);
$siteName = $settings['site_name'] ?? 'JMedi';
$primaryColor = $settings['primary_color'] ?? '#0D6EFD';
$secondaryColor = $settings['secondary_color'] ?? '#20C997';
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$frontendLogo = $settings['frontend_logo'] ?? '';

$navMenus = [];
try {
    $navMenus = $pdo->query("SELECT * FROM menus WHERE status=1 ORDER BY menu_order ASC")->fetchAll();
} catch (Exception $e) {
    $navMenus = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' – ' : '' ?><?= e($siteName) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/hero-slider.css" rel="stylesheet">
    <style>
        :root {
            --primary: <?= e($primaryColor) ?>;
            --secondary: <?= e($secondaryColor) ?>;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body>
<div class="topbar text-white py-2 d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <span class="me-4"><i class="fas fa-clock me-1 opacity-75"></i> Mon-Sat: 8:00 AM - 7:00 PM</span>
            <span class="me-4"><i class="fas fa-phone-alt me-1 opacity-75"></i> <?= e($settings['phone'] ?? '') ?></span>
            <span><i class="fas fa-envelope me-1 opacity-75"></i> <?= e($settings['email'] ?? '') ?></span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <?php if (!empty($settings['facebook'])): ?><a href="<?= e($settings['facebook']) ?>" class="text-white"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
            <?php if (!empty($settings['twitter'])): ?><a href="<?= e($settings['twitter']) ?>" class="text-white"><i class="fab fa-twitter"></i></a><?php endif; ?>
            <?php if (!empty($settings['instagram'])): ?><a href="<?= e($settings['instagram']) ?>" class="text-white"><i class="fab fa-instagram"></i></a><?php endif; ?>
            <?php if (!empty($settings['linkedin'])): ?><a href="<?= e($settings['linkedin']) ?>" class="text-white"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <?php if ($frontendLogo): ?>
                <img src="<?= e($frontendLogo) ?>" alt="<?= e($siteName) ?>" style="max-height:40px;">
            <?php else: ?>
                <span style="color:var(--primary);">J</span><span style="color:var(--secondary);">Medi</span>
            <?php endif; ?>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                <?php if (!empty($navMenus)): ?>
                    <?php foreach ($navMenus as $menuItem):
                        $menuSlug = basename($menuItem['menu_link'], '.php');
                        $isActive = ($menuItem['menu_link'] === '/' && $currentPage === 'index') || $menuSlug === $currentPage;
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $isActive ? 'active' : '' ?>" href="<?= e($menuItem['menu_link']) ?>"><?= e($menuItem['menu_name']) ?></a>
                    </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link <?= $currentPage === 'index' ? 'active' : '' ?>" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?= $currentPage === 'departments' ? 'active' : '' ?>" href="/public/departments.php">Departments</a></li>
                    <li class="nav-item"><a class="nav-link <?= $currentPage === 'doctors' ? 'active' : '' ?>" href="/public/doctors.php">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link <?= $currentPage === 'blog' ? 'active' : '' ?>" href="/public/blog.php">Blog</a></li>
                    <li class="nav-item"><a class="nav-link <?= $currentPage === 'contact' ? 'active' : '' ?>" href="/public/contact.php">Contact</a></li>
                <?php endif; ?>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-primary px-4" href="/public/appointment.php">
                        <i class="fas fa-calendar-check me-1"></i> Appointment
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <?php if (isLoggedIn()): ?>
                        <a class="btn btn-outline-primary px-4" href="/admin/">
                            <i class="fas fa-user-shield me-1"></i> Dashboard
                        </a>
                    <?php else: ?>
                        <button class="btn btn-outline-primary px-4" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </button>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-0 text-white px-4 pt-4 pb-3" style="background: linear-gradient(135deg, var(--primary) 0%, #0a58ca 100%);">
                <div>
                    <h5 class="modal-title fw-bold mb-1" id="loginModalLabel"><i class="fas fa-lock me-2"></i>Admin Login</h5>
                    <p class="mb-0 opacity-75 small">Sign in to access the admin dashboard</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-4">
                <div id="loginAlert" class="alert d-none mb-3" role="alert"></div>
                <form id="loginForm" novalidate>
                    <?= csrfField() ?>
                    <div class="mb-3">
                        <label for="loginUsername" class="form-label fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="loginUsername" name="username" placeholder="Enter your username" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="loginPassword" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0" id="loginPassword" name="password" placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" id="loginSubmitBtn">
                        <span id="loginBtnText"><i class="fas fa-sign-in-alt me-2"></i>Sign In</span>
                        <span id="loginSpinner" class="d-none"><span class="spinner-border spinner-border-sm me-2"></span>Signing in...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
