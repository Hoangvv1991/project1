    <?php
        // Lấy thông tin từ form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars($_POST['name']);
            $phone = htmlspecialchars($_POST['phone']);
            $gender = htmlspecialchars($_POST['gender']);
            $dob = htmlspecialchars($_POST['dob']);
            $email = htmlspecialchars($_POST['email']);

            // Kiểm tra và xử lý dữ liệu
            $errors = [];

            // Kiểm tra email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ.";
            }

            // Kiểm tra tuổi
            $dobDate = new DateTime($dob);
            $today = new DateTime();
            $age = $today->diff($dobDate)->y;

            if ($age < 10) {
                $errors[] = "Bạn phải lớn hơn 10 tuổi.";
            }

            // Nếu không có lỗi, bạn có thể lưu vào cơ sở dữ liệu hoặc xử lý theo cách bạn muốn
            if (empty($errors)) {
                // Xử lý dữ liệu như lưu vào cơ sở dữ liệu...
                echo "<script>alert('Cập nhật thành công thông tin của bạn!');</script>";
                echo "<script>document.getElementById('displayName').innerText = '$name';</script>";
                echo "<script>document.getElementById('displayPhone').innerText = '$phone';</script>";
                echo "<script>document.getElementById('displayGender').innerText = \"" . ($gender == 'male' ? 'Nam' : ($gender == 'female' ? 'Nữ' : 'Không xác định')) . "\";</script>";
            } else {
                // Nếu có lỗi, hiển thị lỗi
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
                        
        }
        
    ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout 4:6 với Menu Dọc Thu Gọn</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Các style đã có trước đó */
        .hidden {
            display: none; /* Ẩn phần */
        }
        .container {
            margin-top: 50px;
        }

        .icon {
            font-size: 100px;
            margin: 20px 0;
            text-align: center;
        }

        .hidden {
            display: none;
        }

        label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }

        .form-control {
            width: 500px;
            border-radius: 10px;
            transition: border-color 0.3s;
        }

        .form-control:hover {
            border-color: red;
        }
        #menu a{
            font-weight: bold;
        }
        #menu a:hover {
            color: red;
        }

        #menu {
            padding-left: 100px;
        }
        #profileInfo p strong{
            margin: 0 10px; /* Khoảng cách bên trái và bên phải */
        }
        #profileInfo p span{
            font-weight: bold;
        }
        #profileInfo{
            text-align: left;
            width: 300px;
            margin: auto;
        }
        #profileInfo h2{
            text-align: center;
        }
        #profileInfo p{
            display: flex;
            justify-content: space-between; /* Khoảng cách đều giữa các phần tử */
            align-items: center; /* Căn giữa dọc */
            margin-top: 20px;
            border-bottom: 1px solid gray;
            padding-bottom: 10px;
        }
        #profileInfo h3{
            text-align: center;
            color: orangered;
        }
        #profileInfo button{
            margin: auto;
            display: block;
            text-align: center;
            margin-top: 30px;
        }
        #iconUser{
            color: orangered;
            font-size: 100px;
        }
        /* Các style khác... */
    </style>
</head>

