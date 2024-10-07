<?php
session_start();
session_unset(); // Xóa tất cả các biến session
session_destroy(); // Hủy session

// Chuyển hướng về trang home sau khi đăng xuất
header("Location: ../../index.php?pages=home");
exit();
?>
