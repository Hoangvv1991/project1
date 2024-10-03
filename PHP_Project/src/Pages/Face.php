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

// Thiết lập số lượng sản phẩm trên mỗi trang
$products_per_page = 10;

// Lấy tổng số sản phẩm từ bảng `tbl_products`
$sql_total = "SELECT COUNT(*) AS total FROM tbl_products";
$result_total = $conn->query($sql_total);

if ($result_total && $result_total->num_rows > 0) {
    $row_total = $result_total->fetch_assoc();
    $total_products = $row_total['total'];
} else {
    echo "Không thể lấy tổng số sản phẩm.";
    exit();  // Thoát nếu không thể lấy tổng số sản phẩm
}

// Tính toán tổng số trang
$number_of_pages = ceil($total_products / $products_per_page);

// Xác định trang hiện tại từ URL (mặc định là trang 1 nếu không có giá trị)
if (!isset($_GET['page']) || $_GET['page'] <= 0) {
    $current_page = 1;
} else {
    $current_page = intval($_GET['page']);
}

// Kiểm tra và đảm bảo trang hiện tại không vượt quá số trang hợp lệ
if ($current_page > $number_of_pages) {
    $current_page = $number_of_pages;
}

// Tính toán sản phẩm bắt đầu hiển thị trên trang hiện tại
$start_from = ($current_page - 1) * $products_per_page;

// Kiểm tra lại giá trị $start_from
if ($start_from < 0) {
    $start_from = 0;
}

// Truy vấn sản phẩm từ bảng `tbl_products` với giới hạn là 10 sản phẩm mỗi trang
$sql = "SELECT p.product_id, p.product_name, p.price, i.image_path 
        FROM tbl_products p
        LEFT JOIN tbl_images i ON i.image_id = p.image_id
        GROUP BY p.product_id, p.product_name, p.price, i.image_path
        LIMIT $start_from, $products_per_page";
$result = $conn->query($sql);

// Kiểm tra truy vấn SQL
if ($result === false) {
    echo "Truy vấn SQL bị lỗi: " . $conn->error;
    exit();
}

// Hiển thị sản phẩm
if ($result->num_rows > 0) {
    echo '<main class="container">';
    echo '<div class="product-grid">';

    while ($row = $result->fetch_assoc()) {
        $productId = $row['product_id'];
        echo '<div class="product-item" id="product-' . $productId . '">';
        echo '<img src="' . $row["image_path"] . '" alt="' . $row["product_name"] . '">';
        echo '<h3>' . $row["product_name"] . '</h3>';
        echo '<p>From ' . $row["price"] . ' VND</p>';
        echo '<button>Mua hàng</button>';
        echo '</div>';
    }

    echo '</div>';
    echo '</main>';
} else {
    echo "Không có sản phẩm nào để hiển thị.";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>

<!-- Tạo liên kết phân trang -->
<div class="pagination">
    <?php
    // Hiển thị liên kết "Trang trước" nếu không phải trang đầu tiên
    if ($current_page > 1) {
        echo '<a href="products.php?page=' . ($current_page - 1) . '">Previous</a> ';
    }

    // Hiển thị các liên kết trang
    for ($page = 1; $page <= $number_of_pages; $page++) {
        if ($page == $current_page) {
            echo '<strong>' . $page . '</strong> ';
        } else {
            echo '<a href="products.php?page=' . $page . '">' . $page . '</a> ';
        }
    }

    // Hiển thị liên kết "Trang sau" nếu không phải trang cuối cùng
    if ($current_page < $number_of_pages) {
        echo '<a href="products.php?page=' . ($current_page + 1) . '">Next</a> ';
    }
    ?>
</div>

<?php
include_once __DIR__ . '/../Public/footer.php';
?>
