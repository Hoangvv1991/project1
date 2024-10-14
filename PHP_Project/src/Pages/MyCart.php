<?php
session_start();
include_once __DIR__ . '/../../config.php';
include_once __DIR__ . '/../Public/header.php';

// Kiểm tra nếu giỏ hàng có tồn tại
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = [];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
    <link rel="stylesheet" href="<?php echo LOCAL_URL . 'src/Pages/css/MyCart.css' ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Thêm jQuery -->
</head>
<body>
    <h1 class="cart-title">Giỏ hàng của bạn</h1>

    <?php if (empty($cart)): ?>
        <p class="cart-empty">Giỏ hàng hiện đang trống.</p>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="cart-body">
                <?php
                $total = 0;
                foreach ($cart as $item): 
                    $itemTotal = $item['price'] * $item['quantity'];
                    $total += $itemTotal;
                ?>
                    <tr id="cart-item-<?= $item['id'] ?>">
                        <td class="cart-item-name"><?= htmlspecialchars($item['name']) ?></td>
                        <td class="cart-item-price"><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                        <td class="cart-item-quantity"><?= $item['quantity'] ?></td>
                        <td class="cart-item-total"><?= number_format($itemTotal, 0, ',', '.') ?> VND</td>
                        <td class="cart-item-action actions">
                            <!-- Thay đổi liên kết thành nút xóa -->
                            <button class="btn-remove" data-id="<?= $item['id'] ?>">Xóa</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 class="cart-total">Tổng tiền: <?= number_format($total, 0, ',', '.') ?> VND</h3>
        <a href="checkout.php" class="btn-checkout">Thanh toán</a>
    <?php endif; ?>

    
</body>
</html>

<?php
include_once __DIR__ . '/../Public/footer.php'; 
?>
