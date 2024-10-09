<?php
include_once 'config.php';

// Kiểm tra tham số "page" từ URL để điều hướng tới trang tương ứng
$pages = isset($_GET['pages']) ? $_GET['pages'] : 'home';

switch ($pages) {
    case 'face':
        require_once  PAGES_PATH . 'Face.php';
        break;
    case 'body':
        require_once  PAGES_PATH . 'Body.php';
        break;
    case 'hair':
        require_once  PAGES_PATH . 'Hair.php';
        break;
    case 'makeup':
        require_once  PAGES_PATH . 'Makeup.php';
        break;
    case 'perfumes':
        require_once  PAGES_PATH . 'Perfumes.php';
        break;
    case 'sunscreen':
        require_once  PAGES_PATH . 'Sunscreen.php';
        break;
    case 'home':
    default:
        require_once  PAGES_PATH . 'Home.php';
        break;
}
