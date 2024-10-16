<?php
session_start();
include_once __DIR__ . '../../../../config.php';
include_once PUBLIC_PATH . 'header.php';
$total = 0;
$mycartname = '';
if (isset($_SESSION['session_login'])) {
    $mycartname = $customer_data['customer_name'];
    $mycart_phone = $customer_data['customer_phone'];
    $mycart_address = $customer_data['customer_address'];
}

// Kiểm tra nếu giỏ hàng có tồn tại trong session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $cart = []; // Giỏ hàng rỗng nếu không có sản phẩm nào
}

// Nếu giỏ hàng trống, có thể chuyển hướng về trang giỏ hàng
if (empty($cart)) {
    header('Location: mycart.php'); // Chuyển hướng về trang giỏ hàng
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="http://localhost/project_aptech/PHP_Project/src/Pages/My_cart/Payment.css">
</head>

<body>
    <main class="container">
        <div id="divpayment">
            <h1>Payment Page</h1>
            <?php if (empty($cart)): ?>
                <p>Your cart is empty. Please go back to shop.</p>
            <?php else: ?>
                <table id="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item):
                            $itemTotal = $item['price'] * $item['quantity'];
                            $total += $itemTotal; // Cập nhật tổng tiền
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= number_format($itemTotal, 0, ',', '.') ?> VND</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h3>Total: <?= number_format($total, 0, ',', '.') ?> VND</h3>
            <?php endif; ?>

            <form id="payment-form" action="process_payment.php" method="post">
                <input type="submit" value="Confirm Payment" id="confirm-payment">
                <input type="button" value="Back to Cart" id="back-to-cart" style="background-color: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px; margin-left: 10px;">
            </form>
        </div>


        <div class="recipient-info" id="recipient-info">
            <h2>Recipient Information</h2>
            <label for="recipient-name">Name:</label>
            <input type="text" id="recipient-name" name="recipient_name" readonly value="<?= htmlspecialchars($mycartname); ?>">
            <br>
            <label for="recipient-address">Address:</label>
            <input type="text" id="recipient-address" name="recipient_address" readonly value="<?= htmlspecialchars($mycart_address); ?>">
            <br>
            <label for="recipient-phone">Phone:</label>
            <input type="tel" id="recipient-phone" name="recipient_phone" readonly value="<?= htmlspecialchars($mycart_phone); ?>">
            <br><br>
            <input type="submit" value="Submit" id="submit-recipient-info">
            <input type="button" value="Cancel" id="cancel-payment" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px; margin-left: 10px;">
        </div>
    </main>

    <script>
        document.getElementById('confirm-payment').addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của nút submit

            // Ẩn bảng giỏ hàng
            document.getElementById('divpayment').style.display = 'none';

            // Hiển thị thông tin người nhận
            document.getElementById('recipient-info').style.display = 'block';
        });
        document.getElementById('back-to-cart').addEventListener('click', function() {
            window.location.href = 'http://localhost/project_aptech/PHP_Project/src/Pages/My_cart/Mycart.php'; // Chuyển hướng về trang giỏ hàng
        });

        document.getElementById('cancel-payment').addEventListener('click', function() {
            // Hiển thị lại bảng giỏ hàng
            document.getElementById('divpayment').style.display = 'block'; // Hiển thị lại bảng giỏ hàng

            // Ẩn thông tin người nhận
            document.getElementById('recipient-info').style.display = 'none';
        });

        // Xử lý sự kiện khi người dùng nhấn "Submit" thông tin người nhận
        document.getElementById('submit-recipient-info').addEventListener('click', function(event) {
            // Thêm mã xử lý để gửi thông tin người nhận nếu cần
            alert('Recipient information submitted.'); // Bạn có thể thay thế bằng mã xử lý thực sự
        });
    </script>
</body>

</html>

<?php
include_once PUBLIC_PATH . 'footer.php';
?>