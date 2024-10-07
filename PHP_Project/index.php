<?php
// Kiểm tra tham số "page" từ URL để điều hướng tới trang tương ứng
$pages = isset($_GET['pages']) ? $_GET['pages'] : 'home';

switch ($pages) {
    case 'face':
        require_once __DIR__ . '/src/Pages/Face.php';
        break;
    case 'body':
        require_once __DIR__ . '/src/Pages/Body.php';
        break;
    case 'hair':
        require_once __DIR__ . '/src/Pages/Hair.php';
        break;
    case 'makeup':
        require_once __DIR__ . '/src/Pages/Makeup.php';
        break;
    case 'perfumes':
        require_once __DIR__ . '/src/Pages/Perfumes.php';
        break;
    case 'sunscreen':
        require_once __DIR__ . '/src/Pages/Sunscreen.php';
        break;
    case 'home':
    default:
        require_once __DIR__ . '/src/Pages/Home.php';
        break;
}
