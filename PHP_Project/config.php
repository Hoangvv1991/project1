<?php

define('BASE_URL', __DIR__ . '/');

$currentDir = __DIR__;


$filePath = __DIR__;

$basePath = $_SERVER['DOCUMENT_ROOT'];


$filePath = str_replace('\\', '/', $filePath);
$basePath = str_replace('\\', '/', $basePath);


$relativePath = str_replace($basePath, '', $filePath);


$publicPath = 'http://localhost' . $relativePath . '/';

define('LOCAL_URL',  $publicPath);


define('PUBLIC_PATH', BASE_URL . 'src/public/');


define('IMAGE_PATH', BASE_URL . 'public/img/');

define('API_PATH', BASE_URL . 'src/api/');


define('PAGES_PATH', BASE_URL . 'src/Pages/');


define('ADMIN_PATH', BASE_URL . 'src/Admin/');

define('LOGIN_PATH', BASE_URL . 'src/Login/');


define('JS_PATH',  BASE_URL . 'src/Public/js/');


define('UPLOAD_PATH', BASE_URL . 'uploads/');
