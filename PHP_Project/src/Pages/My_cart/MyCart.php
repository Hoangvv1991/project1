<?php
session_start();
include_once __DIR__ . '../../../../config.php';
include_once PUBLIC_PATH . 'header.php';
$mycartname = '';
if (isset($_SESSION['session_login'])) {
    $mycartname = $customer_data['customer_name'];
    $mycart_phone = $customer_data['customer_phone'];
    $mycart_address = $customer_data['customer_address'];
}



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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1 class="cart-title">Your Shopping Cart</h1>
    <div id="div-cart-empty" style="display: none;">
        <div class="cart-empty" id="cartempty">
            <h5>Your cart is currently empty.</h5>
        </div>
        <div id="cartempty"><a href="http://localhost/project_aptech/PHP_Project/index.php?pages=home"><b>Go to Shop</b></a></div>
    </div>
    <?php if (empty($cart)): ?>
        <div class="cart-empty" id="cartempty">
            <h5>Your cart is currently empty.</h5>
        </div>
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
                            <td class="cart-item-price"><?= number_format($item['price'], 2, ',', '.') ?> USD</td>
                            <td class="cart-item-quantity">
                                <input type="number" class="quantity-input" value="<?= $item['quantity'] ?>" min="1" data-id="<?= $item['id'] ?>">
                            </td>
                            <td class="cart-item-total"><?= number_format($itemTotal, 2, ',', '.') ?> USD</td>
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
            $('.btn-remove').click(function() {
                const productId = $(this).data('id');

                $.ajax({
                    url: 'remove_from_cart.php',
                    type: 'POST',
                    data: {
                        id: productId
                    },
                    success: function(response) {
                        const result = JSON.parse(response);

                        if (result.status === 'success') {

                            $('#cart-item-' + productId).remove();


                            updateTotal();


                            if ($('#cart-body tr').length === 0) {
                                $('#div-cart-table').hide();
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


            $('.quantity-input').change(function() {
                const productId = $(this).data('id');
                const newQuantity = $(this).val();


                $.ajax({
                    url: 'update_cart.php',
                    type: 'POST',
                    data: {
                        id: productId,
                        quantity: newQuantity
                    },
                    success: function(response) {
                        const result = JSON.parse(response);

                        if (result.status === 'success') {

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

            $('.quantity-input').on('change', function() {
                const productId = $(this).data('id');
                const quantity = parseInt($(this).val());
                const price = parseFloat($('#cart-item-' + productId + ' .cart-item-price').text().replace(' VND', '').replace(/\./g, ''));
                const itemTotal = price * quantity;
                $('#cart-item-' + productId + ' .cart-item-total').text(itemTotal.toLocaleString('vi-VN') + ' VND');
                updateTotal();
            });

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
            const checklogin = <?= json_encode($mycartname) ?>;
            $('.btn-checkout').click(function() {
                $('#cart-table').hide();

                if (checklogin !== "") {
                    $.ajax({
                        url: 'http://localhost/project_aptech/PHP_Project/src/Pages/My_cart/save_cart_to_session.php',
                        type: 'POST',
                        data: {
                            cart: JSON.stringify(<?= json_encode($cart) ?>)
                        },
                        success: function(response) {
                            window.location.href = 'http://localhost/project_aptech/PHP_Project/src/Pages/My_cart/Payment.php';
                        },
                        error: function() {
                            alert('Đã xảy ra lỗi khi lưu giỏ hàng.');
                        }
                    });
                } else {
                    $('#checkout-popup').fadeIn();
                }
            });


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