<?php
class LandingController
{
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }
    public function index(): void {
        if (is_logged_in()) redirect('home');
        render('landingpage', [
            'stats' => [
                'courses' => (new Course($this->db))->count(),
                'resources' => (new Resource($this->db))->countApproved(),
                'users' => (new User($this->db))->count(),
            ],
        ], ['title' => 'StudyHive - منصة طلاب هندسة الحاسوب', 'bare' => true]);
    }
}
