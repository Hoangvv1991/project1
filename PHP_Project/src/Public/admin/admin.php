<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Ngang với Bootstrap</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .navbar-nav {
            flex: 1;
            justify-content: space-evenly;
            /* Căn đều các mục */
        }

        .content {
            display: none;
            /* Ẩn tất cả nội dung */
        }

        .active {
            display: block;
            /* Hiện nội dung đang hoạt động */
        }

        .formadmin {
            margin: 10px;
        }

        #description {
            width: 500px;
        }

        .divadd {
            border-bottom: 2px solid black;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showContent('orderTracking')"><i class="fas fa-truck"></i> Order Tracking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showContent('addEditProducts')"><i class="fas fa-plus-circle"></i> Add or Edit Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showContent('personnelManagement')"><i class="fas fa-users"></i> Personnel Management</a>
                </li>
                <li class="nav-item">
                    <form method="post" action="">
                        <button type="submit" name="logout"><i class="fas fa-sign-out-alt"></i> Log Out</button>
                    </form>
                    <?php
                    // Bắt đầu phiên
                    session_start();

                    // Kiểm tra nếu người dùng đã nhấn nút "Log Out"
                    if (isset($_POST['logout'])) {
                        // Xóa tất cả dữ liệu trong phiên
                        session_unset();
                        session_destroy();

                        // Chuyển hướng về trang đăng nhập
                        header("Location: admin.php"); // Thay đổi đường dẫn nếu cần
                        exit();
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>




    <div class="container mt-3">
        <div id="orderTracking" class="content active">
            <h2>Order Tracking</h2>
            <form method="post" action="">
                <input type="text" name="phone" placeholder="Enter phone number" required>
                <button type="submit">Search</button>
            </form>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $phone = $_POST['phone']; // Lấy số điện thoại từ ô nhập liệu
                $orders = searchOrdersByPhone($phone);

                if (!empty($orders)) {
                    echo "<h3>Kết quả tìm kiếm:</h3>";
                    echo "<ul>";
                    foreach ($orders as $order) {
                        echo "<h4>Đơn hàng ID: " . htmlspecialchars($order['id']) . "</h4>";
                        echo "<p>Số điện thoại: " . htmlspecialchars($order['phone']) . "</p>";
                        // In ra các thông tin khác của đơn hàng
                        // echo "<p>Thông tin khác: " . htmlspecialchars($order['other_column']) . "</p>";
                        echo "<hr>";
                    }
                    echo "</ul>";
                } else {
                    echo "Không tìm thấy đơn hàng nào với số điện thoại $phone.";
                }
            }

            function searchOrdersByPhone($phone)
            {
                // Thay thế các thông tin dưới đây bằng thông tin của bạn
                $host = 'localhost';
                $dbname = 'project_aptech'; // Tên cơ sở dữ liệu
                $username = 'root'; // Tên đăng nhập (mặc định là 'root' trong XAMPP)
                $password = ''; // Mật khẩu (mặc định là rỗng trong XAMPP)

                try {
                    // Kết nối đến cơ sở dữ liệu
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Truy vấn SQL để tìm kiếm theo số điện thoại
                    $sql = "SELECT * FROM tbl_order WHERE phone = :phone";
                    $stmt = $pdo->prepare($sql);

                    // Gán giá trị cho tham số
                    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

                    // Thực thi truy vấn
                    $stmt->execute();

                    // Lấy tất cả kết quả
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo "Lỗi: " . $e->getMessage();
                    return [];
                }
            }
            $conn = null;
            ?>
        </div>


        <!-- Add Edit Products -->

        <div id="addEditProducts" class="content">
            <div class="divadd">
                <form action="upload_product.php" method="POST" enctype="multipart/form-data" class="formadmin">
                    <h1>Enter product information</h1>
                    <input type="text" id="product_id" name="product_id" required placeholder="Enter Product ID"><br><br>

                    <input type="text" id="product_name" name="product_name" required placeholder="Enter Product Name"><br><br>

                    <input type="number" id="price" name="price" step="0.01" required placeholder="Enter Price"><br><br>

                    <input type="number" id="stock" name="stock" required placeholder="Enter Stock"><br><br>

                    <textarea id="description" name="description" required placeholder="Enter Description"></textarea><br><br>

                    <input type="file" id="image_id" name="image_id" accept="image/*" required placeholder="Enter Image ID"><br><br>

                    <input type="submit" value="Submit">
                </form>
                <?php
                $servername = "localhost"; // Tên máy chủ
                $username = "root"; // Tên đăng nhập mặc định là "root"
                $password = ""; // Mật khẩu mặc định là rỗng
                $dbname = "project_aptech"; // Tên cơ sở dữ liệu bạn đã tạo

                try {
                    // Kết nối đến cơ sở dữ liệu
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Kiểm tra nếu có dữ liệu từ biểu mẫu
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Lấy dữ liệu từ biểu mẫu và làm sạch
                        $product_id = $_POST['product_id'];
                        $product_name = $_POST['product_name'];
                        $price = $_POST['price'];
                        $stock = $_POST['stock'];
                        $description = $_POST['description'];

                        // Kiểm tra upload hình ảnh
                        if (isset($_FILES['image_id']) && $_FILES['image_id']['error'] == UPLOAD_ERR_OK) {
                            $image_id = $_FILES['image_id']['name'];
                            $target_dir = "uploads/";
                            $target_file = $target_dir . basename($image_id);
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                            // Kiểm tra định dạng hình ảnh
                            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                            if (!in_array($imageFileType, $allowed_types)) {
                                die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                            }

                            // Chuyển hình ảnh đến thư mục đích
                            if (move_uploaded_file($_FILES['image_id']['tmp_name'], $target_file)) {
                                echo "Image uploaded successfully.<br>";
                            } else {
                                die("An error occurred while loading the image.<br>");
                            }
                        } else {
                            die("No image uploaded or there was an upload error.<br>");
                        }

                        // Chuẩn bị và thực thi câu lệnh SQL
                        $stmt = $conn->prepare("INSERT INTO tbl_products (product_id, product_name, price, stock, description, image_id) VALUES (:product_id, :product_name, :price, :stock, :description, :image_id)");

                        $stmt->bindParam(':product_id', $product_id);
                        $stmt->bindParam(':product_name', $product_name);
                        $stmt->bindParam(':price', $price);
                        $stmt->bindParam(':stock', $stock);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':image_id', $image_id);

                        $stmt->execute();
                        echo "Product added successfully!";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }

                // Đóng kết nối
                $conn = null;
                ?>
            </div>

            <!-- update or delete -->
            <div class="divadd">
                <?php
                $servername = "localhost"; // Tên máy chủ
                $username = "root"; // Tên đăng nhập mặc định
                $password = ""; // Mật khẩu mặc định là rỗng
                $dbname = "project_aptech"; // Tên cơ sở dữ liệu

                $productData = null;

                // Xử lý tìm kiếm
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
                    try {
                        // Kết nối đến cơ sở dữ liệu
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        // Thiết lập chế độ lỗi PDO
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Lấy product_id từ biểu mẫu
                        $product_id = $_POST['product_id'];

                        // Chuẩn bị và thực thi câu lệnh SQL
                        $stmt = $conn->prepare("SELECT * FROM tbl_products WHERE product_id = :product_id");
                        $stmt->bindParam(':product_id', $product_id);
                        $stmt->execute();

                        // Lấy dữ liệu
                        $productData = $stmt->fetch(PDO::FETCH_ASSOC);

                        // Xử lý cập nhật
                        if (isset($_POST['update'])) {
                            $product_name = $_POST['product_name'];
                            $price = $_POST['price'];
                            $stock = $_POST['stock'];
                            $description = $_POST['description'];

                            // Chuẩn bị và thực thi câu lệnh SQL cập nhật
                            $updateStmt = $conn->prepare("UPDATE tbl_products SET product_name = :product_name, price = :price, stock = :stock, description = :description WHERE product_id = :product_id");
                            $updateStmt->bindParam(':product_id', $product_id);
                            $updateStmt->bindParam(':product_name', $product_name);
                            $updateStmt->bindParam(':price', $price);
                            $updateStmt->bindParam(':stock', $stock);
                            $updateStmt->bindParam(':description', $description);
                            $updateStmt->execute();

                            $productData = null; // Đặt lại để tránh hiển thị thông tin cũ
                            echo "<p>Cập nhật sản phẩm thành công!</p>";
                        }
                    } catch (PDOException $e) {
                        echo "Lỗi: " . $e->getMessage();
                    }

                    // Đóng kết nối
                    $conn = null;
                }
                ?>
                <h2>Tìm Kiếm và Cập Nhật Sản Phẩm</h2>
                <form action="" method="post">
                    <label for="product_id">Mã Sản Phẩm:</label>
                    <input type="text" id="product_id" name="product_id" required>
                    <input type="submit" value="Tìm">
                </form>


                <?php if ($productData): ?>
                    <h3>Thông Tin Sản Phẩm</h3>
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($productData['product_id']); ?>">

                        <label for="product_name">Tên Sản Phẩm:</label>
                        <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($productData['product_name']); ?>" required><br><br>

                        <label for="price">Giá:</label>
                        <input type="number" id="price" name="price" value="<?php echo $productData['price']; ?>" step="0.01" required><br><br>

                        <label for="stock">Số Lượng:</label>
                        <input type="number" id="stock" name="stock" value="<?php echo $productData['stock']; ?>" required><br><br>

                        <label for="description">Mô Tả:</label>
                        <textarea id="description" name="description" required><?php echo htmlspecialchars($productData['description']); ?></textarea><br><br>

                        <input type="submit" name="update" value="Cập Nhật">
                    </form>
                <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                    <p>Không tìm thấy sản phẩm với mã sản phẩm này.</p>
                <?php endif; ?>
            </div>

        </div>



        <!-- personnelManagement -->


        <div id="personnelManagement" class="content">
            <h2>Personnel Management</h2>
            <?php
            $servername = "localhost"; // Tên máy chủ
            $username = "root"; // Tên đăng nhập mặc định
            $password = ""; // Mật khẩu mặc định là rỗng
            $dbname = "project_aptech"; // Tên cơ sở dữ liệu

            // Khởi tạo biến thông báo
            $message = "";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    // Kết nối đến cơ sở dữ liệu
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    // Thiết lập chế độ lỗi PDO
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Lấy dữ liệu từ biểu mẫu
                    $adminname = $_POST['adminname'];
                    $adminpassword = $_POST['adminpassword'];
                    $access = $_POST['access'];

                    // Chuẩn bị và thực thi câu lệnh SQL
                    $stmt = $conn->prepare("INSERT INTO tbl_admin (adminName, adminPassword, Access) VALUES (:adminname, :adminpassword, :access)");

                    $stmt->bindParam(':adminname', $adminname);
                    $stmt->bindParam(':adminpassword', $adminpassword);
                    $stmt->bindParam(':access', $access);

                    $stmt->execute();
                    $message = "Thêm quản trị viên thành công!";
                } catch (PDOException $e) {
                    $message = "Error: " . $e->getMessage();
                }

                // Đóng kết nối
                $conn = null;
            }
            ?>

            <!-- Hiển thị thông báo -->
            <?php if ($message): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>

            <form action="" method="post">
                <input type="text" id="adminname" name="adminname" required placeholder="Admin Name"><br><br>

                <input type="password" id="adminpassword" name="adminpassword" required placeholder="Admin Password"><br><br>

                <label for="access">Access Rights:</label>
                <select id="access" name="access" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select><br><br>

                <input type="submit" value="Submit">
            </form>
        </div>



    </div>

    <script>
        function showContent(sectionId) {
            // Ẩn tất cả các nội dung
            const contents = document.querySelectorAll('.content');
            contents.forEach(content => {
                content.classList.remove('active');
            });

            // Hiện nội dung tương ứng
            const activeContent = document.getElementById(sectionId);
            activeContent.classList.add('active');
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>