<?php
session_start();

if (isset($_POST['cart'])) {
    $cart = json_decode($_POST['cart'], true);
    $_SESSION['cart'] = $cart;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Không có giỏ hàng để lưu.']);
}
