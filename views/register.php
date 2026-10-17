<div class="auth-wrap">
    <div class="card auth-card p-4">
        <div class="text-center mb-3">
            <a href="<?= url('landingpage') ?>"><img src="assets/img/logo.png" alt="StudyHive" height="80"></a>
            <h2 class="h4 fw-bold mt-2">تسجيل حساب جديد</h2>
        </div>
        <?php if ($error): ?><div class="alert alert-danger py-2"><?= e($error) ?></div><?php endif; ?>
        <form method="post" action="<?= url('register') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="username" class="form-label">اسم المستخدم</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= e($old['username']) ?>" minlength="3" maxlength="30" required autocomplete="username">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= e($old['email']) ?>" required autocomplete="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور <small class="text-muted">(8 أحرف على الأقل)</small></label>
                <input type="password" class="form-control" id="password" name="password" minlength="8" required autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="password2" class="form-label">تأكيد كلمة المرور</label>
                <input type="password" class="form-control" id="password2" name="password2" minlength="8" required autocomplete="new-password">
            </div>
            <button class="btn btn-primary w-100" type="submit">تسجيل</button>
        </form>
        <p class="text-center mt-3 mb-0">هل لديك حساب؟ <a href="<?= url('login') ?>" class="fw-bold">سجّل الدخول</a></p>
    </div>
</div>
