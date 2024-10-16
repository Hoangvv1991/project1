<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Lấy thông tin username từ session
$session_login = '';
$full_name = '';
$admin = '';
if (isset($_SESSION['session_login'])) {
    $session_login = $_SESSION['session_login'];

    include API_PATH . 'db_connect.php';

    $sql = "SELECT 
                CASE
                    WHEN u.user_name IS NOT NULL
                    THEN 1
                    ELSE 0
                    END AS admin,
                    c.*
                FROM tbl_customers c
                LEFT JOIN tbl_users u
                ON u.user_email = c.customer_email
                AND u.deleted = 0
                WHERE c.deleted = 0 
                AND c.session_login = :session_login;";



    $customer_status = $pdo->prepare($sql);
    $customer_status->bindParam(':session_login', $session_login);
    $customer_status->execute();

    // Kiểm tra xem có kết quả không
    if ($customer_status->rowCount() > 0) {
        $customer_data = $customer_status->fetch(PDO::FETCH_ASSOC);
        $full_name = $customer_data['customer_name']; // Gán customer_name vào $full_name
        $admin =    $customer_data['admin'];
    } else {
        $full_name = ''; // Nếu không tìm thấy customer_name
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
                        <a class="icon-link" href="<?php echo LOCAL_URL . 'src/Pages/contact_us.php' ?>">
                            <span><i class="bi bi-phone" style="font-size: 1.5rem;"></i></span>
                            <div class="smalltext">Contact Us </div>
                        </a>
                    </li>
                    <li>
                        <a class="icon-link" href="<?php echo LOCAL_URL . 'src/Pages/My_cart/Mycart.php' ?>">
                            <span><i class="bi bi-bag-check" style="font-size: 1.5rem;"></i></span>
                            <div class="smalltext">My Cart </div>
                        </a>
                    </li>
                    <?php if ($admin > 0): ?>
                        <li>
                            <a class="icon-link" href="<?php echo LOCAL_URL . 'src/admin/admin.php' ?>">
                                <span><i class="bi bi-person-workspace" style="font-size: 1.5rem;"></i></span>
                                <div class="smalltext">Admin</div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['session_login'])): ?>
                        <li>
                            <a class="icon-link" href="<?php echo LOCAL_URL . 'src/Login/User_profile/User_profile.php' ?>">
                                <span><i class="bi bi-person-circle" style="font-size: 1.5rem;"></i></span>
                                <div class="smalltext"><?= htmlspecialchars($full_name); ?></div>
                            </a>
                        </li>
                        <li>
                            <a class="icon-link" href="<?php echo LOCAL_URL . 'src/Login/Logout.php' ?>">
                                <span><i class="bi bi-box-arrow-right" style="font-size: 1.5rem;"></i></span>
                                <div class="smalltext">Logout</div>
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a class="icon-link" href="<?php echo LOCAL_URL . 'src/Login/LoginForm.php' ?>">
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
                    <a class="animation-hov" href="<?php echo LOCAL_URL . 'index.php?pages=face' ?>">FACE</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a class="animation-hov" href="#">Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 2</a>
                            <a class="animation-hov" href="#">Sub Option 3</a>
                        </div>

                    </div>
                </li>
                <li class="menuface">
                    <a class="animation-hov" href="<?php echo LOCAL_URL . 'index.php?pages=body' ?>">BODY</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a class="animation-hov" href="#">Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 2</a>
                            <a class="animation-hov" href="#">Sub Option 3</a>
                        </div>

                    </div>
                </li>
                <li class="menuface">
                    <a class="animation-hov" href="<?php echo LOCAL_URL . 'index.php?pages=hair' ?>">HAIR</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a class="animation-hov" href="#">Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 2</a>
                            <a class="animation-hov" href="#">Sub Option 3</a>
                        </div>

                    </div>
                </li>
                <li class="menuface">
                    <a class="animation-hov" href="<?php echo LOCAL_URL . 'index.php?pages=makeup' ?>">MAKE.UP</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a class="animation-hov" href="#">Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 2</a>
                            <a class="animation-hov" href="#">Sub Option 3</a>
                        </div>

                    </div>
                </li>
                <li class="menuface">
                    <a class="animation-hov" href="<?php echo LOCAL_URL . 'index.php?pages=perfumes' ?>">PERFUMES</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a class="animation-hov" href="#">Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 2</a>
                            <a class="animation-hov" href="#">Sub Option 3</a>
                        </div>

                    </div>
                </li>
                <li class="menuface">
                    <a class="animation-hov" href="<?php echo LOCAL_URL . 'index.php?pages=sunscreen' ?>">SUNSCREEN</a></button>
                    <div class="menu-content">
                        <div class="menu-item">
                            <a class="animation-hov" href="#">Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 1</a>
                            <a class="animation-hov" href="#">Sub Option 2</a>
                            <a class="animation-hov" href="#">Sub Option 3</a>
                        </div>

                    </div>
                </li>
            </ul>
            <div class="clock-container">
                <div class="clock-col">
                    <p class="clock-day clock-timer">
                    </p>
                    <p class="clock-label">
                        Day
                    </p>
                </div>
                <div class="clock-col">
                    <p class="clock-hours clock-timer">
                    </p>
                    <p class="clock-label">
                        Hours
                    </p>
                </div>
                <div class="clock-col">
                    <p class="clock-minutes clock-timer">
                    </p>
                    <p class="clock-label">
                        Minutes
                    </p>
                </div>
                <div class="clock-col">
                    <p class="clock-seconds clock-timer">
                    </p>
                    <p class="clock-label">
                        Seconds
                    </p>
                </div>
            </div>
        </nav>

    </header>

    <link rel="stylesheet" href="<?php echo LOCAL_URL . 'src/Pages/css/Main_list.css'; ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>


    <script>
        document.querySelectorAll('.menuface').forEach(menu => {
            menu.addEventListener('mouseent class="animation-hov"er', () => {
                const content = menu.querySelector('.menu-content');
                if (content) {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });

            menu.addEventListener('mouselea class="animation-hov"ve', () => {
                const content = menu.querySelector('.menu-content');
                if (content) {
                    content.style.maxHeight = null;
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () =>
            requestAnimationFrame(updateTime)
        );

        function updateTime() {
            document.documentElement.style.setProperty('--timer-day', "'" + moment().format("dd") + "'");
            document.documentElement.style.setProperty('--timer-hours', "'" + moment().format("k") + "'");
            document.documentElement.style.setProperty('--timer-minutes', "'" + moment().format("mm") + "'");
            document.documentElement.style.setProperty('--timer-seconds', "'" + moment().format("ss") + "'");
            requestAnimationFrame(updateTime);
        }
    </script>


</body>

</html>