<?php
class Support
{
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function add(?int $uid, string $name, string $email, string $topic, string $message): ?string {
        $name = trim($name); $topic = trim($topic); $message = trim($message);
        if ($name === '' || mb_strlen($name) > 60) return 'الاسم مطلوب (60 حرفاً كحد أقصى).';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return 'البريد الإلكتروني غير صالح.';
        if ($topic === '' || mb_strlen($topic) > 100) return 'موضوع الاستفسار مطلوب (100 حرف كحد أقصى).';
        if (mb_strlen($message) < 10 || mb_strlen($message) > 1500) return 'الرسالة يجب أن تكون بين 10 و1500 حرف.';
        $this->db->prepare('INSERT INTO support_requests (user_id, name, email, topic, message) VALUES (?,?,?,?,?)')
            ->execute([$uid, $name, $email, $topic, $message]);
        return null;
    }
    public function all(): array { return $this->db->query('SELECT * FROM support_requests ORDER BY status = \'open\' DESC, id DESC')->fetchAll(); }
    public function resolve(int $id): void { $this->db->prepare("UPDATE support_requests SET status = 'resolved' WHERE id = ?")->execute([$id]); }
    public function openCount(): int { return (int)$this->db->query("SELECT COUNT(*) FROM support_requests WHERE status = 'open'")->fetchColumn(); }
}
