<div class="p-4 p-md-5 mb-4 rounded-4" style="background:linear-gradient(135deg,#fff3cd,#ffe08a)">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="fw-bold">أهلاً <?= e($user['username']) ?> 👋</h1>
            <p class="lead mb-3">ابحث عن مقررك وابدأ بمصادر دراسية مجانية مختارة.</p>
            <form action="index.php" method="get" class="d-flex gap-2">
                <input type="hidden" name="page" value="courses">
                <input type="search" name="q" class="form-control form-control-lg" placeholder="مثال: Data Structures أو CPE 460">
                <button class="btn btn-dark btn-lg" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>
        <div class="col-md-4 text-center d-none d-md-block"><img src="assets/img/bee.png" alt="" height="150"></div>
    </div>
</div>

<div class="row g-3 mb-4 text-center">
    <div class="col-4"><div class="stat-box"><div class="num"><?= (int)$stats['courses'] ?></div>مقرراً</div></div>
    <div class="col-4"><div class="stat-box"><div class="num"><?= (int)$stats['resources'] ?></div>مصدراً</div></div>
    <div class="col-4"><a href="<?= url('profile') ?>" class="text-dark"><div class="stat-box"><div class="num"><?= (int)$savedCount ?></div>مقرر محفوظ</div></a></div>
</div>

<h2 class="section-title">⭐ المقررات المميزة</h2>
<div class="row g-3 mb-5">
    <?php foreach ($featured as $c): ?>
        <div class="col-md-4">
            <a href="<?= url('course', ['code' => $c['course_code']]) ?>" class="card card-hover h-100 text-dark">
                <div class="card-body">
                    <span class="badge course-badge mb-2"><?= e($c['course_code']) ?></span>
                    <h5 class="fw-bold"><?= e($c['title']) ?></h5>
                    <p class="text-muted mb-0"><?= e($c['description']) ?></p>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<h2 class="section-title">📂 التصنيفات</h2>
<div class="d-flex flex-wrap gap-2 mb-5">
    <?php foreach ($categories as $cat): ?>
        <a class="category-chip" href="<?= url('courses', ['category' => $cat['name']]) ?>"><?= e($cat['name']) ?> <span class="badge rounded-pill"><?= (int)$cat['n'] ?></span></a>
    <?php endforeach; ?>
</div>

<div class="d-flex justify-content-between align-items-center">
    <h2 class="section-title">💬 آخر نقاشات المنتدى</h2>
    <a href="<?= url('forum') ?>" class="btn btn-sm btn-outline-dark mb-3">كل المواضيع</a>
</div>
<div class="list-group mb-4">
    <?php foreach ($latestPosts as $p): ?>
        <a href="<?= url('forum') ?>#post-<?= (int)$p['id'] ?>" class="list-group-item list-group-item-action">
            <div class="fw-bold"><?= e($p['title']) ?></div>
            <small class="text-muted"><?= e($p['username']) ?> · <?= e(time_ago($p['created_at'])) ?></small>
        </a>
    <?php endforeach; ?>
    <?php if (!$latestPosts): ?><div class="list-group-item text-muted">لا توجد مواضيع بعد. كن أول من يبدأ نقاشاً!</div><?php endif; ?>
</div>
