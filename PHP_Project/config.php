<?php
// Đường dẫn thư mục gốc (root) của dự án

define('BASE_URL', __DIR__ . '/');
// Đường dẫn tuyệt đối của file hiện tại (ví dụ: D:/Program Files/Xampp/htdocs/project_aptech/PHP_Project)
$currentDir = __DIR__;

// Đường dẫn nhận được từ cơ sở dữ liệu
$filePath = 'D:/Program Files/Xampp/htdocs/project_aptech/PHP_Project';

// Phần bạn muốn xóa khỏi đường dẫn
$basePath = 'D:/Program Files/Xampp/htdocs';

// Sử dụng str_replace để xóa phần đường dẫn không cần thiết
$relativePath = str_replace($basePath, '', $filePath);


// Đường dẫn tương đối đến thư mục Public (từ thư mục gốc)
$publicPath = 'http://localhost' . $relativePath . '/' ;

define('LOCAL_TEST',  $publicPath);

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