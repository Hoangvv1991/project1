<?php
session_start();
// Lấy thông tin username từ session
$username = $_SESSION['username'];

include 'src/api/db_connect.php';

$sql = "SELECT * 
                FROM tbl_users u
                WHERE u.deleted = 0 
                AND u.user_email = (
                    SELECT c.customer_email 
                    FROM tbl_customers c
                    WHERE c.deleted = 0 
                    AND c.customer_email = :username
                );";

$user_status = $pdo->prepare($sql);
$user_status->bindParam(':username', $username);
$user_status->execute();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="src/Public/header.css">
    <title>Claris</title>
</head>

<body>
    <header>
        <div></div>
        <ul>
            <li>
                <form action="">
                    <input type="text" id="check" placeholder="   Looking for something ?">
                    <button><span><i class="bi bi-search"></i></span></button>
                </form>
            </li>
            <li><a class="logo" href="index.php?pages=home"><img src="src/Public/larins_png.png" alt="Logo"></a></li>
            <li>
                <ul>
                    <li>
                        <a href="">
                            <span><i class="bi bi-phone" style="font-size: 1.5rem;"></i></span>
                            <div class="smalltext">Contact Us </div>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span><i class="bi bi-bag-check" style="font-size: 1.5rem;"></i></span>
                            <div class="smalltext">My Cart </div>
                        </a>
                    </li>
                    <?php if (($user_status->rowCount()>0)): ?>
                        <li>
                            <a href="src/admin/admin.php">
                                <span><i class="bi bi-person-workspace" style="font-size: 1.5rem;"></i></span>
                                <div class="smalltext">Admin Dashboard</div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['username'])): ?>
                        <!-- Nếu đã đăng nhập, hiển thị icon và link tới trang cá nhân -->
                        <li>
                            <a href="src/Login/User_profile.php">
                                <span><i class="bi bi-person-circle" style="font-size: 1.5rem;"></i></span>
                                <div class="smalltext"><?= $_SESSION['username']; ?></div>
                            </a>
                        </li>
                        <li>
                            <a href="src/Login/Logout.php">
                                <span><i class="bi bi-box-arrow-right" style="font-size: 1.5rem;"></i></span>
                                <div class="smalltext">Logout</div>
                            </a>
                        </li>
                    <?php else: ?>
                        <!-- Nếu chưa đăng nhập, hiển thị icon và link đăng nhập -->
                        <li>
                            <a href="src/Login/LoginForm.php">
                                <span><i class="bi bi-person-vcard" style="font-size: 1.5rem;"></i></span>
                                <div class="smalltext">Login</div>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
        <nav class="navbar" style="justify-content: center">
            <ul class="menu">
                <li class="menuface">
                    <a href="index.php?pages=face">FACE</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                    </div>
                </li>
                <li class="menuface">
                    <a href="index.php?pages=body">BODY</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                    </div>
                </li>
                <li class="menuface">
                    <a href="index.php?pages=hair">HAIR</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                    </div>
                </li>
                <li class="menuface">
                    <a href="index.php?pages=makeup">MAKE.UP</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                    </div>
                </li>
                <li class="menuface">
                    <a href="index.php?pages=perfumes">PERFUMES</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                    </div>
                </li>
                <li class="menuface">
                    <a href="index.php?pages=sunscreen">SUNSCREEN</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                        <div class="menu-item">
                            <a href="#">Option 1</a>
                            <a href="#">Sub Option 1</a>
                            <a href="#">Sub Option 2</a>
                            <a href="#">Sub Option 3</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <link rel="stylesheet" href="src/Pages/css/Main_list.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


</body>

</html>