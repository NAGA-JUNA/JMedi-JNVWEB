<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';
$settings = getSettings($pdo);
$siteName = $settings['site_name'] ?? 'JMedi';
$primaryColor = $settings['primary_color'] ?? '#0D6EFD';
$secondaryColor = $settings['secondary_color'] ?? '#20C997';
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' – ' : '' ?><?= e($siteName) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        :root {
            --primary: <?= e($primaryColor) ?>;
            --secondary: <?= e($secondaryColor) ?>;
        }
    </style>
</head>
<body>
<div class="topbar bg-primary text-white py-2 d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <span class="me-3"><i class="fas fa-phone-alt me-1"></i> <?= e($settings['phone'] ?? '') ?></span>
            <span><i class="fas fa-envelope me-1"></i> <?= e($settings['email'] ?? '') ?></span>
        </div>
        <div>
            <?php if (!empty($settings['facebook'])): ?><a href="<?= e($settings['facebook']) ?>" class="text-white me-3"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
            <?php if (!empty($settings['twitter'])): ?><a href="<?= e($settings['twitter']) ?>" class="text-white me-3"><i class="fab fa-twitter"></i></a><?php endif; ?>
            <?php if (!empty($settings['instagram'])): ?><a href="<?= e($settings['instagram']) ?>" class="text-white me-3"><i class="fab fa-instagram"></i></a><?php endif; ?>
            <?php if (!empty($settings['linkedin'])): ?><a href="<?= e($settings['linkedin']) ?>" class="text-white"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <span class="text-primary">J</span><span class="text-success">Medi</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'index' ? 'active' : '' ?>" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'departments' ? 'active' : '' ?>" href="/public/departments.php">Departments</a></li>
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'doctors' ? 'active' : '' ?>" href="/public/doctors.php">Doctors</a></li>
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'blog' ? 'active' : '' ?>" href="/public/blog.php">Blog</a></li>
                <li class="nav-item"><a class="nav-link <?= $currentPage === 'contact' ? 'active' : '' ?>" href="/public/contact.php">Contact</a></li>
                <li class="nav-item ms-lg-2">
                    <a class="btn btn-primary px-4" href="/public/appointment.php">Book Appointment</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
