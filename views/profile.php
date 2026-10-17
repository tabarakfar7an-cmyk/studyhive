<div class="row g-4">
    <div class="col-lg-4">
        <div class="card text-center"><div class="card-body p-4">
            <img src="assets/img/profile-icon.png" alt="" class="rounded-circle mb-3" width="110" height="110" style="object-fit:cover">
            <h1 class="h4 fw-bold mb-0"><?= e($u['username']) ?></h1>
            <p class="text-muted mb-1"><?= e($u['email']) ?></p>
            <p><span class="badge course-badge"><?= e($u['major']) ?></span> <?php if ($u['role'] === 'admin'): ?><span class="badge bg-dark">مشرف</span><?php endif; ?></p>
            <a href="<?= url('logout') ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-left"></i> تسجيل الخروج</a>
        </div></div>
    </div>
    <div class="col-lg-8">
        <div class="card mb-3"><div class="card-body">
            <h2 class="h5 fw-bold">🔖 المقررات المحفوظة (<?= count($saved) ?>)</h2>
            <?php if ($saved): ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($saved as $c): ?><li class="list-group-item"><a href="<?= url('course', ['code' => $c['course_code']]) ?>"><span class="badge course-badge"><?= e($c['course_code']) ?></span> <?= e($c['title']) ?></a></li><?php endforeach; ?>
                </ul>
            <?php else: ?><p class="text-muted mb-0">لم تحفظ أي مقرر بعد. <a href="<?= url('courses') ?>">تصفح المقررات</a></p><?php endif; ?>
        </div></div>

        <div class="card mb-3"><div class="card-body">
            <h2 class="h5 fw-bold">📝 منشوراتي (<?= count($posts) ?>)</h2>
            <?php if ($posts): ?>
                <ul class="list-group list-group-flush"><?php foreach ($posts as $p): ?><li class="list-group-item"><a href="<?= url('forum') ?>#post-<?= (int)$p['id'] ?>"><?= e($p['title']) ?></a> <small class="text-muted">· <?= e(time_ago($p['created_at'])) ?></small></li><?php endforeach; ?></ul>
            <?php else: ?><p class="text-muted mb-0">لا توجد منشورات بعد. <a href="<?= url('forum') ?>">شارك في المنتدى</a></p><?php endif; ?>
        </div></div>

        <div class="card mb-3"><div class="card-body">
            <h2 class="h5 fw-bold">✏️ تعديل المعلومات</h2>
            <form method="post" class="row g-2"><?= csrf_field() ?><input type="hidden" name="action" value="profile">
                <div class="col-md-6"><label class="form-label">اسم المستخدم</label><input class="form-control" name="username" value="<?= e($u['username']) ?>" minlength="3" maxlength="30" required></div>
                <div class="col-md-6"><label class="form-label">التخصص</label><input class="form-control" name="major" value="<?= e($u['major']) ?>" maxlength="60"></div>
                <div class="col-12"><button class="btn btn-primary">حفظ</button></div>
            </form>
        </div></div>

        <div class="card"><div class="card-body">
            <h2 class="h5 fw-bold">🔒 تغيير كلمة المرور</h2>
            <form method="post" class="row g-2"><?= csrf_field() ?><input type="hidden" name="action" value="password">
                <div class="col-md-6"><label class="form-label">الحالية</label><input type="password" class="form-control" name="old" required autocomplete="current-password"></div>
                <div class="col-md-6"><label class="form-label">الجديدة (8 أحرف على الأقل)</label><input type="password" class="form-control" name="new" minlength="8" required autocomplete="new-password"></div>
                <div class="col-12"><button class="btn btn-primary">تغيير</button></div>
            </form>
        </div></div>
    </div>
</div>
