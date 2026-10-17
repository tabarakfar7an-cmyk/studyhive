<section class="hero">
    <div class="container py-5">
        <img src="assets/img/logo.png" alt="StudyHive" height="110" class="mb-3">
        <h1>مرحبًا بك في StudyHive</h1>
        <p class="lead mb-4">منصتك الشاملة لطلاب هندسة الحاسوب في جامعة اليرموك: مقررات، مصادر مجانية موثوقة، ومجتمع طلابي.</p>
        <a href="<?= url('courseland') ?>" class="btn btn-warning btn-lg px-4 fw-bold">تصفح المقررات</a>
        <a href="<?= url('register') ?>" class="btn btn-outline-light btn-lg px-4">إنشاء حساب</a>
        <div class="mt-3"><a href="<?= url('login') ?>" class="text-white-50">لديك حساب؟ سجّل الدخول</a></div>
    </div>
</section>

<section class="container py-5">
    <h2 class="section-title">🐝 لماذا StudyHive؟</h2>
    <div class="row g-4 text-center">
        <?php foreach ([
            ['bi-search', 'سهولة البحث', 'ابحث عن أي مقرر أو مصدر بسرعة وصفِّ النتائج حسب التصنيف أو النوع.'],
            ['bi-journal-bookmark', 'مصادر موثوقة', 'روابط مجانية مختارة من MIT وKhan Academy وOpenStax وغيرها لكل مقرر.'],
            ['bi-people', 'مجتمع طلابي', 'اسأل زملاءك في المنتدى وشاركهم خبراتك واقتراحاتك.'],
            ['bi-bookmark-star', 'احفظ مقرراتك', 'أنشئ حساباً واحفظ مقرراتك لتجدها بسرعة في ملفك الشخصي.'],
            ['bi-plus-circle', 'أضف مصادرك', 'اقترح مصدراً أعجبك ليضيفه المشرفون ويستفيد منه الجميع.'],
            ['bi-headset', 'دعم مباشر', 'لديك مشكلة أو اقتراح؟ أرسل طلب دعم وسنتابعه معك.'],
        ] as [$icon, $t, $d]): ?>
            <div class="col-md-4">
                <div class="feature-icon mb-3"><i class="bi <?= $icon ?>"></i></div>
                <h5 class="fw-bold"><?= $t ?></h5>
                <p class="text-muted"><?= $d ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-5 p-5 rounded-4" style="background:var(--cream)">
        <h2 class="fw-bold">🤝 انضم إلينا الآن!</h2>
        <p>كن جزءاً من مجتمع StudyHive وساهم في إثراء المحتوى الأكاديمي.</p>
        <a href="<?= url('register') ?>" class="btn btn-primary btn-lg">إنشاء حساب مجاني</a>
    </div>
</section>
