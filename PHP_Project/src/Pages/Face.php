<?php

include_once __DIR__ . '/../Public/header.php';
?>
<link rel="stylesheet" href="src/Pages/css/Face.css">
<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_aptech"; // Thay bằng tên cơ sở dữ liệu của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn sản phẩm từ bảng `product`
$sql = " SELECT p.product_id, p.product_name, p.price, i.image_path 
FROM tbl_products p
LEFT JOIN tbl_images i on i.image_id = p.image_id
GROUP BY p.product_id, p.product_name, p.price, i.image_path ";
$result = $conn->query($sql);

// Hiển thị sản phẩm
if ($result->num_rows > 0) {
    echo '<main class="container">';
    echo '<div class="product-grid">';

    while ($row = $result->fetch_assoc()) {
        
        $productId = $row['product_id'];
        echo '<div class="product-item" id="product-' . $productId . '">';  

         echo '<img src="' .$row["image_path"] .'">';
        echo '<h3>' . $row["product_name"] . '</h3>';
        echo '<p>From ' . $row["price"] . ' VND</p>';
        echo '<button>Mua hàng</button>'; 

        echo '</div>';
    }

    echo '</div>';
    echo '</main>'; 
} else {
    echo "Không có sản phẩm nào.";
}

$conn->close();
?>
<?php

include_once __DIR__ . '/../Public/footer.php';
?>
