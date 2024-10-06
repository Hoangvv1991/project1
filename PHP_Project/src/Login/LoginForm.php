<?php
// Bắt đầu session
session_start();

// Import file kết nối PDO
include '../api/db_connect.php';

// Biến lưu thông báo lỗi
$error = "";

// Kiểm tra khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn cơ sở dữ liệu để kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM tbl_customers 
            where 1 AND 
            customer_email = :username
            AND customer_password = :password
            LIMIT 1
            ";

    $stmt = $pdo->prepare($sql);
    
    // Liên kết giá trị vào các placeholders
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    
    // Thực thi câu truy vấn
    $stmt->execute();

    // Kiểm tra nếu tồn tại kết quả
    if ($stmt->rowCount() > 0) {
        // Đăng nhập thành công, lưu thông tin vào session
        $_SESSION['username'] = $username;
        header("Location: ../../index.php?page=home"); // Chuyển hướng đến trang dashboard sau khi đăng nhập
        exit();
    } else {
        $error = "Sai thông tin đăng nhập!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center mt-5">Login</h2>
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <!-- Thêm nút đăng ký -->
                <div class="mt-3 text-center">
                    <p>Don't have an account? <a href="Register/RegisterForm.php">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