<body>
    <div class="container-fluid">
        <h5><a href="http://localhost/project_aptech/PHP_Project/index.php?pages=home">Home</a>/User Profile</h5>
        <div class="row">
            <!-- Cột 4 phần - chứa menu dọc -->
            <div class="col-md-4">
                <button class="btn btn-primary d-md-none" type="button" data-toggle="collapse" data-target="#menu"
                    aria-expanded="false" aria-controls="menu">
                    Menu
                </button>
                <div class="sidebar collapse d-md-block" id="menu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-target="profileInfo" onclick="showSection('profileInfo')">Hồ Sơ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-target="orders" onclick="showSection('orders')">Đơn Hàng Của Tôi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-target="customers" onclick="showSection('customers')">Khách Hàng Thân Thiết</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-target="addresses" onclick="showSection('addresses')">Địa Chỉ Nhận Hàng</a>
                        </li>
                        <li class="nav-item">
                            <a href="src/Login/Logout.php">
                                <span><i class="bi bi-box-arrow-right" style="font-size: 1.5rem;"></i></span>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Cột 6 phần - chứa nội dung chính -->
            <div class="col-md-6 content">
                <div class="container text-center">   
                    <div id="profileInfo">
                        <h3>Profile User</h3>
                        <h2><i class="bi bi-person-circle" id="iconUser"></i></h2>
                        <p><strong>Họ Tên:</strong> <span id="displayName">Quốc Vương</span></p>
                        <p><strong>SĐT:</strong> <span id="displayPhone">0123456789</span></p>
                        <p><strong>Giới Tính:</strong> <span id="displayGender">Nam</span></p>
                        <button class="btn btn-primary" onclick="toggleEditForm()">Chỉnh Sửa Thông Tin</button>
                    </div>
                    <!-- chinh sửa tt -->
                    <div id="editForm" class="hidden">
                        <h4>Chỉnh Sửa Thông Tin</h4>
                        <form id="profileEditForm" action="your-server-endpoint.php" method="POST" onsubmit="return updateProfile()">
                            <div class="form-group">
                                <label for="name">Họ Tên:</label>
                                <input type="text" class="form-control" id="name" name="name" value="Quốc Vương" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">SĐT:</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="0123456789" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Giới Tính:</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="male" selected>Nam</option>
                                    <option value="female">Nữ</option>
                                    <option value="other">Không xác định</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dob">Ngày Sinh:</label>
                                <input type="date" class="form-control" id="dob" name="dob" required max="" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="example@example.com" required>
                            </div>
                            <button type="submit" class="btn btn-success">Lưu Thay Đổi</button>
                            <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Hủy</button>
                        </form>
                    </div>
                    <div id="orders" class="hidden">Nội dung Đơn Hàng Của Tôi...</div>
                    <div id="customers" class="hidden">Nội dung Khách Hàng Thân Thiết...</div>
                    <div id="addresses" class="hidden">Nội dung Địa Chỉ Nhận Hàng...</div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function showSection(sectionId) {
            const sections = ['profileInfo', 'orders', 'customers', 'addresses', 'logout'];
            sections.forEach(section => {
                const el = document.getElementById(section);
                if (section === sectionId) {
                    el.classList.remove('hidden'); // Hiển thị phần được chọn
                } else {
                    el.classList.add('hidden'); // Ẩn các phần khác
                }
            });
        }

        // Các hàm khác (toggleEditForm, cancelEdit, updateProfile, v.v.)
        // Thiết lập ngày tối đa cho ô ngày sinh
        const today = new Date();
        const tenYearsAgo = new Date();
        tenYearsAgo.setFullYear(today.getFullYear() - 10);
        document.getElementById('dob').max = tenYearsAgo.toISOString().split("T")[0];

        function toggleEditForm() {
        const profileInfo = document.getElementById('profileInfo');
        const editForm = document.getElementById('editForm');
        profileInfo.classList.toggle('hidden');
        editForm.classList.toggle('hidden');
        }

        function cancelEdit() {
        const profileInfo = document.getElementById('profileInfo');
        const editForm = document.getElementById('editForm');
        profileInfo.classList.remove('hidden');
        editForm.classList.add('hidden');
        }

        function updateProfile() {
        // Lấy giá trị từ biểu mẫu
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const gender = document.getElementById('gender').value;
        const email = document.getElementById('email').value;
        const dob = document.getElementById('dob').value;

        // Kiểm tra định dạng email
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email)) {
        alert("Email không đúng định dạng!");
        return false;
        }

        // Kiểm tra ngày sinh
        const dobDate = new Date(dob);
        const today = new Date();
        const age = today.getFullYear() - dobDate.getFullYear();
        const monthDiff = today.getMonth() - dobDate.getMonth();
        const isAdult = age > 10 || (age === 10 && monthDiff >= 0);

        if (!isAdult) {
        alert("Bạn phải lớn hơn 10 tuổi!");
        return false;
        }

        // Cập nhật thông tin hiển thị
        document.getElementById('displayName').innerText = name;
        document.getElementById('displayPhone').innerText = phone;
        document.getElementById('displayGender').innerText = gender === 'male' ? 'Nam' : (gender === 'female' ? 'Nữ' : 'Không xác định');

        // Ẩn phần chỉnh sửa và hiện phần thông tin
        cancelEdit();

        // Hiện thông báo cập nhật thành công
        alert("Thông tin đã được cập nhật!");
        return false; // Ngăn không cho form thực sự gửi
        }
    </script>
</body>

</html>










