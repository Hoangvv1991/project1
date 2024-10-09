<?php
session_start();
// Lấy thông tin username từ session
$session_login = $_SESSION['session_login'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo-left">
            <img src="./../../Public/larins_png.png" alt="Company Logo">
        </div>
        <div class="user-icon">
            <img src="assets/img/user_icon.png" alt="User Icon">
            <div class="smalltext"><?= $_SESSION['session_login']; ?></div>
        </div>
    </header>
