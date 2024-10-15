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

    // Kiểm tra sản phẩm có trong giỏ hàng chưa
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $found = true; // Đánh dấu sản phẩm đã có trong giỏ hàng
            break;
        }
    }

    // Nếu sản phẩm chưa có trong giỏ hàng thì thêm mới
    if (!$found) {
        $_SESSION['cart'][] = $product; // Thêm sản phẩm vào giỏ hàng
        echo json_encode(['status' => 'success', 'message' => 'The product has been added to the cart!']);
    } else {
        // Nếu sản phẩm đã có trong giỏ hàng, thông báo
        echo json_encode(['status' => 'warning', 'message' => 'The product has already been selected!']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product data']);
}
?>

