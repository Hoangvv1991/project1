<?php
// Initialize variables and error messages
$username = $password = $confirm_password = $email = $phone = $full_name = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $full_name = trim($_POST["full_name"]);

    // Validate fields
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (strlen($username) > 8) {
        $errors[] = "Username must be at most 8 characters.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }

    if (empty($full_name)) {
        $errors[] = "Full Name is required.";
    }

    // If there are no errors, process data storage
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Connect to the database and save user information here
        // Example: save $username, $hashed_password, $full_name, $email, $phone to the database
        echo "Registration successful!";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Add link to Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap"
    rel="stylesheet"> 
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./RegisterForm.css">
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

        // Call hideErrorMessages function when the page loads
        window.onload = hideErrorMessages;
    </script>
</head>
<body>
    <div class="container mt-5" id="container">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" onsubmit="return validateForm();">
            <h2 class="text-center title-3d" >Welcome to Clanris</h2>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>
                <div id="username-error" class="text-danger" style="display:none;"></div>
            </div>

            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo htmlspecialchars($full_name); ?>" required>
                <div id="full_name-error" class="text-danger" style="display:none;"></div>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                <div id="password-error" class="text-danger" style="display:none;"></div>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                <div id="email-error" class="text-danger" style="display:none;"></div>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block" id="button">Register</button>
        </form>
    </div>

    <!-- Add link to Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
