<?php $isPublic = !is_logged_in(); ?>
<?php if ($bare): ?><div class="container py-4"><a href="<?= url('landingpage') ?>" class="btn btn-outline-dark btn-sm mb-3"><i class="bi bi-arrow-right"></i> الرئيسية</a><?php endif; ?>
<h1 class="h2 fw-bold mb-3">📚 المقررات <?= $cat !== '' ? '- ' . e($cat) : '' ?></h1>

<form class="row g-2 mb-3" method="get" action="index.php">
    <input type="hidden" name="page" value="<?= e($_GET['page'] ?? 'courses') ?>">
    <div class="col-md-6"><input type="search" name="q" value="<?= e($q) ?>" class="form-control" placeholder="ابحث بالاسم أو الرمز..."></div>
    <div class="col-md-4">
        <select name="category" class="form-select" onchange="this.form.submit()">
            <option value="">كل التصنيفات</option>
            <?php foreach ($categories as $c): ?><option value="<?= e($c['name']) ?>" <?= $cat === $c['name'] ? 'selected' : '' ?>><?= e($c['name']) ?> (<?= (int)$c['n'] ?>)</option><?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2 d-grid"><button class="btn btn-primary" type="submit">بحث</button></div>
</form>

<p class="text-muted">عدد النتائج: <?= count($list) ?></p>
<div class="row g-3">
    <?php foreach ($list as $c): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card card-hover h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge course-badge"><?= e($c['course_code']) ?></span>
                        <?php if (in_array($c['course_code'], $saved, true)): ?><i class="bi bi-bookmark-star-fill text-warning" title="محفوظ"></i><?php endif; ?>
                    </div>
                    <h5 class="fw-bold"><?= e($c['title']) ?></h5>
                    <p class="text-muted small flex-grow-1"><?= e($c['description']) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted"><i class="bi bi-link-45deg"></i> <?= (int)$c['res_count'] ?> مصادر</small>
                        <a href="<?= url('course', ['code' => $c['course_code']]) ?>" class="btn btn-primary btn-sm">عرض التفاصيل</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (!$list): ?><div class="col-12"><div class="alert alert-warning">لا توجد مقررات مطابقة لبحثك.</div></div><?php endif; ?>
</div>
<?php if ($bare): ?></div><?php endif; ?>
