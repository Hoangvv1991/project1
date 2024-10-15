<?php
session_start(); // Khởi tạo session

// Kiểm tra dữ liệu gửi lên
if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $productId = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    // Kiểm tra xem giỏ hàng có tồn tại không
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId) {
                // Cập nhật số lượng sản phẩm
                if ($quantity > 0) {
                    $item['quantity'] = $quantity; // Cập nhật số lượng
                    // echo json_encode(['status' => 'success', 'message' => 'Số lượng sản phẩm đã được cập nhật.']);
                } else {
                    // Nếu số lượng <= 0, có thể xóa sản phẩm
                    unset($_SESSION['cart'][$key]);
                    echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.']);
                }
                exit; // Kết thúc script
            }
        }
    }

    // Nếu không tìm thấy sản phẩm
    echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Dữ liệu không hợp lệ.']);
}
?>
