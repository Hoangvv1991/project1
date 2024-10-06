<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang login
    header("Location: ../Login/LoginForm.php");
    exit();
}

// Lấy thông tin username từ session
$username = $_SESSION['username'];


// Bao gồm header
// include_once __DIR__ . '/../Public/header.php';
include_once __DIR__ . '/../Public/header.php';
?>
    <link rel="stylesheet" href="src/Pages/css/Home.css">

<body>
    <main class="container">
          <!-- Main banner section -->
    <section class="banner">
        <div class="banner-content">
            <img src="https://www.clarinsusa.com/on/demandware.static/-/Library-Sites-clarins-v3/en_US/dw2e2a0688/Desktop%20version%201280x599@2x.jpg" alt="Main Banner" class="img-fluid">
            <div class="banner-text">
                <h1>Discover Our Bestsellers</h1>
                <a href="#" class="btn btn-primary">Shop Now</a>
            </div>
        </div>
    </section>

    <!-- Categories section -->
    <section class="categories container my-5">
        <h2 class="text-center mb-4">Shop By Category</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="category-card">
                    <img src="https://www.clarinsusa.com/on/demandware.static/-/Library-Sites-clarins-v3/default/dw1da3e757/Homepage_CBA/Highlights/LAUNCHES/2024_DS_Gen_9/Highlight_DOUBLE-SERUM_2024.jpg_master.jpg" alt="Face" class="img-fluid">
                    <a href="#" class="category-link">Face</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="category-card">
                    <img src="https://www.clarinsusa.com/on/demandware.static/-/Library-Sites-clarins-v3/default/dw16b869dd/Homepage_CBA/Highlights/PRODUCT_LAUNCH/2024_%20LIP_OIL_BALM/CBA_HP_Highlight_LIP-OIL-BALM_2024_Cherry-APAC.jpg" alt="Body" class="img-fluid">
                    <a href="#" class="category-link">Body</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="category-card">
                    <img src="https://www.clarinsusa.com/on/demandware.static/-/Library-Sites-clarins-v3/en_US/dw83d274ca/homepage/Body-Fit-Active-Highlight.jpg" alt="Makeup" class="img-fluid">
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
                    <a href="#" class="btn btn-outline-primary">Add to Cart</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product-card">
                    <img src="public/img/1256600_slot2.jpg" alt="Product 2" class="img-fluid">
                    <h5>Product 2</h5>
                    <p>$60.00</p>
                    <a href="#" class="btn btn-outline-primary">Add to Cart</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product-card">
                    <img src="public/img/1256600_slot3.jpg" alt="Product 3" class="img-fluid">
                    <h5>Product 3</h5>
                    <p>$70.00</p>
                    <a href="#" class="btn btn-outline-primary">Add to Cart</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="product-card">
                    <img src="public/img/Body-Fit-Active-Highlight.jpg" alt="Product 4" class="img-fluid">
                    <h5>Product 4</h5>
                    <p>$80.00</p>
                    <a href="#" class="btn btn-outline-primary">Add to Cart</a>
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