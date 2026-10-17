<?php
class User
{
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function findByEmail(string $email): ?array {
        $s = $this->db->prepare('SELECT * FROM users WHERE LOWER(email) = LOWER(?)');
        $s->execute([$email]);
        return $s->fetch() ?: null;
    }
    public function findById(int $id): ?array {
        $s = $this->db->prepare('SELECT * FROM users WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }
    public function usernameTaken(string $name, int $exceptId = 0): bool {
        $s = $this->db->prepare('SELECT 1 FROM users WHERE LOWER(username) = LOWER(?) AND id <> ?');
        $s->execute([$name, $exceptId]);
        return (bool)$s->fetchColumn();
    }

    /** @return int|string  معرّف المستخدم الجديد، أو نص رسالة الخطأ */
    public function register(string $username, string $email, string $password) {
        if (mb_strlen($username) < 3 || mb_strlen($username) > 30) return 'اسم المستخدم يجب أن يكون بين 3 و30 حرفاً.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return 'البريد الإلكتروني غير صالح.';
        if (strlen($password) < 8) return 'كلمة المرور يجب ألا تقل عن 8 أحرف.';
        if ($this->findByEmail($email)) return 'البريد الإلكتروني مسجّل مسبقاً.';
        if ($this->usernameTaken($username)) return 'اسم المستخدم مستخدم مسبقاً.';
        $s = $this->db->prepare('INSERT INTO users (username, email, password) VALUES (?,?,?)');
        $s->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);
        return (int)$this->db->lastInsertId();
    }

    public function login(string $email, string $password): ?array {
        $u = $this->findByEmail($email);
        return ($u && password_verify($password, $u['password'])) ? $u : null;
    }

    public function updateProfile(int $id, string $username, string $major): ?string {
        if (mb_strlen($username) < 3 || mb_strlen($username) > 30) return 'اسم المستخدم يجب أن يكون بين 3 و30 حرفاً.';
        if ($this->usernameTaken($username, $id)) return 'اسم المستخدم مستخدم مسبقاً.';
        $this->db->prepare('UPDATE users SET username = ?, major = ? WHERE id = ?')->execute([$username, mb_substr($major, 0, 60), $id]);
        return null;
    }
    public function changePassword(int $id, string $old, string $new): ?string {
        $u = $this->findById($id);
        if (!$u || !password_verify($old, $u['password'])) return 'كلمة المرور الحالية غير صحيحة.';
        if (strlen($new) < 8) return 'كلمة المرور الجديدة يجب ألا تقل عن 8 أحرف.';
        $this->db->prepare('UPDATE users SET password = ? WHERE id = ?')->execute([password_hash($new, PASSWORD_DEFAULT), $id]);
        return null;
    }
    public function count(): int { return (int)$this->db->query('SELECT COUNT(*) FROM users')->fetchColumn(); }
}
