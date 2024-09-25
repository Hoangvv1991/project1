<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

$response = [];

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['username'];
$user_password = $data['password'];

//Kết nối tới cơ sở dữ liệu
include '../db_connect.php'; 

// Kiểm tra người dùng
$sql = "SELECT user_id, user_password FROM tbl_users WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$stmt->execute();

// Kiểm tra nếu tìm thấy người dùng
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Kiểm tra mật khẩu
    if ($user_password === $row['user_password']) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }
} else {
    $response['success'] = false;
}

echo json_encode($response);
?>
