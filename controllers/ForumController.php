<?php
class ForumController
{
    private Forum $forum;
    public function __construct(PDO $db) { $this->forum = new Forum($db); }

    public function index(): void {
        require_login();
        if (is_post()) {
            verify_csrf();
            $user = current_user();
            $uid = (int)$user['id'];
            switch ($_POST['action'] ?? '') {
                case 'post':
                    $err = $this->forum->addPost($uid, $_POST['title'] ?? '', $_POST['content'] ?? '');
                    $err ? flash('danger', $err) : flash('success', 'تم نشر الموضوع.');
                    break;
                case 'reply':
                    $err = $this->forum->addReply($uid, (int)($_POST['post_id'] ?? 0), $_POST['content'] ?? '');
                    $err ? flash('danger', $err) : flash('success', 'تم نشر ردك.');
                    break;
                case 'delete':
                    $ok = $this->forum->deletePost((int)($_POST['post_id'] ?? 0), $uid, is_admin());
                    $ok ? flash('success', 'تم حذف الموضوع.') : flash('danger', 'لا يمكنك حذف هذا الموضوع.');
                    break;
            }
            redirect('forum');
        }
        render('forum', ['posts' => $this->forum->posts()], ['title' => 'المنتدى - StudyHive']);
    }
}
