<?php
session_start(); // Khởi tạo session

// Kiểm tra dữ liệu sản phẩm
if (isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];

    // Tạo mảng sản phẩm
    $product = [
        'id' => $productId,
        'name' => $productName,
        'price' => $productPrice,
        'quantity' => 1
    ];

    // Kiểm tra xem giỏ hàng có tồn tại chưa, nếu chưa thì tạo mới
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Kiểm tra sản phẩm có trong giỏ hàng chưa, nếu có thì tăng số lượng
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    // Nếu sản phẩm chưa có trong giỏ hàng thì thêm mới
    if (!$found) {
        $_SESSION['cart'][] = $product;
    }

    // Phản hồi thành công
    echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã được thêm vào giỏ hàng']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Dữ liệu sản phẩm không hợp lệ']);
}
?>
