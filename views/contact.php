<?php $v = fn($k, $d = '') => e($old[$k] ?? $d); ?>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card"><div class="card-body p-4">
            <h1 class="h3 fw-bold mb-3">📞 دعم الطلاب</h1>
            <form method="post">
                <?= csrf_field() ?>
                <div class="mb-3"><label class="form-label" for="studentName">الاسم الكامل</label>
                    <input class="form-control" id="studentName" name="name" maxlength="60" required value="<?= $v('name', $user['username'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label" for="studentEmail">البريد الإلكتروني</label>
                    <input type="email" class="form-control" id="studentEmail" name="email" required value="<?= $v('email', $user['email'] ?? '') ?>"></div>
                <div class="mb-3"><label class="form-label" for="supportTopic">موضوع الاستفسار</label>
                    <input class="form-control" id="supportTopic" name="topic" maxlength="100" required value="<?= $v('topic') ?>"></div>
                <div class="mb-1"><label class="form-label" for="supportMessage">الرسالة</label>
                    <textarea class="form-control" id="supportMessage" name="message" rows="5" minlength="10" maxlength="1500" required data-counter="cnt2"><?= $v('message') ?></textarea></div>
                <div class="text-muted small mb-3" id="cnt2"></div>
                <button class="btn btn-primary">إرسال الطلب</button>
            </form>
        </div></div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3"><div class="card-body">
            <h2 class="h5 fw-bold">معلومات الاتصال المباشر</h2>
            <p class="mb-1"><i class="bi bi-envelope"></i> <a href="mailto:support@studyhive.com">support@studyhive.com</a></p>
            <p class="mb-1"><i class="bi bi-telephone"></i> <span dir="ltr">+962-6-123-4567</span></p>
            <p class="mb-0"><i class="bi bi-geo-alt"></i> جامعة اليرموك، إربد - الأردن</p>
        </div></div>
        <div class="card"><div class="card-body">
            <h2 class="h5 fw-bold">❓ أسئلة شائعة</h2>
            <div class="accordion accordion-flush" id="faq">
                <?php foreach ([
                    ['كيف أحفظ مقرراً؟', 'افتح صفحة المقرر واضغط «احفظ المقرر»، وستجده في ملفك الشخصي.'],
                    ['كيف أضيف مصدراً دراسياً؟', 'من صفحة «موارد الدراسة» أو صفحة المقرر استخدم نموذج «اقترح مصدراً». يظهر بعد موافقة المشرف.'],
                    ['نسيت كلمة المرور، ماذا أفعل؟', 'أرسل طلب دعم من هذه الصفحة بالبريد المسجّل لدينا وسنساعدك في استعادة الوصول.'],
                    ['هل الموقع مجاني؟', 'نعم، والمصادر المرتبطة مجانية أو مفتوحة المصدر.'],
                ] as $i => [$q, $a]): ?>
                    <div class="accordion-item"><h3 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f<?= $i ?>"><?= e($q) ?></button></h3>
                        <div id="f<?= $i ?>" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body"><?= e($a) ?></div></div></div>
                <?php endforeach; ?>
            </div>
        </div></div>
    </div>
</div>
