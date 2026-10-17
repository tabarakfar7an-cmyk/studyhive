<?php
class ResourcesController
{
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function index(): void {
        $courses = new Course($this->db);
        if (is_post()) {
            require_login();
            verify_csrf();
            $err = (new Resource($this->db))->suggest($_POST['course_code'] ?? '', $_POST['title'] ?? '', trim($_POST['url'] ?? ''), $_POST['type'] ?? '', $_POST['description'] ?? '', (int)current_user()['id']);
            if (!$courses->find($_POST['course_code'] ?? '')) $err = 'المقرر غير موجود.';
            $err ? flash('danger', $err) : flash('success', 'شكراً! تم إرسال المصدر للمراجعة وسيظهر بعد موافقة الإدارة.');
            redirect('resources');
        }
        $q = trim($_GET['q'] ?? ''); $type = $_GET['type'] ?? ''; $course = $_GET['course'] ?? '';
        $list = (new Resource($this->db))->approved($q, $type, $course);
        $grouped = [];
        foreach ($list as $r) { $grouped[$r['course_code'] . '|' . $r['course_title']][] = $r; }
        render('resources', [
            'grouped' => $grouped, 'total' => count($list), 'q' => $q, 'type' => $type, 'course' => $course,
            'courseList' => $courses->all(),
        ], ['title' => 'موارد الدراسة - StudyHive']);
    }
}
