<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Lấy thông tin username từ session
$session_login = '';
$full_name = '';
if (isset($_SESSION['session_login'])) {
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
    <link rel="stylesheet" href="style.css">
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
                    <img id="avatar" src="avt.jpg" alt="User Avatar" class="avatar">
                    <div class="smalltext"><?= htmlspecialchars($full_name); ?></div>
                </div>
            </li>
        </ul>
    </header>