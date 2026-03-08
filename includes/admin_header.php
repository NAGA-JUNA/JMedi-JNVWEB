<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';
requireLogin();

$adminPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' – ' : '' ?>JMedi Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/admin.css" rel="stylesheet">
</head>
<body>
<div class="admin-wrapper d-flex">
    <nav class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="/admin/dashboard.php" class="sidebar-brand">
                <span class="text-primary">J</span><span class="text-success">Medi</span>
            </a>
            <small class="text-muted d-block">Admin Panel</small>
        </div>
        <ul class="sidebar-nav">
            <li class="<?= $adminPage === 'dashboard' ? 'active' : '' ?>">
                <a href="/admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
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
                <a href="/admin/blog.php"><i class="fas fa-newspaper"></i> Blog</a>
            </li>
            <li class="<?= $adminPage === 'testimonials' ? 'active' : '' ?>">
                <a href="/admin/testimonials.php"><i class="fas fa-comments"></i> Testimonials</a>
            </li>
            <li class="<?= $adminPage === 'settings' ? 'active' : '' ?>">
                <a href="/admin/settings.php"><i class="fas fa-cog"></i> Settings</a>
            </li>
            <li class="mt-3 border-top pt-3">
                <a href="/"><i class="fas fa-globe"></i> View Website</a>
            </li>
            <li>
                <a href="/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </nav>

    <div class="admin-content flex-grow-1">
        <header class="admin-topbar d-flex justify-content-between align-items-center">
            <button class="btn btn-link d-lg-none" id="sidebarToggle"><i class="fas fa-bars fs-5"></i></button>
            <h5 class="mb-0 d-none d-lg-block"><?= e($pageTitle ?? 'Dashboard') ?></h5>
            <div class="d-flex align-items-center">
                <span class="text-muted me-3 d-none d-md-inline">Welcome, <?= e($_SESSION['admin_name'] ?? 'Admin') ?></span>
                <a href="/admin/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>
        </header>
        <main class="admin-main p-4">
