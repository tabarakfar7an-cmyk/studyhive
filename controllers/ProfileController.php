<?php
class ProfileController
{
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function index(): void {
        require_login();
        $users = new User($this->db);
        $id = (int)current_user()['id'];
        if (is_post()) {
            verify_csrf();
            if (($_POST['action'] ?? '') === 'profile') {
                $err = $users->updateProfile($id, trim($_POST['username'] ?? ''), trim($_POST['major'] ?? ''));
                if ($err) flash('danger', $err);
                else { $_SESSION['user'] = $this->sessionUser($users->findById($id)); flash('success', 'تم تحديث معلوماتك.'); }
            } elseif (($_POST['action'] ?? '') === 'password') {
                $err = $users->changePassword($id, $_POST['old'] ?? '', $_POST['new'] ?? '');
                $err ? flash('danger', $err) : flash('success', 'تم تغيير كلمة المرور.');
            }
            redirect('profile');
        }
        $u = $users->findById($id);
        render('profile', [
            'u' => $u,
            'saved' => (new Course($this->db))->savedCourses($id),
            'posts' => (new Forum($this->db))->byUser($id),
        ], ['title' => 'الملف الشخصي - StudyHive']);
    }

    public static function sessionUser(array $u): array {
        return ['id' => (int)$u['id'], 'username' => $u['username'], 'email' => $u['email'], 'role' => $u['role']];
    }
}
