<?php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
    session_start();
}

function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function url(string $page, array $params = []): string {
    return 'index.php?' . http_build_query(['page' => $page] + $params);
}

function redirect(string $page, array $params = []): void {
    header('Location: ' . url($page, $params));
    exit;
}

function current_user(): ?array { return $_SESSION['user'] ?? null; }
function is_logged_in(): bool { return current_user() !== null; }
function is_admin(): bool { return (current_user()['role'] ?? '') === 'admin'; }

function require_login(): void {
    if (!is_logged_in()) {
        flash('warning', 'يرجى تسجيل الدخول أولاً للوصول إلى هذه الصفحة.');
        redirect('login');
    }
}
function require_admin(): void {
    require_login();
    if (!is_admin()) {
        http_response_code(403);
        render('403', [], ['title' => 'غير مصرّح']);
        exit;
    }
}

function flash(string $type, string $msg): void { $_SESSION['flash'][] = [$type, $msg]; }
function pull_flash(): array { $f = $_SESSION['flash'] ?? []; unset($_SESSION['flash']); return $f; }

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(32)); }
    return $_SESSION['csrf'];
}
function csrf_field(): string { return '<input type="hidden" name="csrf" value="' . csrf_token() . '">'; }
function verify_csrf(): void {
    if (empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''))) {
        http_response_code(400);
        exit('طلب غير صالح (CSRF). أعد تحميل الصفحة وحاول مجدداً.');
    }
}
function is_post(): bool { return $_SERVER['REQUEST_METHOD'] === 'POST'; }

function time_ago(string $datetime): string {
    $diff = time() - strtotime($datetime . ' UTC');
    if ($diff < 60) return 'الآن';
    if ($diff < 3600) return 'قبل ' . floor($diff / 60) . ' دقيقة';
    if ($diff < 86400) return 'قبل ' . floor($diff / 3600) . ' ساعة';
    if ($diff < 2592000) return 'قبل ' . floor($diff / 86400) . ' يوم';
    return date('Y-m-d', strtotime($datetime));
}

function safe_url(string $u): bool {
    return (bool)filter_var($u, FILTER_VALIDATE_URL) && preg_match('#^https?://#i', $u);
}

const RESOURCE_TYPES = [
    'book' => ['كتاب / ملاحظات', 'bi-book'],
    'video' => ['فيديو', 'bi-play-circle'],
    'course' => ['مقرر مفتوح', 'bi-mortarboard'],
    'docs' => ['توثيق', 'bi-file-earmark-text'],
    'practice' => ['تمارين وتطبيق', 'bi-pencil-square'],
];

/** يعرض صفحة داخل القالب العام. opts: title, bare (بدون شريط التنقل) */
function render(string $view, array $data = [], array $opts = []): void {
    extract($data);
    $pageTitle = $opts['title'] ?? 'StudyHive';
    $bare = $opts['bare'] ?? false;
    include __DIR__ . '/../views/header.php';
    include __DIR__ . '/../views/' . $view . '.php';
    include __DIR__ . '/../views/footer.php';
}
