<?php
class ContactController
{
    private Support $support;
    public function __construct(PDO $db) { $this->support = new Support($db); }

    public function index(): void {
        $u = current_user();
        if (is_post()) {
            verify_csrf();
            $err = $this->support->add($u['id'] ?? null, $_POST['name'] ?? '', $_POST['email'] ?? '', $_POST['topic'] ?? '', $_POST['message'] ?? '');
            if ($err) {
                flash('danger', $err);
                $_SESSION['old'] = $_POST;
            } else {
                flash('success', 'وصلنا طلبك، وسنرد عليك على بريدك الإلكتروني في أقرب وقت.');
            }
            redirect('contact');
        }
        $old = $_SESSION['old'] ?? []; unset($_SESSION['old']);
        render('contact', ['old' => $old, 'user' => $u], ['title' => 'الدعم - StudyHive']);
    }
}
