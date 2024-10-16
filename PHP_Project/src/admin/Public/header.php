<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include API_PATH . 'db_connect.php';

$session_login = '';
$full_name = '';
$customer_avatar = 'public\img\avt.jpg';
if (isset($_SESSION['session_login'])) {
    $session_login = $_SESSION['session_login'];

    $sql = "SELECT  *
                 FROM tbl_users u
                 LEFT JOIN tbl_customers c ON c.customer_email = u.user_email
                 WHERE u.deleted = 0 AND c.session_login = :session_login";

    $user_status = $pdo->prepare($sql);
    $user_status->bindParam(':session_login', $session_login);
    $user_status->execute();

    if ($user_status->rowCount() > 0) {
        $user_data = $user_status->fetch(PDO::FETCH_ASSOC);
        $full_name = $user_data['full_name'];
        if (isset($user_data['customer_image_path'])) {
            $customer_avatar = $user_data['customer_image_path'];
        }
    } else {
        $full_name = '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo LOCAL_URL . 'src\admin\Public\style.css' ?>">
</head>

<body>
    <header>
        <ul>
            <li>
                <div class="logo-left">
                    <img src="<?php echo LOCAL_URL . 'src/Public/larins_png.png' ?>" alt="Company Logo">
                </div>
            </li>
            <li>
                <div class="user-icon">
                    <img id="avatar" src="<?php echo LOCAL_URL . htmlspecialchars($customer_avatar) ?>" alt="User Avatar" class="avatar">
                    <div class="smalltext"><?= htmlspecialchars($full_name); ?></div>
                </div>
            </li>
        </ul>
    </header>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>