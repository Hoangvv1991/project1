<?php
session_start();
// Bao gồm header
include_once __DIR__ . '/../Public/header.php';
// Khởi tạo mảng lưu các URL
$urls = [];
$product_codes = [];
global $pdo;
try {
    // Truy vấn để lấy các URL với id không liên tục (1, 2, 5, 7, 8)
    $stmt = $pdo->prepare("SELECT image_id, image_path FROM tbl_images WHERE image_id IN (1, 2, 3, 4, 5, 6, 7, 8)");
    $stmt->execute();

    // Lấy tất cả kết quả truy vấn
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Lặp qua các kết quả và lưu vào mảng với key là id
    foreach ($results as $row) {
        $urls[$row['image_id']] = $row['image_path'];
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

try {
    $product_codes = [$urls[5], $urls[6], $urls[7], $urls[8]];
    $product_code_string = "'" . implode("','", $product_codes) . "'";
    // Truy vấn để lấy danh sách sản phẩm
    $sql = "SELECT p.product_code, p.product_name, p.price, i.image_path, c.category_id
            FROM tbl_products p
            LEFT JOIN tbl_images i ON i.image_id = p.image_id
            INNER JOIN tbl_categories c ON c.category_id = p.category_id
            WHERE p.deleted = 0 AND p.product_code IN ($product_code_string)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Lấy tất cả kết quả truy vấn
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Lặp qua các kết quả và lưu vào mảng với key là id
} catch (PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
}

$pdo = null;

?>
<link rel="stylesheet" href="<?php echo LOCAL_URL . 'src/Pages/css/Home.css' ?>">

<body>
    <main class="container">
        <section class="banner">
            <div class="banner-content">
                <img src="<?php echo LOCAL_URL . htmlspecialchars($urls[1] ?? ''); ?>" alt="Main Banner" class="img-fluid">
                <div class="banner-text">
                    <h1>Discover Our Bestsellers</h1>
                </div>
            </div>
        </section>

        <section class="categories container my-5">
            <h2 class="text-center mb-4">Shop By Category</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="category-card">
                        <img src="<?php echo LOCAL_URL . htmlspecialchars($urls[2] ?? ''); ?>" alt="Face" class="img-fluid">
                        <a href="#" class="category-link">Face</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card">
                        <img src="<?php echo LOCAL_URL . htmlspecialchars($urls[3] ?? ''); ?>" alt="Body" class="img-fluid">
                        <a href="#" class="category-link">Body</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="category-card">
                        <img src="<?php echo LOCAL_URL . htmlspecialchars($urls[4] ?? ''); ?>" alt="Makeup" class="img-fluid">
                        <a href="#" class="category-link">Makeup</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="featured-products container my-5">
            <h2 class="text-center mb-4">Featured Products</h2>
            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-3">
                            <div class="product-card">
                                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="img-fluid">
                                <h5><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                <p>$<?php echo number_format($product['price'], 2); ?></p>
                                <a href="#" class="product-link">Add to Cart</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No Products!</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
// Bao gồm footer
include_once __DIR__ . '/../Public/footer.php';
?>