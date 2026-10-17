<?php
class CoursesController
{
    private PDO $db;
    private Course $courses;
    public function __construct(PDO $db) { $this->db = $db; $this->courses = new Course($db); }

    public function index(): void {
        $q = trim($_GET['q'] ?? '');
        $cat = trim($_GET['category'] ?? '');
        $public = ($_GET['page'] ?? '') === 'courseland' && !is_logged_in();
        render('courses', [
            'list' => $this->courses->all($q, $cat),
            'categories' => $this->courses->categories(),
            'q' => $q, 'cat' => $cat,
            'saved' => is_logged_in() ? $this->courses->savedCodes((int)current_user()['id']) : [],
        ], ['title' => 'المقررات - StudyHive', 'bare' => $public]);
    }

    public function course(): void {
        $course = $this->courses->find($_GET['code'] ?? '');
        if (!$course) {
            http_response_code(404);
            render('404', [], ['title' => 'المقرر غير موجود']);
            return;
        }
        if (is_post()) {
            require_login();
            verify_csrf();
            $uid = (int)current_user()['id'];
            if (($_POST['action'] ?? '') === 'toggle_save') {
                $now = $this->courses->toggleSave($uid, $course['course_code']);
                flash('success', $now ? 'تمت إضافة المقرر إلى مقرراتك المحفوظة.' : 'تمت إزالة المقرر من المحفوظات.');
            } elseif (($_POST['action'] ?? '') === 'suggest') {
                $err = (new Resource($this->db))->suggest($course['course_code'], $_POST['title'] ?? '', trim($_POST['url'] ?? ''), $_POST['type'] ?? '', $_POST['description'] ?? '', $uid);
                $err ? flash('danger', $err) : flash('success', 'شكراً! تم إرسال المصدر للمراجعة وسيظهر بعد موافقة الإدارة.');
            }
            redirect('course', ['code' => $course['course_code']]);
        }
        $res = (new Resource($this->db))->forCourse($course['course_code']);
        $grouped = [];
        foreach ($res as $r) { $grouped[$r['type']][] = $r; }
        render('course', [
            'course' => $course, 'grouped' => $grouped, 'resCount' => count($res),
            'isSaved' => is_logged_in() && in_array($course['course_code'], $this->courses->savedCodes((int)current_user()['id'])),
            'related' => array_slice(array_values(array_filter($this->courses->all('', $course['category']), fn($c) => $c['course_code'] !== $course['course_code'])), 0, 4),
        ], ['title' => $course['title'] . ' - StudyHive']);
    }
}
