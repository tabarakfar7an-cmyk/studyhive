<h1 class="h2 fw-bold mb-1">📚 موارد الدراسة</h1>
<p class="text-muted">مصادر مجانية مختارة لكل مقرر: كتب، فيديوهات، مقررات مفتوحة وتمارين. الروابط تفتح في نافذة جديدة.</p>

<form class="row g-2 mb-3" method="get" action="index.php">
    <input type="hidden" name="page" value="resources">
    <div class="col-md-4"><input type="search" name="q" class="form-control" placeholder="ابحث في المصادر..." value="<?= e($q) ?>"></div>
    <div class="col-md-3">
        <select name="course" class="form-select" onchange="this.form.submit()">
            <option value="">كل المقررات</option>
            <?php foreach ($courseList as $c): ?><option value="<?= e($c['course_code']) ?>" <?= $course === $c['course_code'] ? 'selected' : '' ?>><?= e($c['course_code']) ?> - <?= e($c['title']) ?></option><?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-3">
        <select name="type" class="form-select" onchange="this.form.submit()">
            <option value="">كل الأنواع</option>
            <?php foreach (RESOURCE_TYPES as $k => [$l]): ?><option value="<?= $k ?>" <?= $type === $k ? 'selected' : '' ?>><?= e($l) ?></option><?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2 d-grid"><button class="btn btn-primary">بحث</button></div>
</form>
<p class="text-muted">عدد المصادر: <?= (int)$total ?></p>

<?php foreach ($grouped as $key => $items): [$code, $title] = explode('|', $key, 2); ?>
    <div class="card mb-3"><div class="card-body">
        <h2 class="h5 fw-bold"><a href="<?= url('course', ['code' => $code]) ?>" class="text-dark"><span class="badge course-badge"><?= e($code) ?></span> <?= e($title) ?></a></h2>
        <div class="d-grid gap-2">
            <?php foreach ($items as $r): $icon = RESOURCE_TYPES[$r['type']][1] ?? 'bi-link'; ?>
                <a class="res-item" href="<?= e($r['url']) ?>" target="_blank" rel="noopener noreferrer">
                    <i class="bi <?= $icon ?> res-icon"></i>
                    <div class="flex-grow-1"><div class="fw-bold"><?= e($r['title']) ?> <span class="badge bg-light text-dark border"><?= e(RESOURCE_TYPES[$r['type']][0] ?? $r['type']) ?></span></div><small class="text-muted"><?= e($r['description']) ?></small></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div></div>
<?php endforeach; ?>
<?php if (!$grouped): ?><div class="alert alert-warning">لا توجد مصادر مطابقة لبحثك.</div><?php endif; ?>

<div class="card mt-4"><div class="card-body">
    <h2 class="h5 fw-bold">➕ اقترح مصدراً جديداً</h2>
    <?php if (is_logged_in()): ?>
        <form method="post" class="row g-2">
            <?= csrf_field() ?>
            <div class="col-md-6"><select name="course_code" class="form-select" required><option value="">اختر المقرر</option>
                <?php foreach ($courseList as $c): ?><option value="<?= e($c['course_code']) ?>"><?= e($c['course_code']) ?> - <?= e($c['title']) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-6"><select class="form-select" name="type"><?php foreach (RESOURCE_TYPES as $k => [$l]): ?><option value="<?= $k ?>"><?= e($l) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-6"><input class="form-control" name="title" placeholder="عنوان المصدر" maxlength="150" required></div>
            <div class="col-md-6"><input class="form-control" type="url" name="url" placeholder="https://..." dir="ltr" required></div>
            <div class="col-12"><input class="form-control" name="description" placeholder="وصف مختصر (اختياري)" maxlength="255"></div>
            <div class="col-12"><button class="btn btn-primary">إرسال للمراجعة</button> <small class="text-muted me-2">يظهر المصدر بعد موافقة المشرف.</small></div>
        </form>
    <?php else: ?>
        <p class="mb-0"><a href="<?= url('login') ?>">سجّل الدخول</a> لاقتراح مصدر.</p>
    <?php endif; ?>
</div></div>
