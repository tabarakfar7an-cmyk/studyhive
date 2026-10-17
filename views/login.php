<div class="auth-wrap">
    <div class="card auth-card p-4">
        <div class="text-center mb-3">
            <a href="<?= url('landingpage') ?>"><img src="assets/img/logo.png" alt="StudyHive" height="80"></a>
            <h2 class="h4 fw-bold mt-2">تسجيل الدخول</h2>
        </div>
        <?php if ($error): ?><div class="alert alert-danger py-2"><?= e($error) ?></div><?php endif; ?>
        <form method="post" action="<?= url('login') ?>" novalidate>
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= e($email) ?>" required autofocus autocomplete="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
            </div>
            <button class="btn btn-primary w-100" type="submit">دخول</button>
        </form>
        <p class="text-center mt-3 mb-0">ليس لديك حساب؟ <a href="<?= url('register') ?>" class="fw-bold">إنشاء حساب جديد</a></p>
    </div>
</div>
