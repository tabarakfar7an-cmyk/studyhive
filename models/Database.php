<?php
/**
 * اتصال قاعدة البيانات.
 * القيم الافتراضية مناسبة لـ XAMPP. يمكن تغييرها عبر متغيرات البيئة:
 * DB_HOST, DB_NAME, DB_USER, DB_PASS  (أو DB_DSN لاستخدام DSN كامل).
 */
class Database
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        if (self::$pdo) {
            return self::$pdo;
        }
        $dsn  = getenv('DB_DSN') ?: 'mysql:host=' . (getenv('DB_HOST') ?: 'localhost') . ';dbname=' . (getenv('DB_NAME') ?: 'studyhive') . ';charset=utf8mb4';
        $user = getenv('DB_USER') !== false ? getenv('DB_USER') : 'root';
        $pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';
        try {
            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            if (strpos($dsn, 'mysql') === 0) {
                self::$pdo->exec("SET time_zone = '+00:00'"); // لعرض «قبل ...» بشكل صحيح
            }
            if (strpos($dsn, 'sqlite') === 0) {
                self::$pdo->exec('PRAGMA foreign_keys = ON');
            }
        } catch (PDOException $e) {
            http_response_code(500);
            exit('<p style="font-family:sans-serif;direction:rtl;padding:2rem">تعذّر الاتصال بقاعدة البيانات. تأكد من تشغيل MySQL واستيراد الملف <b>studyhive.sql</b> وضبط بيانات الاتصال في <b>models/Database.php</b>.</p>');
        }
        // تأكد أن هيكل الجداول هو الجديد
        try {
            self::$pdo->query('SELECT status FROM resources LIMIT 1');
            self::$pdo->query('SELECT role FROM users LIMIT 1');
        } catch (PDOException $e) {
            http_response_code(500);
            exit('<p style="font-family:sans-serif;direction:rtl;padding:2rem">قاعدة البيانات قديمة أو غير مثبّتة. افتح <a href="install.php"><b>install.php</b></a> لتثبيت القاعدة الجديدة تلقائياً (سيتم استبدال الجداول القديمة).</p>');
        }
        return self::$pdo;
    }
}
