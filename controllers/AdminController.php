<?php
class AdminController
{
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function index(): void {
        require_admin();
        $courses = new Course($this->db); $res = new Resource($this->db); $sup = new Support($this->db);
        if (is_post()) {
            verify_csrf();
            $tab = $_POST['tab'] ?? 'courses';
            switch ($_POST['action'] ?? '') {
                case 'save_course':
                    $isNew = ($_POST['mode'] ?? '') === 'new';
                    $err = $courses->save($_POST, $isNew);
                    $err ? flash('danger', $err) : flash('success', 'تم حفظ المقرر.');
                    break;
                case 'delete_course':
                    $courses->delete($_POST['course_code'] ?? ''); flash('success', 'تم حذف المقرر ومصادره.'); break;
                case 'add_resource':
                    $err = $courses->find($_POST['course_code'] ?? '') ? $res->add($_POST) : 'المقرر غير موجود.';
                    $err ? flash('danger', $err) : flash('success', 'تمت إضافة المصدر.');
                    break;
                case 'delete_resource':
                    $res->delete((int)$_POST['id']); flash('success', 'تم حذف المصدر.'); break;
                case 'approve':
                    $res->setStatus((int)$_POST['id'], 'approved'); flash('success', 'تمت الموافقة على المصدر.'); break;
                case 'reject':
                    $res->setStatus((int)$_POST['id'], 'rejected'); flash('success', 'تم رفض المصدر.'); break;
                case 'resolve':
                    $sup->resolve((int)$_POST['id']); flash('success', 'تم إغلاق الطلب.'); break;
            }
            redirect('admin', ['tab' => $tab]);
        }
        $tab = in_array($_GET['tab'] ?? '', ['courses', 'resources', 'pending', 'support'], true) ? $_GET['tab'] : 'courses';
        $edit = isset($_GET['edit']) ? $courses->find($_GET['edit']) : null;
        render('admin', [
            'tab' => $tab, 'edit' => $edit, 'courseList' => $courses->all(), 'allResources' => $res->approved(),
            'pending' => $res->pending(), 'requests' => $sup->all(),
            'stats' => ['users' => (new User($this->db))->count(), 'courses' => $courses->count(), 'resources' => $res->countApproved(), 'open' => $sup->openCount()],
        ], ['title' => 'لوحة الإدارة - StudyHive']);
    }
}
