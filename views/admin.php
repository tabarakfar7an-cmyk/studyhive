<h1 class="h2 fw-bold mb-3">⚙️ لوحة الإدارة</h1>
<div class="row g-3 mb-4 text-center">
    <?php foreach ([['users','طالباً'],['courses','مقرراً'],['resources','مصدراً'],['open','طلب دعم مفتوح']] as [$k,$l]): ?>
        <div class="col-6 col-md-3"><div class="stat-box"><div class="num"><?= (int)$stats[$k] ?></div><?= $l ?></div></div>
    <?php endforeach; ?>
</div>

<ul class="nav nav-pills mb-3">
    <?php foreach (['courses' => 'المقررات', 'resources' => 'المصادر', 'pending' => 'اقتراحات بانتظار الموافقة (' . count($pending) . ')', 'support' => 'طلبات الدعم'] as $k => $l): ?>
        <li class="nav-item"><a class="nav-link <?= $tab === $k ? 'active bg-dark' : 'text-dark' ?>" href="<?= url('admin', ['tab' => $k]) ?>"><?= e($l) ?></a></li>
    <?php endforeach; ?>
</ul>

<?php if ($tab === 'courses'): ?>
    <div class="card mb-3"><div class="card-body">
        <h2 class="h5 fw-bold"><?= $edit ? 'تعديل المقرر ' . e($edit['course_code']) : 'إضافة مقرر جديد' ?></h2>
        <form method="post" class="row g-2"><?= csrf_field() ?>
            <input type="hidden" name="action" value="save_course"><input type="hidden" name="tab" value="courses"><input type="hidden" name="mode" value="<?= $edit ? 'edit' : 'new' ?>">
            <div class="col-md-3"><input class="form-control" name="course_code" placeholder="رمز المقرر" maxlength="30" required value="<?= e($edit['course_code'] ?? '') ?>" <?= $edit ? 'readonly' : '' ?>></div>
            <div class="col-md-5"><input class="form-control" name="title" placeholder="اسم المقرر" maxlength="100" required value="<?= e($edit['title'] ?? '') ?>"></div>
            <div class="col-md-4"><input class="form-control" name="category" placeholder="التصنيف" list="cats" maxlength="100" required value="<?= e($edit['category'] ?? '') ?>">
                <datalist id="cats"><?php foreach (array_unique(array_column($courseList, 'category')) as $c): ?><option value="<?= e($c) ?>"><?php endforeach; ?></datalist></div>
            <div class="col-12"><input class="form-control" name="description" placeholder="الوصف" maxlength="255" required value="<?= e($edit['description'] ?? '') ?>"></div>
            <div class="col-12"><textarea class="form-control" name="plan" rows="2" placeholder="الخطة المقترحة (مثال: 1. ... 2. ... 3. ...)" required><?= e($edit['plan'] ?? '') ?></textarea></div>
            <div class="col-12 d-flex align-items-center gap-3">
                <div class="form-check"><input class="form-check-input" type="checkbox" name="featured" id="feat" value="1" <?= !empty($edit['featured']) ? 'checked' : '' ?>><label class="form-check-label" for="feat">مقرر مميز (يظهر في الرئيسية)</label></div>
                <button class="btn btn-primary">حفظ</button>
                <?php if ($edit): ?><a href="<?= url('admin') ?>" class="btn btn-outline-secondary">إلغاء</a><?php endif; ?>
            </div>
        </form>
    </div></div>
    <div class="table-responsive"><table class="table table-striped align-middle bg-white">
        <thead class="table-dark"><tr><th>الرمز</th><th>الاسم</th><th>التصنيف</th><th>مميز</th><th>إجراءات</th></tr></thead>
        <tbody>
        <?php foreach ($courseList as $c): ?>
            <tr><td><?= e($c['course_code']) ?></td><td><?= e($c['title']) ?></td><td><?= e($c['category']) ?></td><td><?= $c['featured'] ? '⭐' : '' ?></td>
                <td class="text-nowrap">
                    <a class="btn btn-sm btn-outline-primary" href="<?= url('admin', ['tab' => 'courses', 'edit' => $c['course_code']]) ?>">تعديل</a>
                    <form method="post" class="d-inline" data-confirm="حذف المقرر <?= e($c['course_code']) ?> وكل مصادره؟"><?= csrf_field() ?><input type="hidden" name="action" value="delete_course"><input type="hidden" name="tab" value="courses"><input type="hidden" name="course_code" value="<?= e($c['course_code']) ?>"><button class="btn btn-sm btn-outline-danger">حذف</button></form>
                </td></tr>
        <?php endforeach; ?>
        </tbody></table></div>

