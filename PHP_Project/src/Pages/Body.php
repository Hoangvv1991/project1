<?php
include_once __DIR__ . '/../Public/header.php';
?>
<link rel="stylesheet" href="src/Pages/css/Main_list.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<?php

include 'src/api/db_connect.php';

// Thiết lập số lượng sản phẩm trên mỗi trang
$products_per_page = 10;

// Lấy tổng số sản phẩm từ bảng `tbl_products`
$sql_total = "SELECT COUNT(*) AS total 
    FROM tbl_products p 
    LEFT JOIN tbl_images i ON i.image_id = p.image_id
    INNER JOIN tbl_categories c ON c.category_id = p.category_id
    WHERE c.category_id = 2";

try {
    $stmt_total = $pdo->query($sql_total);
    $total_products = $stmt_total->fetchColumn(); // Trả về tổng số sản phẩm

    if ($total_products === false) {
        echo "Không thể lấy tổng số sản phẩm.";
        exit();  // Thoát nếu không thể lấy tổng số sản phẩm
    }
} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
    exit();
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
    $sql = "SELECT p.product_code, p.product_name, p.price, i.image_path, c.category_id
     FROM tbl_products p 
    LEFT JOIN tbl_images i ON i.image_id = p.image_id
    INNER JOIN tbl_categories c ON c.category_id = p.category_id
    WHERE c.category_id = 2
    -- GROUP BY p.product_code, p.product_name, p.price, i.image_path, c.category_id
        LIMIT :start_from, :products_per_page";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
    $stmt->bindParam(':products_per_page', $products_per_page, PDO::PARAM_INT);
    $stmt->execute();

    // Hiển thị sản phẩm
    if ($stmt->rowCount() > 0) {
        echo '<main class="container">';
        echo '<div class="product-grid">';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productId = $row['product_code'];
            echo '<div class="product-item" id="product-' . htmlspecialchars($productId) . '">';
            echo '<img src="' . htmlspecialchars($row["image_path"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">';
            echo '<h3 class="product-title">' . htmlspecialchars($row["product_name"]) . '</h3>';
            echo '<p>From ' . htmlspecialchars($row["price"]) . ' VND</p>';
            echo '<button>Mua hàng</button>';
            echo '</div>';
        }

        echo '</div>';
        echo '</main>';
    } else {
        echo "Không có sản phẩm nào để hiển thị.";
    }
} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
}

// Tạo liên kết phân trang
?>

 <nav aria-label="...">
     <ul class="pagination" style="justify-content: center">
         <li class="page-item <?php echo ($current_page == 1) ? 'disabled' : ''; ?>">
           <a class="page-link" href="?index.php?pages=face&page=<?php echo ($current_page > 1) ? ($current_page - 1) : 1; ?>" tabindex="-1">Previous</a>
         </li>
             <?php
                 for ($i = 1; $i <= $number_of_pages; $i++) {
                     echo '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '">';
                     echo '<a class="page-link" href="index.php?pages=face&page=' . $i . '">' . $i;
                     if ($current_page == $i) {
                         echo ' <span class="sr-only">(current)</span>';
                     }
                     echo '</a></li>';
                 }
             ?>
         <li class="page-item <?php echo ($current_page == $number_of_pages) ? 'disabled' : ''; ?>">
           <a class="page-link" href="index.php?pages=face&page=<?php echo ($current_page < $number_of_pages) ? ($current_page + 1) : $number_of_pages; ?>">Next</a>
         </li>
     </ul>
 </nav>






<?php
include_once __DIR__ . '/../Public/footer.php';
?>
