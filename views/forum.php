<h1 class="h2 fw-bold mb-3">💬 منتدى النقاش الطلابي</h1>

<div class="card mb-4"><div class="card-body">
    <h2 class="h5 fw-bold">موضوع جديد</h2>
    <form method="post">
        <?= csrf_field() ?><input type="hidden" name="action" value="post">
        <div class="mb-3"><label class="form-label" for="topicTitle">عنوان الموضوع</label>
            <input class="form-control" id="topicTitle" name="title" maxlength="120" required placeholder="أدخل عنوان الموضوع"></div>
        <div class="mb-1"><label class="form-label" for="topicContent">المحتوى</label>
            <textarea class="form-control" id="topicContent" name="content" rows="4" maxlength="2000" minlength="5" required data-counter="cnt1" placeholder="اكتب هنا..."></textarea></div>
        <div class="text-muted small mb-3" id="cnt1"></div>
        <button class="btn btn-primary">نشر الموضوع</button>
    </form>
</div></div>

<div class="mb-3"><input type="search" class="form-control" placeholder="ابحث في المواضيع..." data-filter-input=".forum-item"></div>

<?php foreach ($posts as $p): ?>
    <div class="card forum-post mb-3 forum-item" id="post-<?= (int)$p['id'] ?>"><div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="h5 fw-bold mb-1"><?= e($p['title']) ?></h3>
                <small class="text-muted"><i class="bi bi-person"></i> <?= e($p['username']) ?> · <?= e(time_ago($p['created_at'])) ?> · <?= (int)$p['reply_count'] ?> ردود</small>
            </div>
            <?php if ((int)$p['user_id'] === (int)current_user()['id'] || is_admin()): ?>
                <form method="post" data-confirm="هل تريد حذف هذا الموضوع وجميع ردوده؟"><?= csrf_field() ?>
                    <input type="hidden" name="action" value="delete"><input type="hidden" name="post_id" value="<?= (int)$p['id'] ?>">
                    <button class="btn btn-sm btn-outline-danger" title="حذف"><i class="bi bi-trash"></i></button>
                </form>
            <?php endif; ?>
        </div>
        <p class="mt-2 mb-2" style="white-space:pre-line"><?= e($p['content']) ?></p>

        <?php foreach ($p['replies'] as $r): ?>
            <div class="reply"><div style="white-space:pre-line"><?= e($r['content']) ?></div><small class="text-muted"><?= e($r['username']) ?> · <?= e(time_ago($r['created_at'])) ?></small></div>
        <?php endforeach; ?>

        <form method="post" class="mt-3 d-flex gap-2">
            <?= csrf_field() ?><input type="hidden" name="action" value="reply"><input type="hidden" name="post_id" value="<?= (int)$p['id'] ?>">
            <input class="form-control form-control-sm" name="content" maxlength="1000" minlength="2" required placeholder="أضف ردك هنا...">
            <button class="btn btn-sm btn-secondary text-nowrap">نشر الرد</button>
        </form>
    </div></div>
<?php endforeach; ?>
<?php if (!$posts): ?><div class="alert alert-info">لا توجد مواضيع بعد. كن أول من يبدأ نقاشاً!</div><?php endif; ?>
