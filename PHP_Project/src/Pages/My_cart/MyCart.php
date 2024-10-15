<?php
session_start();
include_once __DIR__ . '../../../../config.php';
include_once PUBLIC_PATH . 'header.php';
$mycartname = '';
if (isset($_SESSION['session_login'])){
    $mycartname = $customer_data['customer_name'];
    $mycart_phone = $customer_data['customer_phone'];
    $mycart_address = $customer_data['customer_address'];
}


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
    <title>Your Shopping Cart</title>
    <link rel="stylesheet" href="http://localhost/project_aptech/PHP_Project/src/Pages/My_cart/Mycart.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Add jQuery -->
</head>
<body>
    <h1 class="cart-title">Your Shopping Cart</h1>
    <div id="div-cart-empty" style="display: none;" >
            <div class="cart-empty" id="cartempty"><h5>Your cart is currently empty.</h5></div>
            <div id="cartempty"><a href="http://localhost/project_aptech/PHP_Project/index.php?pages=home"><b>Go to Shop</b></a></div>
        </div>
    <?php if (empty($cart)): ?>
            <div class="cart-empty" id="cartempty"><h5>Your cart is currently empty.</h5></div>
            <div id="cartempty"><a href="http://localhost/project_aptech/PHP_Project/index.php?pages=home"><b>Go to Shop</b></a></div>
    <?php else: ?>
        <div id="div-cart-table">
            <table class="cart-table" id="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
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
                            <td class="cart-item-quantity">
                                <input type="number" class="quantity-input" value="<?= $item['quantity'] ?>" min="1" data-id="<?= $item['id'] ?>">
                            </td>
                            <td class="cart-item-total"><?= number_format($itemTotal, 0, ',', '.') ?> VND</td>
                            <td class="cart-item-action actions">
                                <button class="btn-remove" data-id="<?= $item['id'] ?>">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3 class="cart-total">Total: <?= number_format($total, 0, ',', '.') ?> VND</h3>
            <button class="btn-checkout">Checkout</button>
        </div>
        
    <?php endif; ?>

    <!-- Popup cho lựa chọn đăng nhập hoặc mua hàng không cần đăng nhập -->
    <div class="popup" id="checkout-popup" style="display: none;">
        <div class="popup-content">
            <h2>Confirmation required</h2>
            <p>You can log in to check out or purchase without logging in?</p>
            <button id="login-button">Login</button>
            <button id="guest-button">Purchase without logging in</button><br>
            <button id="close-popup">Close</button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Khi bấm vào nút "Xóa"
            $('.btn-remove').click(function() {
                const productId = $(this).data('id');  // Lấy ID sản phẩm từ data-id

                // Gửi yêu cầu AJAX để xóa sản phẩm khỏi giỏ hàng
                $.ajax({
                    url: 'remove_from_cart.php',  // Đường dẫn tới file PHP xử lý
                    type: 'POST',
                    data: { id: productId },
                    success: function(response) {
                        const result = JSON.parse(response);

                        if (result.status === 'success') {
                            // Xóa sản phẩm khỏi giao diện HTML
                            $('#cart-item-' + productId).remove();

                            // Cập nhật tổng tiền
                            updateTotal();

                            // Kiểm tra xem giỏ hàng có trống không
                            if ($('#cart-body tr').length === 0) {
                                $('#div-cart-table').hide(); // Ẩn bảng giỏ hàng
                                document.getElementById('div-cart-empty').style.display = 'block';
                            }

                            alert(result.message);
                        } else {
                            alert(result.message);
                        }
                    },
                    error: function() {
                        alert('Đã xảy ra lỗi khi xóa sản phẩm khỏi giỏ hàng.');
                    }
                });
            });

            // Khi thay đổi số lượng
            $('.quantity-input').change(function() {
                const productId = $(this).data('id');
                const newQuantity = $(this).val();

                // Gửi yêu cầu AJAX để cập nhật số lượng sản phẩm
                $.ajax({
                    url: 'update_cart.php',  // Đường dẫn tới file PHP xử lý
                    type: 'POST',
                    data: { id: productId, quantity: newQuantity },
                    success: function(response) {
                        const result = JSON.parse(response);

                        if (result.status === 'success') {
                            // Cập nhật tổng tiền
                            updateTotal();
                            alert(result.message);
                        } else {
                            alert(result.message);
                        }
                    },
                    error: function() {
                        alert('Đã xảy ra lỗi khi cập nhật số lượng.');
                    }
                });
            });

            // Hàm cập nhật tổng tiền sau khi xóa sản phẩm
            function updateTotal() {
                let total = 0;

                $('.cart-item-total').each(function() {
                    const itemTotal = $(this).text().replace(' VND', '').replace(/\./g, '');
                    total += parseInt(itemTotal);
                });

                $('.cart-total').text('Tổng tiền: ' + total.toLocaleString('vi-VN') + ' VND');
            }
        });


        $(document).ready(function() {
            // Cập nhật tổng tiền khi thay đổi số lượng sản phẩm
            $('.quantity-input').on('change', function() {
                const productId = $(this).data('id');
                const quantity = parseInt($(this).val());
                const price = parseFloat($('#cart-item-' + productId + ' .cart-item-price').text().replace(' VND', '').replace(/\./g, ''));

                // Tính toán tổng cho sản phẩm này
                const itemTotal = price * quantity;

                // Cập nhật tổng cho sản phẩm
                $('#cart-item-' + productId + ' .cart-item-total').text(itemTotal.toLocaleString('vi-VN') + ' VND');

                // Cập nhật tổng tiền của giỏ hàng
                updateTotal();
            });

            // Hàm cập nhật tổng tiền sau khi thay đổi số lượng
            function updateTotal() {
                let total = 0;

                $('.cart-item-total').each(function() {
                    const itemTotal = $(this).text().replace(' VND', '').replace(/\./g, '');
                    total += parseInt(itemTotal);
                });
                $('.cart-total').text('Tổng tiền: ' + total.toLocaleString('vi-VN') + ' VND');
            }
        });




        $(document).ready(function() {
            // Khi bấm vào nút "Thanh toán"
            const checklogin = <?= json_encode($mycartname) ?>; // Truyền giá trị PHP sang JavaScript
            $('.btn-checkout').click(function() {
                // Ẩn giỏ hàng
                $('#cart-table').hide(); // Ẩn bảng giỏ hàng

                if (checklogin !== "") {
                    $.ajax({
                        url: 'http://localhost/project_aptech/PHP_Project/src/Pages/My_cart/save_cart_to_session.php',  // Tạo file PHP để lưu giỏ hàng
                        type: 'POST',
                        data: { cart: JSON.stringify(<?= json_encode($cart) ?>) }, // Truyền giỏ hàng dưới dạng JSON
                        success: function(response) {
                            window.location.href = 'http://localhost/project_aptech/PHP_Project/src/Pages/My_cart/Payment.php'; // Chuyển hướng đến trang thanh toán
                        },
                        error: function() {
                            alert('Đã xảy ra lỗi khi lưu giỏ hàng.');
                        }
                    });
                } else {
                    // Nếu chưa đăng nhập, hiển thị popup
                    $('#checkout-popup').fadeIn();
                }
            });

            // Đóng popup
            $('#close-popup').click(function() {
                $('#checkout-popup').fadeOut();
                $('#cart-table').show(); // Hiển thị lại bảng giỏ hàng khi đóng popup
            });
        });

        document.getElementById("login-button").addEventListener("click", function() {
            // Chuyển hướng đến trang khác (ví dụ: trang đăng nhập)
            window.location.href = "http://localhost/project_aptech/PHP_Project/src/Login/LoginForm.php"; // Đường dẫn đến trang khác
        });
        document.getElementById("guest-button").addEventListener("click", function() {
            // Chuyển hướng đến trang khác (ví dụ: trang đăng nhập)
            window.location.href = "http://localhost/project_aptech/PHP_Project/src/Pages/My_cart/PaymentNotLog.php"; // Đường dẫn đến trang khác
        });
    </script>
    
</body>
</html>

<?php
include_once PUBLIC_PATH . 'footer.php'; 
?>
