<?php
// مثبّت قاعدة البيانات: يستورد studyhive.sql (يستبدل الجداول القديمة). احذف هذا الملف بعد التثبيت.
$msg = ''; $ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dsn  = getenv('DB_DSN') ?: 'mysql:host=' . (getenv('DB_HOST') ?: 'localhost') . ';charset=utf8mb4';
        $user = getenv('DB_USER') !== false ? getenv('DB_USER') : 'root';
        $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $pdo->exec(file_get_contents(__DIR__ . '/studyhive.sql'));
        $ok = true; $msg = 'تم التثبيت بنجاح. احذف الملف install.php الآن.';
    } catch (Throwable $e) {
        $msg = 'فشل التثبيت: ' . $e->getMessage();
    }
}
?><!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>تثبيت StudyHive</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet"></head>
<body class="bg-light"><div class="container py-5" style="max-width:560px"><div class="card p-4">
<h1 class="h4">تثبيت قاعدة بيانات StudyHive</h1>
<?php if ($msg): ?><div class="alert alert-<?= $ok ? 'success' : 'danger' ?>"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<?php if ($ok): ?><a class="btn btn-warning" href="index.php">فتح الموقع</a>
<?php else: ?>
<p class="text-danger">تنبيه: سيتم حذف الجداول القديمة (users, courses, resources, forum...) وإنشاء الجديدة. المستخدم الافتراضي: root بدون كلمة مرور (عدّل <code>models/Database.php</code> إن كان مختلفاً).</p>
<form method="post"><button class="btn btn-dark">تثبيت الآن</button></form>
<?php endif; ?></div></div></body></html>
