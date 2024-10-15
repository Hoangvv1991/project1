<?php
session_start();

// Kiểm tra nếu có ID sản phẩm được gửi
if (isset($_POST['id'])) {
    $productId = $_POST['id'];

    // Kiểm tra nếu giỏ hàng tồn tại trong session
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Lặp qua giỏ hàng và xóa sản phẩm
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $productId) {
                // Xóa sản phẩm khỏi giỏ hàng
                unset($_SESSION['cart'][$key]);
                // Gửi phản hồi thành công
                echo json_encode(['status' => 'success', 'message' => 'Product removed from cart.']);
                exit;
            }
        }
        // Nếu không tìm thấy sản phẩm
        echo json_encode(['status' => 'error', 'message' => 'Product not found in cart.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Cart is empty.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No product ID specified.']);
}
?>
