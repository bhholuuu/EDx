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
</head>

<body>
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