<?php
include_once __DIR__ . '../../../config.php';

session_start();


include '../api/db_connect.php';


$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {

    $customer_email = $_POST['username'];
    $customer_password  = $_POST['password'];


    $sql = "SELECT * FROM tbl_customers 
            WHERE customer_email = :username
            AND customer_password = :password
            LIMIT 1";

    $stmt = $pdo->prepare($sql);


    $stmt->bindParam(':username', $customer_email);
    $stmt->bindParam(':password', $customer_password);


    $stmt->execute();


    if ($stmt->rowCount() > 0) {

        $new_session_login = md5(uniqid(rand(), true));


        $update_sql = "UPDATE tbl_customers 
                        SET session_login = :session_login, session_date = NOW()
                        WHERE customer_email = :username AND customer_password = :password";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute(['session_login' => $new_session_login, 'username' => $customer_email, 'password' => $customer_password]);

        $_SESSION['session_login'] = $new_session_login;


        header("Location: ../../index.php?page=home");
        exit();
    } else {
        $error = "Thông tin đăng nhập không chính xác!";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_username'])) {

    $customer_code = $_POST['register_username'];
    $customer_name = $_POST['full_name'];
    $customer_email = $_POST['register_email'];
    $customer_password = $_POST['register_password'];
    $customer_phone = $_POST['register_phone'];


    $check_email_sql = "SELECT * FROM tbl_customers WHERE customer_email = :email";
    $check_email_stmt = $pdo->prepare($check_email_sql);
    $check_email_stmt->bindParam(':email', $customer_email);
    $check_email_stmt->execute();

    if ($check_email_stmt->rowCount() > 0) {
        $error = "Email đã tồn tại!";
    } else {

        $insert_sql = "INSERT INTO tbl_customers (customer_code, customer_name, customer_email, customer_password, customer_phone) 
                        VALUES (:customer_code, :customer_name, :customer_email, :customer_password, :customer_phone)";
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->execute([
            'customer_code' => $customer_code,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'customer_password' => $customer_password,
            'customer_phone' => $customer_phone
        ]);


        header("Location: loginForm.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="loginform.css">
</head>

<body>
    <div class="login-container">
        <div class="card-inner">
            <div class="card-login">
                <form id="login-form" class="login-form" method="post" action="loginForm.php">
                    <h2 class="login-title">Login</h2>
                    <div class="input-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="login-input" required />
                    </div>
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="login-input" required />
                    </div>
                    <button type="submit" class="login-button">Login</button>
                    <p class="trans-p" onclick="handleCreateUser()">Create new user</p>
                </form>
            </div>

            <div class="card-register">
                <form id="register-form" class="login-form" method="post" action="LoginForm.php" onsubmit="return validateForm()">
                    <h2 class="login-title">Register</h2>

                    <div class="input-group">
                        <label for="full-name">Full Name:</label>
                        <input type="text" id="full_name" name="full_name" class="login-input" required />
                        <div id="full_name-error" class="text-danger" style="display:none;"></div>
                    </div>

                    <div class="input-group">
                        <label for="register-username">Username:</label>
                        <input type="text" id="register_username" name="register_username" class="login-input" required />
                        <div id="username-error" class="text-danger" style="display:none;"></div>
                    </div>

                    <div class="input-group">
                        <label for="register-email">Email:</label>
                        <input type="email" id="email" name="register_email" class="login-input" required />
                        <div id="email-error" class="text-danger" style="display:none;"></div>
                    </div>

                    <div class="input-group">
                        <label for="register-phone">Phone:</label>
                        <input type="tel" id="register-phone" name="register_phone" class="login-input" required />
                    </div>

                    <div class="input-group">
                        <label for="register-password">Password:</label>
                        <input type="password" id="register_password" name="register_password" class="login-input" required autocomplete="new-password" />
                    </div>

                    <div class="input-group">
                        <label for="confirm-password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="login-input" required />
                        <div id="password-error" class="text-danger" style="display:none;"></div>
                    </div>

                    <button type="submit" class="login-button">Register</button>
                    <p class="trans-p" onclick="handleBackToLogin()">Back to Login</p>
                </form>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('register_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const username = document.getElementById('register_username').value;
            const fullName = document.getElementById('full_name').value;
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');
            const usernameError = document.getElementById('username-error');
            const fullNameError = document.getElementById('full_name-error');

            let valid = true;

            // Reset previous error messages
            usernameError.textContent = "";
            emailError.textContent = "";
            passwordError.textContent = "";
            fullNameError.textContent = "";

            // Validate username length
            if (username.length > 8) {
                usernameError.textContent = "Username must be at most 8 characters.";
                usernameError.style.display = "block";
                document.getElementById('register_username').value = ""; // Clear the username
                document.getElementById('register_username').focus(); // Focus on the username field
                valid = false;
            }

            // Validate email format
            if (!/\S+@\S+\.\S+/.test(email)) {
                emailError.textContent = "Invalid email format.";
                emailError.style.display = "block";
                document.getElementById('email').value = ""; // Clear the email
                document.getElementById('email').focus(); // Focus on the email field
                valid = false;
            }

            // Validate full name
            if (fullName.trim() === "") {
                fullNameError.textContent = "Full Name is required.";
                fullNameError.style.display = "block";
                document.getElementById('full_name').value = ""; // Clear the full name
                document.getElementById('full_name').focus(); // Focus on the full name field
                valid = false;
            }

            // Validate password match
            if (password !== confirmPassword) {
                passwordError.textContent = "Passwords do not match.";
                passwordError.style.display = "block";
                document.getElementById('confirm_password').value = ""; // Clear the confirm password
                document.getElementById('confirm_password').focus(); // Focus on the confirm password field
                valid = false;
            }

            return valid;
        }

        // Function to hide error messages after 5 seconds
        function hideErrorMessages() {
            const errorMessages = document.querySelectorAll('.text-danger');
            errorMessages.forEach(error => {
                if (error.style.display === "block") {
                    setTimeout(() => {
                        error.style.display = "none";
                    }, 5000); // Hide after 5 seconds
                }
            });
        }
        let isFlipped = false;

        function handleCreateUser() {
            isFlipped = true; // Đặt trạng thái thành lật
            const container = document.querySelector('.login-container');
            container.classList.add('is-flipped'); // Thêm lớp lật
        }

        function handleBackToLogin() {
            isFlipped = false; // Đặt trạng thái về không lật
            const container = document.querySelector('.login-container');
            container.classList.remove('is-flipped'); // Xóa lớp lật
        }

        // Call hideErrorMessages function when the page loads
        window.onload = hideErrorMessages;
    </script>
</body>

</html>