<?php
session_start();

// Bao gồm header
include_once __DIR__ . '/../Public/header.php';
// Khởi tạo mảng lưu các URL
$urls = [];

try {
    // Truy vấn để lấy các URL với id không liên tục (1, 2, 5, 7, 8)
    $stmt = $pdo->prepare("SELECT image_id, image_path FROM tbl_images WHERE image_id IN (1, 2, 3, 4, 5)");
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

        <!-- Categories section -->
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

        <!-- Featured products section -->
        <section class="featured-products container my-5">
            <h2 class="text-center mb-4">Featured Products</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="public/img/1256600_slot1.jpg" alt="Product 1" class="img-fluid">
                        <h5>Product 1</h5>
                        <p>$50.00</p>
                        <a href="#" class="product-link">Add to Cart</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="public/img/1256600_slot2.jpg" alt="Product 2" class="img-fluid">
                        <h5>Product 2</h5>
                        <p>$60.00</p>
                        <a href="#" class="product-link">Add to Cart</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="public/img/1256600_slot3.jpg" alt="Product 3" class="img-fluid">
                        <h5>Product 3</h5>
                        <p>$70.00</p>
                        <a href="#" class="product-link">Add to Cart</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="public/img/Body-Fit-Active-Highlight.jpg" alt="Product 4" class="img-fluid">
                        <h5>Product 4</h5>
                        <p>$80.00</p>
                        <a href="#" class="product-link">Add to Cart</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
// Bao gồm footer
include_once __DIR__ . '/../Public/footer.php';
?>