<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';
requireLogin();

$adminPage = basename($_SERVER['PHP_SELF'], '.php');
$adminName = $_SESSION['admin_name'] ?? 'Admin';
$adminInitials = strtoupper(substr($adminName, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' – ' : '' ?>JMedi Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/admin.css" rel="stylesheet">
</head>
<body>
<div class="admin-wrapper d-flex">
    <nav class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="/admin/dashboard.php" class="sidebar-brand text-white text-decoration-none">
                <span class="brand-icon"><i class="fas fa-heartbeat"></i></span>
                <span>JMedi</span>
            </a>
        </div>
        <div class="sidebar-section-label">Menu</div>
        <ul class="sidebar-nav">
            <li class="<?= $adminPage === 'dashboard' ? 'active' : '' ?>">
                <a href="/admin/dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a>
            </li>
            <li class="<?= $adminPage === 'hero-sliders' ? 'active' : '' ?>">
                <a href="/admin/hero-sliders.php"><i class="fas fa-images"></i> Hero Sliders</a>
            </li>
            <li class="<?= $adminPage === 'doctors' ? 'active' : '' ?>">
                <a href="/admin/doctors.php"><i class="fas fa-user-md"></i> Doctors</a>
            </li>
            <li class="<?= $adminPage === 'departments' ? 'active' : '' ?>">
                <a href="/admin/departments.php"><i class="fas fa-hospital"></i> Departments</a>
            </li>
            <li class="<?= $adminPage === 'appointments' ? 'active' : '' ?>">
                <a href="/admin/appointments.php"><i class="fas fa-calendar-check"></i> Appointments</a>
            </li>
            <li class="<?= $adminPage === 'blog' ? 'active' : '' ?>">
                <a href="/admin/blog.php"><i class="fas fa-newspaper"></i> Blog Posts</a>
            </li>
            <li class="<?= $adminPage === 'testimonials' ? 'active' : '' ?>">
                <a href="/admin/testimonials.php"><i class="fas fa-comments"></i> Testimonials</a>
            </li>
        </ul>
        <div class="sidebar-section-label">CMS</div>
        <ul class="sidebar-nav">
            <li class="<?= $adminPage === 'menu-manager' ? 'active' : '' ?>">
                <a href="/admin/menu-manager.php"><i class="fas fa-bars"></i> Menu Manager</a>
            </li>
            <li class="<?= $adminPage === 'pages' ? 'active' : '' ?>">
                <a href="/admin/pages.php"><i class="fas fa-file-alt"></i> Page Editor</a>
            </li>
        </ul>
        <div class="sidebar-section-label">Other Menu</div>
        <ul class="sidebar-nav">
            <li class="<?= $adminPage === 'settings' ? 'active' : '' ?>">
                <a href="/admin/settings.php"><i class="fas fa-cog"></i> Settings</a>
            </li>
            <li>
                <a href="/"><i class="fas fa-globe"></i> View Website</a>
            </li>
            <li>
                <a href="/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </nav>

    <div class="admin-content flex-grow-1">
        <header class="admin-topbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link d-lg-none p-0 text-dark" id="sidebarToggle"><i class="fas fa-bars fs-5"></i></button>
                <div class="topbar-search d-none d-md-block">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search here..." class="form-control">
                </div>
            </div>
            <div class="topbar-actions">
                <a href="/admin/appointments.php?action=add" class="btn-add d-none d-sm-flex">
                    <i class="fas fa-plus"></i> Add patient
                </a>
                <div class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <?php
                    $pendingNotif = (int)$pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'")->fetchColumn();
                    if ($pendingNotif > 0): ?>
                        <span class="notification-dot"></span>
                    <?php endif; ?>
                </div>
                <div class="topbar-avatar" title="<?= e($adminName) ?>">
                    <?= $adminInitials ?>
                </div>
            </div>
        </header>
        <main class="admin-main p-4">
