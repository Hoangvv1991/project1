<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="loginform2.css"> <!-- Đường dẫn đến file CSS -->
</head>
<body>
    <div class="login-container">
        <div class="card-inner">
            <!-- Card Login -->
            <div class="card-login">
                <form id="login-form" class="login-form" method="post" action="login.php">
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

            <!-- Card Register -->
            <div class="card-register">
                <form id="register-form" class="login-form" method="post" action="register.php" onsubmit="return validateForm()">
                    <h2 class="login-title">Register</h2>

                    <!-- Full Name -->
                    <div class="input-group">
                        <label for="full-name">Họ và Tên:</label>
                        <input type="text" id="full_name" name="full_name" class="login-input" required />
                        <div id="full_name-error" class="text-danger" style="display:none;"></div>
                    </div>

                    <!-- Username -->
                    <div class="input-group">
                        <label for="register-username">Username:</label>
                        <input type="text" id="username" name="register_username" class="login-input" required />
                        <div id="username-error" class="text-danger" style="display:none;"></div>
                    </div>

                    <!-- Email -->
                    <div class="input-group">
                        <label for="register-email">Email:</label>
                        <input type="email" id="email" name="register_email" class="login-input" required />
                        <div id="email-error" class="text-danger" style="display:none;"></div>
                    </div>

                    <!-- Phone -->
                    <div class="input-group">
                        <label for="register-phone">Số Điện Thoại:</label>
                        <input type="tel" id="register-phone" name="register_phone" class="login-input" required />
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <label for="register-password">Password:</label>
                        <input type="password" id="password" name="register_password" class="login-input" required />
                    </div>

                    <!-- Confirm Password -->
                    <div class="input-group">
                        <label for="confirm-password">Xác Nhận Mật Khẩu:</label>
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
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const username = document.getElementById('username').value;
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
                document.getElementById('username').value = ""; // Clear the username
                document.getElementById('username').focus(); // Focus on the username field
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