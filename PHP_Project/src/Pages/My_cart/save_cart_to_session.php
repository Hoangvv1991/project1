<?php
session_start();

// Kiểm tra xem có dữ liệu giỏ hàng được gửi lên không
if (isset($_POST['cart'])) {
    $cart = json_decode($_POST['cart'], true); // Chuyển đổi từ JSON sang mảng PHP
    $_SESSION['cart'] = $cart; // Lưu giỏ hàng vào session
    // echo json_encode(['status' => 'success', 'message' => 'Giỏ hàng đã được lưu.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Không có giỏ hàng để lưu.']);
}
?>