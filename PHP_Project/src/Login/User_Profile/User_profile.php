<?php
include_once __DIR__ . '../../../../config.php';
include_once PUBLIC_PATH . 'header.php';
include API_PATH . 'db_connect.php';
?>

<!-- lấy dữ liệu người dùng -->
<?php
    $confirm_guid = $customer_data['customer_guid'];
    $customer_phone = $customer_data['customer_phone'];
    $customer_address = $customer_data['customer_address'];
    $customer_city = $customer_data['customer_city'];
    $customer_email = $customer_data['customer_email'];
    if (isset($customer_data['customer_image_path'])) {
       $customer_avatar = $customer_data['customer_image_path'];
    } else {
        $customer_avatar = 'public\img\avt.jpg'; // Hoặc bất kỳ giá trị mặc định nào bạn muốn
    }

?>
<!-- ẩn email -->
<?php
    function maskEmail($customer_email) {
        // Tìm vị trí của dấu '@'
        $atPosition = strpos($customer_email, '@');
        
        // Nếu không tìm thấy dấu '@', trả về email gốc
        if ($atPosition === false) {
            return $customer_email;
        }
        
        // Tách tên người dùng và miền
        $username = substr($customer_email, 0, $atPosition);
        $domain = substr($customer_email, $atPosition);
    
        // Lấy 3 ký tự đầu tiên
        $maskedUsername = substr($username, 0, 3) . '...';
    
        // Kết hợp lại
        return $maskedUsername . $domain;
    }
    
    // Ví dụ sử dụng
    $maskedEmail = maskEmail($customer_email);
?>