<?php elseif ($tab === 'resources'): ?>
    <div class="card mb-3"><div class="card-body">
        <h2 class="h5 fw-bold">إضافة مصدر</h2>
        <form method="post" class="row g-2"><?= csrf_field() ?><input type="hidden" name="action" value="add_resource"><input type="hidden" name="tab" value="resources">
            <div class="col-md-4"><select name="course_code" class="form-select" required><option value="">المقرر</option><?php foreach ($courseList as $c): ?><option value="<?= e($c['course_code']) ?>"><?= e($c['course_code']) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-4"><input class="form-control" name="title" placeholder="العنوان" required></div>
            <div class="col-md-4"><select class="form-select" name="type"><?php foreach (RESOURCE_TYPES as $k => [$l]): ?><option value="<?= $k ?>"><?= e($l) ?></option><?php endforeach; ?></select></div>
            <div class="col-md-6"><input class="form-control" type="url" name="url" placeholder="https://..." dir="ltr" required></div>
            <div class="col-md-6"><input class="form-control" name="description" placeholder="الوصف (اختياري)"></div>
            <div class="col-12"><button class="btn btn-primary">إضافة</button></div>
        </form>
    </div></div>
    <input type="search" class="form-control mb-2" placeholder="تصفية..." data-filter-input=".res-row">
    <div class="table-responsive"><table class="table table-striped align-middle bg-white">
        <thead class="table-dark"><tr><th>المقرر</th><th>العنوان</th><th>النوع</th><th></th></tr></thead><tbody>
        <?php foreach ($allResources as $r): ?>
            <tr class="res-row"><td><?= e($r['course_code']) ?></td><td><a href="<?= e($r['url']) ?>" target="_blank" rel="noopener noreferrer"><?= e($r['title']) ?></a></td><td><?= e(RESOURCE_TYPES[$r['type']][0] ?? $r['type']) ?></td>
                <td><form method="post" data-confirm="حذف هذا المصدر؟"><?= csrf_field() ?><input type="hidden" name="action" value="delete_resource"><input type="hidden" name="tab" value="resources"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><button class="btn btn-sm btn-outline-danger">حذف</button></form></td></tr>
        <?php endforeach; ?></tbody></table></div>

<?php elseif ($tab === 'pending'): ?>
    <?php if (!$pending): ?><div class="alert alert-info">لا توجد اقتراحات بانتظار المراجعة.</div><?php endif; ?>
    <?php foreach ($pending as $r): ?>
        <div class="card mb-2"><div class="card-body d-flex flex-wrap justify-content-between gap-2">
            <div><span class="badge course-badge"><?= e($r['course_code']) ?></span> <b><?= e($r['title']) ?></b>
                <div><a href="<?= e($r['url']) ?>" target="_blank" rel="noopener noreferrer" dir="ltr"><?= e($r['url']) ?></a></div>
                <small class="text-muted"><?= e($r['description']) ?> · اقترحه: <?= e($r['username'] ?? '—') ?></small></div>
            <form method="post" class="d-flex gap-2 align-items-start"><?= csrf_field() ?><input type="hidden" name="tab" value="pending"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                <button name="action" value="approve" class="btn btn-sm btn-success">موافقة</button>
                <button name="action" value="reject" class="btn btn-sm btn-outline-danger">رفض</button></form>
        </div></div>
    <?php endforeach; ?>

<?php else: ?>
    <?php if (!$requests): ?><div class="alert alert-info">لا توجد طلبات دعم.</div><?php endif; ?>
    <?php foreach ($requests as $q): ?>
        <div class="card mb-2"><div class="card-body d-flex justify-content-between gap-2">
            <div><b><?= e($q['topic']) ?></b> <span class="badge <?= $q['status'] === 'open' ? 'bg-warning text-dark' : 'bg-success' ?>"><?= $q['status'] === 'open' ? 'مفتوح' : 'منتهي' ?></span>
                <p class="mb-1" style="white-space:pre-line"><?= e($q['message']) ?></p>
                <small class="text-muted"><?= e($q['name']) ?> · <a href="mailto:<?= e($q['email']) ?>"><?= e($q['email']) ?></a> · <?= e(time_ago($q['created_at'])) ?></small></div>
            <?php if ($q['status'] === 'open'): ?>
                <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="resolve"><input type="hidden" name="tab" value="support"><input type="hidden" name="id" value="<?= (int)$q['id'] ?>"><button class="btn btn-sm btn-outline-success text-nowrap">تم الحل</button></form>
            <?php endif; ?>
        </div></div>
    <?php endforeach; ?>
<?php endif; ?>
