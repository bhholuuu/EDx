<?php
session_start();
require '_connectionDb.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $username = trim($_POST['loginUsername'] ?? '');
    $password = trim($_POST['loginPassword'] ?? '');

    // Admin credentials
    $adminUsername = 'admin';
    $adminPassword = 'admin';

    // Admin login check
    if ($username === $adminUsername && $password === $adminPassword) {
        // Set session for admin
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'admin';
        header("Location: ../../adminIndex.php");
        exit;
    } else {
        // Query to check normal users in the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE userName = :username AND Password = :password");
        $stmt->execute([
            ':username' => $username,
            ':password' => $password
        ]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Valid user credentials
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['userName'];
            $_SESSION['role'] = 'user';
            header("Location: ../../index.php");
            exit;
        } else {
            // Invalid credentials
            $error = "User doesn't exist or incorrect password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login, Signup & Reset Password</title>
    <style>
    /* General Reset */
    body {
        background-color: #d9d9d9;
        margin: 0;
        font-family: 'Arial', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #374f59;
    }

    .outerBody {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #d9d9d9;
        width: 100vw;
        height: 100vh;
    }

    /* Form Container Styling */
    .form {
        display: none;
        /* Forms are hidden by default */
        flex-direction: column;
        align-items: center;
        border: 2px solid #374f59;
        padding: 40px 30px;
        background-color: #35636d;
        border-radius: 15px;
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        width: 400px;
        /* Increased width */
        text-align: center;
    }

    .form h1 {
        color: #d9d9d9;
        font-size: 26px;
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* Input Fields */
    .form form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .form form input {
        margin-bottom: 20px;
        padding: 14px;
        border: 2px solid #374f59;
        border-radius: 8px;
        background-color: #d1d1d1;
        /* Slightly darker shade for inputs */
        color: #374f59;
        font-size: 15px;
        font-weight: bold;
        box-shadow: inset 0px 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .form form input:focus {
        outline: none;
        border-color: #35636d;
        box-shadow: 0px 0px 8px #35636d;
        background-color: #ececec;
        /* Brighter focus shade */
    }

    /* Buttons */
    .form form button {
        padding: 14px;
        border: none;
        border-radius: 8px;
        background-color: #374f59;
        color: #d9d9d9;
        cursor: pointer;
        font-size: 17px;
        font-weight: bold;
        text-transform: uppercase;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .form form button:hover {
        background-color: #2b454e;
        /* Slightly darker shade on hover */
        transform: scale(1.03);
    }

    .form form button:active {
        transform: scale(0.98);
    }

    /* Text Links */
    .form form p {
        margin-top: 15px;
        font-size: 15px;
        color: #d9d9d9;
    }

    .form form p a {
        color: #d9d9d9;
        font-weight: bold;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        transition: color 0.3s ease, border-bottom 0.3s ease;
    }

    .form form p a:hover {
        color: #374f59;
        border-bottom: 2px solid #374f59;
    }

    /* Default Form Display */
    #loginForm {
        display: flex;
    }

    .error {
        color: #FF4136;
        font-weight: bold;
        text-shadow: 1px 1px 10px #ffffff;
        font-size: 20px;
    }
    </style>
</head>

<body>
    <div class="outerBody">

        <!-- Login Form -->
        <div class="form login" id="loginForm">
            <h1>LogIn</h1>
            <?php
            if (isset($error)) {
                echo "<p class='error'>$error</p>";
            }
            ?>
            <form action="" method="POST">
                <input type="text" name="loginUsername" placeholder="Username" required>
                <input type="password" name="loginPassword" placeholder="Password" required>
                <button type="submit" name="login">LogIn</button>
                <p>Forgot Password? <a href="#" id="toForgotPassword">Click here</a></p>
                <p>Don't have an account? <a href="#" id="toSignup">Click here</a></p>
            </form>
        </div>

        <!-- Signup Form -->
        <div class="form signup" id="signupForm" style="display: none;">
            <h1>SignUp</h1>
            <form action="signup.php" method="POST">
                <input type="text" name="signupUsername" placeholder="Username" required>
                <input type="text" name="signupFirstName" placeholder="First Name" required>
                <input type="text" name="signupLastName" placeholder="Last Name" required>
                <input type="password" id="signupPassword" name="signupPassword" placeholder="Password" required>
                <input type="password" id="signupcPassword" name="signupcPassword" placeholder="Confirm Password"
                    required>
                <input type="text" name="signupFavThing" placeholder="Favourite Thing">
                <button type="submit" name="signup">SignUp</button>
                <p style="color: red; display: none;" id="passwordError">Passwords do not match!</p>
                <p>Already have an account? <a href="#" id="toLoginFromSignup">Click here</a></p>
            </form>
        </div>

        <!-- Forgot Password Form -->
        <div class="form forgotPassword" id="forgotPasswordForm" style="display: none;">
            <h1>Reset Password</h1>
            <form action="resetPassword.php" method="POST">
                <input type="text" name="forPassUsername" placeholder="Username" required>
                <input type="text" name="forPassFavouriteThing" placeholder="Favourite Thing" required>
                <input type="password" name="forPassNewPassword" placeholder="New Password" required>
                <input type="password" name="forPasscNewPassword" placeholder="Confirm New Password" required>
                <button type="submit" name="forPassResetPassword">Reset Password</button>
                <p>Back to LogIn? <a href="#" id="toLoginFromForgot">Click here</a></p>
            </form>
        </div>

    </div>

    <script>
    // JavaScript to toggle between forms
    const toSignup = document.getElementById('toSignup');
    const toLoginFromSignup = document.getElementById('toLoginFromSignup');
    const toForgotPassword = document.getElementById('toForgotPassword');
    const toLoginFromForgot = document.getElementById('toLoginFromForgot');

    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');

    toSignup.addEventListener('click', () => {
        loginForm.style.display = 'none';
        signupForm.style.display = 'flex';
    });

    toLoginFromSignup.addEventListener('click', () => {
        signupForm.style.display = 'none';
        loginForm.style.display = 'flex';
    });

    toForgotPassword.addEventListener('click', () => {
        loginForm.style.display = 'none';
        forgotPasswordForm.style.display = 'flex';
    });

    toLoginFromForgot.addEventListener('click', () => {
        forgotPasswordForm.style.display = 'none';
        loginForm.style.display = 'flex';
    });
    </script>
</body>

</html>