<?php
class Forum
{
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function posts(int $limit = 50): array {
        $s = $this->db->query('SELECT p.*, u.username, (SELECT COUNT(*) FROM forum_replies r WHERE r.post_id = p.id) AS reply_count FROM forum_posts p JOIN users u ON u.id = p.user_id ORDER BY p.id DESC LIMIT ' . (int)$limit);
        $posts = $s->fetchAll();
        if (!$posts) return [];
        $ids = array_column($posts, 'id');
        $in = implode(',', array_map('intval', $ids));
        $replies = $this->db->query("SELECT r.*, u.username FROM forum_replies r JOIN users u ON u.id = r.user_id WHERE r.post_id IN ($in) ORDER BY r.id")->fetchAll();
        $by = [];
        foreach ($replies as $r) { $by[$r['post_id']][] = $r; }
        foreach ($posts as &$p) { $p['replies'] = $by[$p['id']] ?? []; }
        return $posts;
    }
    public function latest(int $n = 3): array {
        return $this->db->query('SELECT p.*, u.username FROM forum_posts p JOIN users u ON u.id = p.user_id ORDER BY p.id DESC LIMIT ' . (int)$n)->fetchAll();
    }
    public function byUser(int $uid): array {
        $s = $this->db->prepare('SELECT * FROM forum_posts WHERE user_id = ? ORDER BY id DESC');
        $s->execute([$uid]);
        return $s->fetchAll();
    }
    public function addPost(int $uid, string $title, string $content): ?string {
        $title = trim($title); $content = trim($content);
        if ($title === '' || mb_strlen($title) > 120) return 'عنوان الموضوع مطلوب (120 حرفاً كحد أقصى).';
        if (mb_strlen($content) < 5 || mb_strlen($content) > 2000) return 'محتوى الموضوع يجب أن يكون بين 5 و2000 حرف.';
        $this->db->prepare('INSERT INTO forum_posts (user_id, title, content) VALUES (?,?,?)')->execute([$uid, $title, $content]);
        return null;
    }
    public function addReply(int $uid, int $postId, string $content): ?string {
        $content = trim($content);
        if (mb_strlen($content) < 2 || mb_strlen($content) > 1000) return 'الرد يجب أن يكون بين 2 و1000 حرف.';
        $s = $this->db->prepare('SELECT 1 FROM forum_posts WHERE id = ?');
        $s->execute([$postId]);
        if (!$s->fetchColumn()) return 'الموضوع غير موجود.';
        $this->db->prepare('INSERT INTO forum_replies (post_id, user_id, content) VALUES (?,?,?)')->execute([$postId, $uid, $content]);
        return null;
    }
    public function deletePost(int $id, int $uid, bool $admin): bool {
        $s = $this->db->prepare('SELECT user_id FROM forum_posts WHERE id = ?');
        $s->execute([$id]);
        $owner = $s->fetchColumn();
        if ($owner === false || (!$admin && (int)$owner !== $uid)) return false;
        $this->db->prepare('DELETE FROM forum_replies WHERE post_id = ?')->execute([$id]);
        $this->db->prepare('DELETE FROM forum_posts WHERE id = ?')->execute([$id]);
        return true;
    }
}
