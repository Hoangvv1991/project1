<?php
session_start();
// Lấy thông tin username từ session
$username = $_SESSION['username'];
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
        <ul> 
            <li>       
                <div class="logo-left">
                    <img src="./../../Public/larins_png.png" alt="Company Logo">
                </div>
                </li>
                <li>
                <div class="user-icon">
                    <img id="avatar" src="avt.jpg" alt="User Avatar" class="avatar">
                    <div class="smalltext"><?= $_SESSION['username']; ?></div>
                </div>
            </li>
        </ul>    
    </header>
