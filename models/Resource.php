<?php
class Resource
{
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function approved(string $q = '', string $type = '', string $course = ''): array {
        $sql = 'SELECT r.*, c.title AS course_title FROM resources r JOIN courses c ON c.course_code = r.course_code WHERE r.status = \'approved\'';
        $args = [];
        if ($q !== '') {
            $sql .= ' AND (r.title LIKE ? OR r.description LIKE ? OR c.title LIKE ? OR c.course_code LIKE ?)';
            $like = '%' . $q . '%';
            array_push($args, $like, $like, $like, $like);
        }
        if ($type !== '' && isset(RESOURCE_TYPES[$type])) { $sql .= ' AND r.type = ?'; $args[] = $type; }
        if ($course !== '') { $sql .= ' AND r.course_code = ?'; $args[] = $course; }
        $s = $this->db->prepare($sql . ' ORDER BY r.course_code, r.id');
        $s->execute($args);
        return $s->fetchAll();
    }
    public function forCourse(string $code): array { return $this->approved('', '', $code); }
    public function countApproved(): int { return (int)$this->db->query("SELECT COUNT(*) FROM resources WHERE status = 'approved'")->fetchColumn(); }

    public function suggest(string $course, string $title, string $url, string $type, string $desc, int $uid): ?string {
        if (trim($title) === '' || mb_strlen($title) > 150) return 'عنوان المصدر مطلوب (150 حرفاً كحد أقصى).';
        if (!safe_url($url)) return 'الرابط غير صالح، يجب أن يبدأ بـ http:// أو https://';
        if (!isset(RESOURCE_TYPES[$type])) return 'نوع المصدر غير صالح.';
        $s = $this->db->prepare('SELECT 1 FROM resources WHERE course_code = ? AND url = ?');
        $s->execute([$course, $url]);
        if ($s->fetchColumn()) return 'هذا الرابط مضاف مسبقاً لهذا المقرر.';
        $this->db->prepare("INSERT INTO resources (course_code, title, url, type, description, status, submitted_by) VALUES (?,?,?,?,?, 'pending', ?)")
            ->execute([$course, trim($title), $url, $type, mb_substr(trim($desc), 0, 255), $uid]);
        return null;
    }
    public function add(array $d): ?string {
        if (trim($d['title'] ?? '') === '' || !safe_url($d['url'] ?? '') || !isset(RESOURCE_TYPES[$d['type'] ?? ''])) return 'تحقق من العنوان والرابط والنوع.';
        $this->db->prepare("INSERT INTO resources (course_code, title, url, type, description, status) VALUES (?,?,?,?,?, 'approved')")
            ->execute([$d['course_code'], trim($d['title']), $d['url'], $d['type'], mb_substr(trim($d['description'] ?? ''), 0, 255)]);
        return null;
    }
    public function pending(): array {
        return $this->db->query("SELECT r.*, c.title AS course_title, u.username FROM resources r JOIN courses c ON c.course_code = r.course_code LEFT JOIN users u ON u.id = r.submitted_by WHERE r.status = 'pending' ORDER BY r.id")->fetchAll();
    }
    public function setStatus(int $id, string $status): void {
        if ($status === 'rejected') { $this->db->prepare('DELETE FROM resources WHERE id = ?')->execute([$id]); return; }
        $this->db->prepare('UPDATE resources SET status = ? WHERE id = ?')->execute([$status, $id]);
    }
    public function delete(int $id): void { $this->db->prepare('DELETE FROM resources WHERE id = ?')->execute([$id]); }
}
