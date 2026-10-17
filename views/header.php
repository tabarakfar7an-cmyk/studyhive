<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="icon" href="assets/img/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="<?= $bare ? 'page-bare' : '' ?>">
<?php if (!$bare): $cur = $_GET['page'] ?? 'home'; $navUser = current_user(); ?>
<nav class="navbar navbar-expand-lg sh-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= url('home') ?>">
            <img src="assets/img/logo.png" alt="StudyHive" height="44"><span class="fw-bold">StudyHive</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="القائمة">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-lg-3 mb-2 mb-lg-0">
                <?php foreach ([['home','الرئيسية'],['courses','المقررات'],['resources','موارد الدراسة'],['forum','المنتدى'],['contact','الدعم']] as [$p,$label]): ?>
                    <li class="nav-item"><a class="nav-link <?= $cur === $p || ($p === 'courses' && $cur === 'course') ? 'active' : '' ?>" href="<?= url($p) ?>"><?= $label ?></a></li>
                <?php endforeach; ?>
                <?php if (is_admin()): ?><li class="nav-item"><a class="nav-link <?= $cur === 'admin' ? 'active' : '' ?>" href="<?= url('admin') ?>"><i class="bi bi-gear"></i> الإدارة</a></li><?php endif; ?>
            </ul>
            <form class="d-flex me-lg-auto my-2 my-lg-0" action="index.php" method="get" role="search">
                <input type="hidden" name="page" value="courses">
                <div class="input-group">
                    <input type="search" name="q" class="form-control" placeholder="ابحث عن مقرر..." aria-label="بحث" value="<?= e($_GET['q'] ?? '') ?>">
                    <button class="btn btn-dark" type="submit" aria-label="بحث"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <div class="ms-lg-3">
                <?php if ($navUser): ?>
                    <div class="dropdown">
                        <a class="d-flex align-items-center gap-2 text-dark text-decoration-none dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/img/profile-icon.png" alt="" class="avatar-sm"><span class="fw-bold"><?= e($navUser['username']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= url('profile') ?>"><i class="bi bi-person"></i> الملف الشخصي</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= url('logout') ?>"><i class="bi bi-box-arrow-left"></i> تسجيل الخروج</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= url('login') ?>" class="btn btn-dark btn-sm">تسجيل الدخول</a>
                    <a href="<?= url('register') ?>" class="btn btn-outline-dark btn-sm">حساب جديد</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<?php endif; ?>
<?php $flashes = pull_flash(); if ($flashes): ?>
<div class="container mt-3">
    <?php foreach ($flashes as [$t, $m]): ?>
        <div class="alert alert-<?= e($t) ?> alert-dismissible fade show" role="alert"><?= e($m) ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<main class="<?= $bare ? '' : 'container py-4' ?>">
