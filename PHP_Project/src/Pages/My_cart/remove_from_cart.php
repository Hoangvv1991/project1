<?php
session_start(); // Khởi tạo session

// Kiểm tra xem id sản phẩm đã được gửi không
if (isset($_POST['id'])) {
    $productId = $_POST['id'];

    // Kiểm tra xem giỏ hàng có tồn tại không
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $productId) {
                // Xóa sản phẩm khỏi giỏ hàng
                unset($_SESSION['cart'][$key]);
                
                // Cập nhật lại giỏ hàng
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Để đảm bảo không có khóa bị bỏ trống
                
                // Phản hồi thành công
                echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.']);
                exit; // Kết thúc script
            }
        }
    }

    // Nếu không tìm thấy sản phẩm
    echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Không có ID sản phẩm.']);
}
?>
