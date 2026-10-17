<?php
require_once __DIR__ . '/ProfileController.php';

class AuthController
{
    private User $users;
    public function __construct(PDO $db) { $this->users = new User($db); }

    private function start(array $u): void {
        session_regenerate_id(true);
        $_SESSION['user'] = ProfileController::sessionUser($u);
    }

    public function index(): void { $this->login(); }

    public function login(): void {
        if (is_logged_in()) redirect('home');
        $error = ''; $email = '';
        if (is_post()) {
            verify_csrf();
            $email = trim($_POST['email'] ?? '');
            $u = $this->users->login($email, $_POST['password'] ?? '');
            if ($u) {
                $this->start($u);
                flash('success', 'مرحباً بعودتك، ' . $u['username'] . '!');
                redirect('home');
            }
            $error = 'البريد الإلكتروني أو كلمة المرور غير صحيحة.';
        }
        render('login', ['error' => $error, 'email' => $email], ['title' => 'تسجيل الدخول', 'bare' => true]);
    }

    public function register(): void {
        if (is_logged_in()) redirect('home');
        $error = ''; $old = ['username' => '', 'email' => ''];
        if (is_post()) {
            verify_csrf();
            $old = ['username' => trim($_POST['username'] ?? ''), 'email' => trim($_POST['email'] ?? '')];
            if (($_POST['password'] ?? '') !== ($_POST['password2'] ?? '')) {
                $error = 'كلمتا المرور غير متطابقتين.';
            } else {
                $res = $this->users->register($old['username'], $old['email'], $_POST['password'] ?? '');
                if (is_int($res)) {
                    $this->start($this->users->findById($res));
                    flash('success', 'أهلاً وسهلاً بك في StudyHive، ' . $old['username'] . '!');
                    redirect('home');
                }
                $error = $res;
            }
        }
        render('register', ['error' => $error, 'old' => $old], ['title' => 'إنشاء حساب', 'bare' => true]);
    }

    public function logout(): void {
        $_SESSION = [];
        session_destroy();
        session_start();
        flash('success', 'تم تسجيل الخروج بنجاح.');
        redirect('landingpage');
    }
}
