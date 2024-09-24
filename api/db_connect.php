<?php
// Kết nối tới cơ sở dữ liệu
$servername = "127.0.0.1";
$dbusername = "root";  // Username của MySQL
$dbpassword = "";      // Password của MySQL
$dbname = "project_aptech"; // Tên database
$dbport = '3306';

try {
    // Kết nối cơ sở dữ liệu sử dụng PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
    exit();
}
?>
