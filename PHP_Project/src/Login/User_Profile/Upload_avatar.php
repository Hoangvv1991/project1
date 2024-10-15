<?php
include_once __DIR__ . '../../../../config.php';
include API_PATH . 'db_connect.php';

$error = '';
// Xử lý upload ảnh khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = '';
    if (isset($_FILES['avatar'])) {
        $userId = $_POST['user_id']; // Nhận ID người dùng từ form
        $targetDir = IMAGE_PATH . "avatars/";
        if (!is_dir($targetDir)) {
            if (mkdir($targetDir, 0755, true)) {
                echo "Thư mục '$directory' đã được tạo thành công.";
            }
        }

        $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));
        $newFileName = $userId . date("Ymd_His") . "." . $imageFileType;
        $targetFilePath = $targetDir . $newFileName;

        // Kiểm tra định dạng ảnh
        $allowTypes = array('jpg', 'png', 'gif');
        if (in_array($imageFileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFilePath)) {
                // Cập nhật đường dẫn ảnh vào database
                $stmt = $pdo->prepare("UPDATE tbl_customers SET customer_image_path = :avatar WHERE customer_guid = :id");
                if ($stmt->execute(['avatar' => 'Public/img/avatars/' . $newFileName, 'id' => $userId])) {
                    $error = $targetFilePath;
                } else {
                    $error = "Error updating record.";
                }
            } else {
                $error = "Error uploading file.";
            }
        } else {
            $error = "Invalid file type.";
        }
        $response = array('img_name' => 'Public/img/avatars/' . $newFileName);
    }
    echo json_encode($response);
}
