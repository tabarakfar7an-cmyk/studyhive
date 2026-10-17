<?php
require_once __DIR__ . '/includes/helpers.php';
foreach (['Database', 'User', 'Course', 'Resource', 'Forum', 'Support'] as $m) {
    require_once __DIR__ . "/models/$m.php";
}

// الصفحة => اسم الـ Controller
$routes = [
    'home' => 'Home', 'landingpage' => 'Landing', 'courseland' => 'Courses', 'courses' => 'Courses',
    'course' => 'Courses', 'forum' => 'Forum', 'resources' => 'Resources', 'contact' => 'Contact',
    'profile' => 'Profile', 'register' => 'Auth', 'login' => 'Auth', 'logout' => 'Auth', 'admin' => 'Admin',
];

$page = $_GET['page'] ?? (is_logged_in() ? 'home' : 'landingpage');

if (!isset($routes[$page])) {
    http_response_code(404);
    render('404', [], ['title' => 'الصفحة غير موجودة']);
    exit;
}

$class = $routes[$page] . 'Controller';
require_once __DIR__ . "/controllers/$class.php";
$controller = new $class(Database::connect());
$action = $page === 'courseland' ? 'index' : (method_exists($controller, $page) ? $page : 'index');
$controller->$action();
