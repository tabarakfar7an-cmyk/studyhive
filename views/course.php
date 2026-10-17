<nav aria-label="breadcrumb"><ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= url('courses') ?>">المقررات</a></li>
    <li class="breadcrumb-item"><a href="<?= url('courses', ['category' => $course['category']]) ?>"><?= e($course['category']) ?></a></li>
    <li class="breadcrumb-item active"><?= e($course['course_code']) ?></li>
</ol></nav>

<div class="card mb-4"><div class="card-body p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
        <div>
            <span class="badge course-badge mb-2"><?= e($course['course_code']) ?></span>
            <h1 class="h2 fw-bold"><?= e($course['title']) ?></h1>
            <p class="text-muted"><?= e($course['description']) ?></p>
        </div>
        <?php if (is_logged_in()): ?>
            <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="toggle_save">
                <button class="btn <?= $isSaved ? 'btn-warning' : 'btn-outline-dark' ?>"><i class="bi <?= $isSaved ? 'bi-bookmark-star-fill' : 'bi-bookmark-plus' ?>"></i> <?= $isSaved ? 'محفوظ' : 'احفظ المقرر' ?></button>
            </form>
        <?php endif; ?>
    </div>
    <h2 class="h5 fw-bold mt-3">🗺️ الخطة المقترحة</h2>
    <?php
        $steps = preg_split('/\s*\d+\.\s*/u', preg_replace('/^خطة مقترحة:\s*/u', '', $course['plan']), -1, PREG_SPLIT_NO_EMPTY);
    ?>
    <?php if (count($steps) > 1): ?>
        <ol><?php foreach ($steps as $s): ?><li><?= e(trim($s)) ?></li><?php endforeach; ?></ol>
    <?php else: ?><p><?= e($course['plan']) ?></p><?php endif; ?>
</div></div>

<h2 class="section-title">📖 مصادر الدراسة (<?= (int)$resCount ?>)</h2>
<?php foreach ($grouped as $type => $items): [$label, $icon] = RESOURCE_TYPES[$type] ?? [$type, 'bi-link']; ?>
    <h3 class="h6 fw-bold text-muted mt-3"><i class="bi <?= $icon ?>"></i> <?= e($label) ?></h3>
    <div class="d-grid gap-2">
        <?php foreach ($items as $r): ?>
            <a class="res-item" href="<?= e($r['url']) ?>" target="_blank" rel="noopener noreferrer">
                <i class="bi <?= $icon ?> res-icon"></i>
                <div class="flex-grow-1"><div class="fw-bold"><?= e($r['title']) ?> <i class="bi bi-box-arrow-up-left small text-muted"></i></div><small class="text-muted"><?= e($r['description']) ?></small></div>
            </a>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
<?php if (!$grouped): ?><div class="alert alert-info">لا توجد مصادر لهذا المقرر بعد. كن أول من يقترح مصدراً!</div><?php endif; ?>

<div class="card mt-4"><div class="card-body">
    <h3 class="h5 fw-bold">➕ اقترح مصدراً لهذا المقرر</h3>
    <?php if (is_logged_in()): ?>
        <form method="post" class="row g-2">
            <?= csrf_field() ?><input type="hidden" name="action" value="suggest">
            <div class="col-md-5"><input class="form-control" name="title" placeholder="عنوان المصدر" maxlength="150" required></div>
            <div class="col-md-5"><input class="form-control" type="url" name="url" placeholder="https://..." required dir="ltr"></div>
            <div class="col-md-2"><select class="form-select" name="type"><?php foreach (RESOURCE_TYPES as $k => [$l]): ?><option value="<?= $k ?>"><?= e($l) ?></option><?php endforeach; ?></select></div>
            <div class="col-12"><input class="form-control" name="description" placeholder="وصف مختصر (اختياري)" maxlength="255"></div>
            <div class="col-12"><button class="btn btn-primary">إرسال للمراجعة</button></div>
        </form>
    <?php else: ?>
        <p class="mb-0"><a href="<?= url('login') ?>">سجّل الدخول</a> لتقترح مصدراً أو تحفظ المقرر.</p>
    <?php endif; ?>
</div></div>

<?php if ($related): ?>
<h2 class="section-title mt-5">🔗 مقررات ذات صلة</h2>
<div class="row g-3">
    <?php foreach ($related as $c): ?>
        <div class="col-md-6 col-lg-3"><a class="card card-hover h-100 text-dark" href="<?= url('course', ['code' => $c['course_code']]) ?>"><div class="card-body"><span class="badge course-badge mb-1"><?= e($c['course_code']) ?></span><div class="fw-bold"><?= e($c['title']) ?></div></div></a></div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
