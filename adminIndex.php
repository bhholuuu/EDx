<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Check if the logged-in user is 'admin'
if ($_SESSION['username'] !== 'admin') {
    // Redirect to login or show an error
    header("Location: login.php?error=unauthorized");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="assets/css/adminIndex.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="header">
        <div class="logo">
            <a href="adminIndex.php"><img src="assets/img/logo.png" alt="logo"></a>
        </div>
        <div class="heading">
            <h1>Admin Panel</h1>
        </div>
        <div class="account">
            <!-- <a href="#" title="Profile"><img src="assets/img/bhavya.jpg" alt=""></a> -->
            <a href="./assets/php/logout.php" title="Logout" style="padding-right:20px;"><i
                    class="fa-solid fa-right-from-bracket" style="font-size: 30px; color: #fff;"></i></a>
        </div>
    </div>
    <div class="mainBody">
        <div class="navigation">
            <button onclick="loadContent('assets/php/adminPages/dashboard')">Dashboard</button>
            <button onclick="loadContent('assets/php/adminPages/users')">Users</button>
            <button onclick="loadContent('assets/php/adminPages/categories')">Categories</button>
            <button onclick="loadContent('assets/php/adminPages/courses')">Courses</button>
            <button onclick="loadContent('assets/php/adminPages/videos')">Videos</button>
            <button onclick="loadContent('assets/php/adminPages/quiz')">Quiz</button>
            <button onclick="loadContent('assets/php/adminPages/comments')">Comments</button>
        </div>
        <div id="content">
            <!-- Content will be loaded here -->
        </div>
    </div>
    <script src="assets/js/adminApp.js"></script>
    <script>
    // Automatically load the home page content when the page is opened
    window.onload = function() {
        loadContent('assets/php/adminPages/dashboard');
    };
    </script>
</body>

</html>