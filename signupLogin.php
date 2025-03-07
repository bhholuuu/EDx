<?php
include './assets/php/_connectionDb.php';
include './assets/php/samePassword.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login, Signup & Reset Password</title>
    <link rel="stylesheet" href="./assets/css/signupLogin.css">
    <style>
    .avatar-selection {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin: 20px 0;
        justify-items: center;
    }

    .avatar-selection input[type="radio"] {
        display: none;
    }

    .avatar-selection label {
        cursor: pointer;
        transition: transform 0.3s ease, border 0.3s ease;
        border: 2px solid transparent;
        border-radius: 50%;
        padding: 5px;
    }

    .avatar-option {
        width: 80px;
        height: 80px;
        border-radius: 50%;
    }

    .avatar-selection input[type="radio"]:checked+label {
        border-color: #0077cc;
        transform: scale(1.1);
    }

    .avatar-selection label:hover {
        transform: scale(1.05);
    }

    .header {
        background-color: #007bff;
        color: white;
        padding: 15px;
        text-align: left;
        font-size: 20px;
        font-weight: bold;
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .header a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        margin-left: 15px;
    }
    </style>
</head>

<body>
    <div class="header">
        <a href="index.php">Go to Home</a>
    </div>
    <div class="outerBody">

        <!-- Login Form -->
        <div class="form login" id="loginForm">
            <h1>LogIn</h1>
            <form action="assets/php/login.php" method="POST">
                <input type="text" name="loginUsername" placeholder="Username" required>
                <input type="password" name="loginPassword" placeholder="Password" required>
                <button type="submit" name="login">LogIn</button>
                <p>Forgot Password? <a href="#" id="toForgotPassword">Click here</a></p>
                <p>Don't have an account? <a href="#" id="toSignup">Click here</a></p>
            </form>
        </div>

        <!-- Signup Form -->
        <!-- Signup Form -->
        <div class="form signup" id="signupForm" style="display: none;">
            <h1>SignUp</h1>
            <form id="signupForm" action="assets/php/signup.php" method="POST" onsubmit="return validatePasswords()">
                <input type="text" name="signupUsername" placeholder="Username" required>
                <input type="text" name="signupFirstName" placeholder="First Name" required>
                <input type="text" name="signupLastName" placeholder="Last Name" required>
                <input type="password" id="signupPassword" name="signupPassword" placeholder="Password" required>
                <input type="password" id="signupcPassword" name="signupcPassword" placeholder="Confirm Password"
                    required>
                <input type="text" name="signupFavThing" placeholder="Favourite Thing">
                <div class="avatar-selection">
                    <?php
    for ($i = 1; $i <= 8; $i++) {
        $avatarFile = "a$i.png";
        echo '
        <input type="radio" name="signupAvatar" value="' . $avatarFile . '" id="avatar' . $i . '" required>
        <label for="avatar' . $i . '">
            <img src="./assets/img/avatar/' . $avatarFile . '" alt="Avatar" class="avatar-option">
        </label>';
    }
    ?>
                </div>

                <button type="submit" name="signup">SignUp</button>
                <p style="color: red; display: none;" id="passwordError">Passwords do not match!</p>
                <p>Already have an account? <a href="#" id="toLoginFromSignup">Click here</a></p>
            </form>
        </div>

        <!-- Forgot Password Form -->
        <div class="form forgotPassword" id="forgotPasswordForm" style="display: none;">
            <h1>Reset Password</h1>
            <form action="./assets/php/reset.php" method="POST">
                <input type="text" name="forPassUsername" placeholder="Username" required>
                <input type="text" name="forPassFavouriteThing" placeholder="Favourite Thing" required>
                <input type="password" name="forPassNewPassword" placeholder="New Password" required>
                <input type="password" name="forPasscNewPassword" placeholder="Confirm New Password" required>
                <button type="submit" name="forPassResetPassword">Reset Password</button>
                <p>Back to LogIn? <a href="#" id="toLoginFromForgot">Click here</a></p>
            </form>
        </div>
    </div>
    <script src="./assets/js/login.js"></script>
    <script src="./assets/js/samePassword.js"></script>
    <script>
    function validatePasswords() {
        const password = document.getElementById("signupPassword").value;
        const confirmPassword = document.getElementById("signupcPassword").value;

        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
    </script>

</body>

</html>