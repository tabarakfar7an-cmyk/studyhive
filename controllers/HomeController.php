<?php
class HomeController
{
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }
    public function index(): void {
        require_login();
        $courses = new Course($this->db);
        render('home', [
            'user' => current_user(),
            'featured' => $courses->featured(3),
            'categories' => $courses->categories(),
            'latestPosts' => (new Forum($this->db))->latest(3),
            'savedCount' => count($courses->savedCodes((int)current_user()['id'])),
            'stats' => ['courses' => $courses->count(), 'resources' => (new Resource($this->db))->countApproved()],
        ], ['title' => 'الرئيسية - StudyHive']);
    }
}
