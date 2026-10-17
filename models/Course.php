<?php
class Course
{
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function all(string $q = '', string $category = ''): array {
        $sql = 'SELECT c.*, (SELECT COUNT(*) FROM resources r WHERE r.course_code = c.course_code AND r.status = \'approved\') AS res_count FROM courses c WHERE 1=1';
        $args = [];
        if ($q !== '') {
            $sql .= ' AND (c.title LIKE ? OR c.course_code LIKE ? OR c.description LIKE ?)';
            $like = '%' . $q . '%';
            array_push($args, $like, $like, $like);
        }
        if ($category !== '') { $sql .= ' AND c.category = ?'; $args[] = $category; }
        $s = $this->db->prepare($sql . ' ORDER BY c.course_code');
        $s->execute($args);
        return $s->fetchAll();
    }
    public function find(string $code): ?array {
        $s = $this->db->prepare('SELECT * FROM courses WHERE course_code = ?');
        $s->execute([$code]);
        return $s->fetch() ?: null;
    }
    public function featured(int $n = 3): array {
        return $this->db->query('SELECT * FROM courses WHERE featured = 1 ORDER BY course_code LIMIT ' . (int)$n)->fetchAll();
    }
    public function categories(): array {
        return $this->db->query('SELECT category AS name, COUNT(*) AS n FROM courses GROUP BY category ORDER BY n DESC, category')->fetchAll();
    }
    public function count(): int { return (int)$this->db->query('SELECT COUNT(*) FROM courses')->fetchColumn(); }

    public function save(array $d, bool $isNew): ?string {
        foreach (['course_code', 'title', 'description', 'plan', 'category'] as $f) {
            if (trim($d[$f] ?? '') === '') return 'جميع الحقول مطلوبة.';
        }
        if ($isNew) {
            if ($this->find($d['course_code'])) return 'رمز المقرر موجود مسبقاً.';
            $s = $this->db->prepare('INSERT INTO courses (course_code, title, description, plan, category, featured) VALUES (?,?,?,?,?,?)');
            $s->execute([$d['course_code'], $d['title'], $d['description'], $d['plan'], $d['category'], (int)!empty($d['featured'])]);
        } else {
            $s = $this->db->prepare('UPDATE courses SET title=?, description=?, plan=?, category=?, featured=? WHERE course_code=?');
            $s->execute([$d['title'], $d['description'], $d['plan'], $d['category'], (int)!empty($d['featured']), $d['course_code']]);
        }
        return null;
    }
    public function delete(string $code): void {
        $this->db->prepare('DELETE FROM resources WHERE course_code = ?')->execute([$code]);
        $this->db->prepare('DELETE FROM saved_courses WHERE course_code = ?')->execute([$code]);
        $this->db->prepare('DELETE FROM courses WHERE course_code = ?')->execute([$code]);
    }

    /* المقررات المحفوظة */
    public function savedCodes(int $uid): array {
        $s = $this->db->prepare('SELECT course_code FROM saved_courses WHERE user_id = ?');
        $s->execute([$uid]);
        return $s->fetchAll(PDO::FETCH_COLUMN);
    }
    public function savedCourses(int $uid): array {
        $s = $this->db->prepare('SELECT c.* FROM courses c JOIN saved_courses sc ON sc.course_code = c.course_code WHERE sc.user_id = ? ORDER BY c.course_code');
        $s->execute([$uid]);
        return $s->fetchAll();
    }
    public function toggleSave(int $uid, string $code): bool {
        if (!$this->find($code)) return false;
        $s = $this->db->prepare('SELECT 1 FROM saved_courses WHERE user_id = ? AND course_code = ?');
        $s->execute([$uid, $code]);
        if ($s->fetchColumn()) {
            $this->db->prepare('DELETE FROM saved_courses WHERE user_id = ? AND course_code = ?')->execute([$uid, $code]);
            return false;
        }
        $this->db->prepare('INSERT INTO saved_courses (user_id, course_code) VALUES (?,?)')->execute([$uid, $code]);
        return true;
    }
}
