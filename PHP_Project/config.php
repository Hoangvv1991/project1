<?php
// Đường dẫn thư mục gốc (root) của dự án

define('BASE_URL', __DIR__ . '/');
// Đường dẫn tuyệt đối của file hiện tại (ví dụ: D:/Program Files/Xampp/htdocs/project_aptech/PHP_Project)
$currentDir = __DIR__;

// Chuyển đổi các dấu \ thành / để làm việc với đường dẫn dễ dàng hơn
$currentDir = str_replace('\\', '/', $currentDir);

// Tách đường dẫn thành một mảng
$pathParts = explode('/', $currentDir);

// Tìm và lấy thư mục gốc (ví dụ: project_aptech)
$projectRoot = $pathParts[4]; // Ở đây, phần tử thứ 4 là project_aptech theo cấu trúc đường dẫn của bạn

// Đường dẫn tương đối đến thư mục Public (từ thư mục gốc)
$publicPath = 'http://localhost/' . $projectRoot . '/PHP_Project/';

define('LOCAL_URL',  $publicPath);

define('PUBLIC_PATH', BASE_URL . 'src/public/');

// Đường dẫn tương đối đến thư mục chứa hình ảnh
define('IMAGE_PATH', BASE_URL . 'public/img/');

define('API_PATH', BASE_URL . 'src/api/');

// Đường dẫn tương đối đến các trang Pages
define('PAGES_PATH', BASE_URL . 'src/Pages/');

// Đường dẫn tương đối đến các trang admin
define('ADMIN_PATH', BASE_URL . 'src/Admin/');

define('LOGIN_PATH', BASE_URL . 'src/Login/');

// Đường dẫn tương đối đến các tập tin JavaScript
define('JS_PATH',  BASE_URL . 'src/Public/js/');

// Các cấu hình khác nếu cần
// Ví dụ: đường dẫn đến thư mục chứa file upload
define('UPLOAD_PATH', BASE_URL . 'uploads/');
?>