<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NewName = htmlspecialchars($_POST['name']);
    $NewPhone = htmlspecialchars($_POST['phone']);
    $NewCity = htmlspecialchars($_POST['city']);
    $NewEmail = htmlspecialchars($_POST['email']);
    $NewAddress = htmlspecialchars($_POST['address']); // Nhận địa chỉ từ form
    
    // Kiểm tra và xử lý dữ liệu
    $errors = [];

    // Kiểm tra email
    if (!filter_var($NewEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email.";
    }

    // Nếu không có lỗi
    if (empty($errors)) {
        // Cập nhật vào bảng tbl_customers
        $sql = "UPDATE tbl_customers SET 
                    customer_name = :customer_name, 
                    customer_email = :customer_email, 
                    customer_phone = :customer_phone, 
                    customer_city = :customer_city,
                    customer_address = :customer_address  -- Cập nhật địa chỉ nhận hàng
                WHERE deleted = 0 
                AND session_login = :session_login";

        // Chuẩn bị câu lệnh SQL và gán giá trị cho các tham số
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':customer_name', $NewName);
        $stmt->bindParam(':customer_email', $NewEmail);
        $stmt->bindParam(':customer_phone', $NewPhone);
        $stmt->bindParam(':customer_city', $NewCity); 
        $stmt->bindParam(':customer_address', $NewAddress); // Gán địa chỉ mới
        $stmt->bindParam(':session_login', $session_login);

        // Thực hiện câu lệnh
        if ($stmt->execute()) {
            echo "<script>
                    alert('Your information has been successfully updated!');
                    // document.getElementById('displayName').innerText = '$NewName';
                    // document.getElementById('displayPhone').innerText = '$NewPhone';
                    // document.getElementById('displayCity').innerText = '$NewCity'; 
                    resetForm();
                  </script>";
            header("Location: http://localhost/project_aptech/PHP_Project/index.php?pages=home");
        } else {
            echo "<div class='alert alert-danger'>Update failed.</div>";
        }
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
    <title>User Profile</title>
    <link rel="stylesheet" href="<?PHP echo LOCAL_URL . 'src/login/User_Profile/User_profile.css'?>">
</head>

<body>
    <main class="container">
        <div class="container-fluid">
            <h5><a href="<?PHP echo LOCAL_URL . 'index.php?pages=home'?>">Home</a>/User Profile</h5>
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
                                <a class="nav-link active" href="#" data-target="profileInfo" onclick="showSection('profileInfo')">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-target="orders" onclick="showSection('orders')">My Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-target="customers" onclick="showSection('customers')">Loyal Customers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-target="addresses" onclick="showSection('addresses')">Shipping Address</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Cột 6 phần - chứa nội dung chính -->
                <div class="col-md-6 content">
                    <div class="container text-center">   
                        <div id="profileInfo">
                            <h3>User Profile</h3>
                            <div class="avatar-container" data-toggle="modal" data-target="#uploadModal">
                                <img src="<?php echo LOCAL_URL . htmlspecialchars($customer_avatar); ?>" alt="Avatar" id="avatar-image">
                                <i class="fas fa-camera camera-icon"></i>
                            </div>
                            <p><strong>Full Name:</strong> <span id="displayName"><?= htmlspecialchars($full_name); ?></span></p>
                            <p><strong>Phone Number:</strong> <span id="displayPhone"><?= htmlspecialchars($customer_phone); ?></span></p>
                            <p><strong>City:</strong> <span id="displayCity"><?= htmlspecialchars($customer_city); ?></span></p>
                            <button class="btn btn-primary" onclick="toggleEditForm()">Edit Information</button>
                        </div>
                        <!-- Edit information -->
                        <div id="editForm" class="hidden">
                            <h4>Edit Information</h4>
                            <form id="profileEditForm" action="http://localhost/project_aptech/PHP_Project/src/login/User_Profile/User_profile.php" method="POST" onsubmit="return updateProfile()" novalidate>
                                <div class="form-group">
                                    <label for="name">Full Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($full_name); ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number:</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($customer_phone); ?>" >
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <select class="form-control" id="city" name="city" >
                                        <option value="<?= htmlspecialchars($customer_city); ?>"><?= htmlspecialchars($customer_city); ?></option>
                                        <option value="Hà Nội">Hà Nội</option>
                                        <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                                        <option value="Đà Nẵng">Đà Nẵng</option>
                                        <option value="Hải Phòng">Hải Phòng</option>
                                        <option value="Cần Thơ">Cần Thơ</option>
                                        <option value="An Giang">An Giang</option>
                                        <option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</option>
                                        <option value="Bắc Giang">Bắc Giang</option>
                                        <option value="Bắc Ninh">Bắc Ninh</option>
                                        <option value="Bến Tre">Bến Tre</option>
                                        <option value="Bình Định">Bình Định</option>
                                        <option value="Bình Dương">Bình Dương</option>
                                        <option value="Bình Phước">Bình Phước</option>
                                        <option value="Cà Mau">Cà Mau</option>
                                        <option value="Đắc Lắc">Đắc Lắc</option>
                                        <option value="Đắc Nông">Đắc Nông</option>
                                        <option value="Điện Biên">Điện Biên</option>
                                        <option value="Hà Giang">Hà Giang</option>
                                        <option value="Hà Nam">Hà Nam</option>
                                        <option value="Hà Tĩnh">Hà Tĩnh</option>
                                        <option value="Hải Dương">Hải Dương</option>
                                        <option value="Hòa Bình">Hòa Bình</option>
                                        <option value="Hưng Yên">Hưng Yên</option>
                                        <option value="Khánh Hòa">Khánh Hòa</option>
                                        <option value="Kiên Giang">Kiên Giang</option>
                                        <option value="Kon Tum">Kon Tum</option>
                                        <option value="Lai Châu">Lai Châu</option>
                                        <option value="Lâm Đồng">Lâm Đồng</option>
                                        <option value="Lang Son">Lang Son</option>
                                        <option value="Lào Cai">Lào Cai</option>
                                        <option value="Nam Định">Nam Định</option>
                                        <option value="Ninh Bình">Ninh Bình</option>
                                        <option value="Ninh Thuận">Ninh Thuận</option>
                                        <option value="Phú Thọ">Phú Thọ</option>
                                        <option value="Phú Yên">Phú Yên</option>
                                        <option value="Quảng Bình">Quảng Bình</option>
                                        <option value="Quảng Nam">Quảng Nam</option>
                                        <option value="Quảng Ngãi">Quảng Ngãi</option>
                                        <option value="Quảng Ninh">Quảng Ninh</option>
                                        <option value="Quảng Trị">Quảng Trị</option>
                                        <option value="Sóc Trăng">Sóc Trăng</option>
                                        <option value="Sơn La">Sơn La</option>
                                        <option value="Tây Ninh">Tây Ninh</option>
                                        <option value="Thái Bình">Thái Bình</option>
                                        <option value="Thái Nguyên">Thái Nguyên</option>
                                        <option value="Thanh Hóa">Thanh Hóa</option>
                                        <option value="Thừa Thiên - Huế">Thừa Thiên - Huế</option>
                                        <option value="Tiền Giang">Tiền Giang</option>
                                        <option value="Trà Vinh">Trà Vinh</option>
                                        <option value="Tuyên Quang">Tuyên Quang</option>
                                        <option value="Vĩnh Long">Vĩnh Long</option>
                                        <option value="Vĩnh Phúc">Vĩnh Phúc</option>
                                        <option value="Yên Bái">Yên Bái</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="<?= htmlspecialchars($maskedEmail); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="address">Shipping Address:</label>
                                    <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($customer_address); ?>" required>
                                </div>
                                <button type="submit" class="btn btn-success" >Save</button>
                                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancle</button>
                            </form>
                        </div>
                        <div id="orders" class="hidden">Nội dung Đơn Hàng Của Tôi...</div>
                        <div id="customers" class="hidden">Nội dung Khách Hàng Thân Thiết...</div>
                        <div id="addresses" class="hidden">
                            <h3>Shipping Address:</h3>
                            <!-- Hiển thị địa chỉ -->
                            <div id="address-display">
                                <p><?php echo $customer_address; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Popup Upload Image -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Avatar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="<?php echo LOCAL_URL . htmlspecialchars($customer_avatar); ?>" alt="Current Avatar" id="current-avatar" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                <form id="uploadForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($confirm_guid); ?>"> 
                        <label for="avatar">Choose a new avatar (jpg, png, gif):</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept=".jpg, .png, .gif" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" id="cancelButton" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <script>

    $(document).ready(function () {
        $('.avatar-container').click(function () {
            $('#uploadModal').modal('show');
        });

        $('#uploadForm').submit(function(event) {
        event.preventDefault(); // Ngăn chặn gửi form mặc định

        // Thêm AJAX để gửi dữ liệu đến PHP (bạn có thể thay đổi URL và cách xử lý theo nhu cầu)
        $.ajax({
            url: 'upload_avatar.php', // Thay đổi đường dẫn đến tệp PHP của bạn
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                // Cập nhật ảnh trên giao diện
                $('#avatar-image').attr('src', '<?php echo LOCAL_URL; ?>' + response.new_avatar); // Giả sử response.new_avatar chứa đường dẫn ảnh mới
                $('#uploadModal').modal('hide'); // Đóng modal
            },
            error: function() {
                alert('Failed to upload image.'); // Thông báo lỗi
            }
        });
    });

        $('.close').click(function () {
            $('#uploadModal').modal('hide');
        });
    });

    $('#uploadModal').on('hidden.bs.modal', function() {
        $('#current-avatar').attr('src', '<?php echo LOCAL_URL . htmlspecialchars($customer_avatar); ?>'); // Đặt lại ảnh về ảnh cũ
        $('#avatar').val(''); // Xóa tệp đã chọn
    });

        function resetForm() {
            document.getElementById('name').value = "<?= htmlspecialchars($full_name); ?>";
            document.getElementById('phone').value = "<?= htmlspecialchars($customer_phone); ?>";
            document.getElementById('address').value = "<?= htmlspecialchars($customer_address); ?>";
        }
        function showSection(sectionId) {
            const sections = ['profileInfo', 'orders', 'customers', 'addresses'];
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

        function toggleEditForm() {
            const profileInfo = document.getElementById('profileInfo');
            const editForm = document.getElementById('editForm');
            profileInfo.classList.toggle('hidden');
            editForm.classList.toggle('hidden');
        }
        // Ẩn phần chỉnh sửa và hiện phần thông tin
        function cancelEdit() {
            const profileInfo = document.getElementById('profileInfo');
            const editForm = document.getElementById('editForm');
            profileInfo.classList.remove('hidden');
            editForm.classList.add('hidden');
            resetForm();
        }

        function updateProfile() {
            // Lấy giá trị từ biểu mẫu
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const gender = document.getElementById('city').value;
            const email = document.getElementById('email').value;
            const address = document.getElementById('address').value;

            // Kiểm tra định dạng email
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
            alert("Email format is incorrect!");
            return false;
            }
        }

        // Mở popup upload ảnh
function openImageUploadModal() {
    const imageModal = new bootstrap.Modal(document.getElementById('imageUploadModal'));
    imageModal.show();
}

// Upload ảnh và hiển thị tạm
function uploadProfileImage() {
    const formData = new FormData(document.getElementById('imageUploadForm'));

    fetch('upload_image.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hiển thị ảnh đã upload tạm thời
            document.getElementById('iconUser').src = data.tempImagePath;
        } else {
            alert(data.message || 'Error uploading image');
        }
    })
    .catch(error => console.error('Error:', error));
}

    </script>

</body>

</html>

<?php
include_once PUBLIC_PATH . 'footer.php'; 
?>








