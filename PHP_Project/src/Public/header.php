<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Lấy thông tin username từ session
$session_login = '';
$full_name = '';
$count = 0;
if (isset($_SESSION['session_login'])){
    $session_login = $_SESSION['session_login'];

    include API_PATH . 'db_connect.php';

    $sql = "SELECT  *
                    FROM tbl_users u
                    WHERE u.deleted = 0 
                    AND u.user_email = (
                        SELECT c.customer_email 
                        FROM tbl_customers c
                        WHERE c.deleted = 0 
                        AND c.session_login = :session_login
                    );";

    $user_status = $pdo->prepare($sql);
    $user_status->bindParam(':session_login', $session_login);
    $user_status->execute();



    if ($user_status->rowCount() > 0) {
        $user_data = $user_status->fetch(PDO::FETCH_ASSOC);
        $full_name = $user_data['full_name'];
        $count = 1;
    }else{
        $sql_customer = "SELECT *
                 FROM tbl_customers 
                 WHERE deleted = 0 
                 AND session_login = :session_login";

        $customer_status = $pdo->prepare($sql_customer);
        $customer_status->bindParam(':session_login', $session_login);
        $customer_status->execute();

        // Kiểm tra xem có kết quả không
        if ($customer_status->rowCount() > 0) {
            $customer_data = $customer_status->fetch(PDO::FETCH_ASSOC);
            $full_name = $customer_data['customer_name']; // Gán customer_name vào $full_name
        } else {
            $full_name = ''; // Nếu không tìm thấy customer_name
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo LOCAL_URL . 'src/Public/header.css' ?>">
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
            <li><a class="logo" href="<?php echo LOCAL_URL . 'index.php?pages=home' ?>"><img src="<?php echo LOCAL_URL . 'src/Public/larins_png.png' ?>" alt="Logo"></a></li>
            <li>
                <ul>
                    <li>
                        <a href="">
                            <span><i class="bi bi-phone" style="font-size: 1.5rem;"></i></span>
                            <div class="smalltext">Contact Us </div>
                        </a>
                    </li>
                    <li>
                        <a href="src/Pages/Mycart.php">
                            <span><i class="bi bi-bag-check" style="font-size: 1.5rem;"></i></span>
                            <div class="smalltext">My Cart </div>
                        </a>
                    </li>
                    <?php if ($count > 0): ?>
                        <li>
                            <a href="<?php echo LOCAL_URL . 'src/admin/admin.php' ?>">
                                <span><i class="bi bi-person-workspace" style="font-size: 1.5rem;"></i></span>
                                <div class="smalltext">Admin</div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['session_login'])): ?>
                        <!-- Nếu đã đăng nhập, hiển thị icon và link tới trang cá nhân -->
                        <li>
                            <a href="src/Login/User_profile/User_profile.php">
                                <span><i class="bi bi-person-circle" style="font-size: 1.5rem;"></i></span>
                                <div class="smalltext"><?= htmlspecialchars($full_name); ?></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo LOCAL_URL . 'src/Login/Logout.php' ?>">
                                <span><i class="bi bi-box-arrow-right" style="font-size: 1.5rem;"></i></span>
                                <div class="smalltext">Logout</div>
                            </a>
                        </li>
                    <?php else: ?>
                        <!-- Nếu chưa đăng nhập, hiển thị icon và link đăng nhập -->
                        <li>
                            <a href="<?php echo LOCAL_URL . 'src/Login/LoginForm.php' ?>">
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
                    <a href="<?php echo LOCAL_URL . 'index.php?pages=face' ?>">FACE</a></button>
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
                    <a href="<?php echo LOCAL_URL . 'index.php?pages=body' ?>">BODY</a></button>
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
                    <a href="<?php echo LOCAL_URL . 'index.php?pages=hair' ?>">HAIR</a></button>
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
                    <a href="<?php echo LOCAL_URL . 'index.php?pages=makeup' ?>">MAKE.UP</a></button>
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
                    <a href="<?php echo LOCAL_URL . 'index.php?pages=perfumes' ?>">PERFUMES</a></button>
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
                    <a href="<?php echo LOCAL_URL . 'index.php?pages=sunscreen' ?>">SUNSCREEN</a></button>
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

    <link rel="stylesheet" href="<?php echo LOCAL_URL . 'src/Pages/css/Main_list.css' ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


</body>

</html>