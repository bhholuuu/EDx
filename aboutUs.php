<?php
session_start();
include './assets/php/_connectionDb.php'; // Ensure this file connects to your database

// Redirect if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: signupLogin.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
    body {
        font-family: 'Helvetica', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        color: #333;
        line-height: 1.6;
    }

    /* Header styles */
    .header {
        background-color: #35636d;
        color: #fff;
        padding: 20px 40px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .header .logo img {
        width: 60px;
        height: 60px;
        margin-right: 20px;
        transition: transform 0.3s ease;
    }

    .header .logo img:hover {
        transform: scale(1.1);
    }

    .header nav a {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        margin: 0 20px;
        font-size: 16px;
        transition: color 0.3s ease;
    }

    .header nav a:hover {
        color: #ff6347;
    }

    /* Container for the About Us content */
    .container {
        background-color: #fff;
        padding: 40px;
        margin-top: 80px;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .container h1 {
        font-size: 2.4rem;
        margin-bottom: 20px;
        text-align: center;
        color: #374f59;
    }

    .container p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 25px;
    }

    .team {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    .team-member {
        background-color: #4e686e;
        padding: 15px;
        border-radius: 10px;
        width: 250px;
        margin: 15px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .team-member:hover {
        transform: scale(1.05);
    }

    .team-member img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 15px;
        object-fit: cover;
        border: 3px solid #d9d9d9;
    }

    .team-member h3 {
        color: #ff6347;
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .team-member p {
        font-size: 1rem;
        color: #d9d9d9;
    }

    /* Footer styles */
    .footer {
        background-color: #35636d;
        color: #fff;
        padding: 15px 0;
        text-align: center;
        font-size: 14px;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.1);
    }

    .footer a {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
    }

    .footer a:hover {
        color: #ff6347;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .header {
            padding: 20px;
        }

        .header .logo img {
            width: 45px;
            height: 45px;
        }

        .header nav a {
            margin: 0 15px;
            font-size: 14px;
        }

        .container {
            padding: 20px;
            margin: 20px;
        }

        .container h1 {
            font-size: 2rem;
        }

        .team {
            flex-direction: column;
            align-items: center;
        }
    }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <a href="index.php"><img src="assets/img/logo.png" alt="Logo"></a>
        </div>
        <nav>
            <a href="myCourse.php">My Courses</a>
            <a href="aboutUs.php">About Us</a>
            <a href="contactUs.php">Contact Us</a>
        </nav>
    </div>

    <!-- About Us Content -->
    <div class="container">
        <h1>About Us</h1>
        <p>We are a team of passionate developers, designers, and educators working together to bring high-quality
            content and learning experiences to all users. Our mission is to empower individuals with knowledge and
            skills to succeed in the ever-changing world.</p>

        <div class="team">
            <div class="team-member">
                <img src="assets/img/bhavya.jpg" alt="Dudhatra Bhavya">
                <h3>Dudhatra Bhavya</h3>
                <p>Lead Developer</p>
            </div>
            <div class="team-member">
                <img src="assets/img/kaushik.png" alt="Vala Kaushik">
                <h3>Vala Kaushik</h3>
                <p>UI/UX Designer</p>
            </div>
            <div class="team-member">
                <img src="assets/img/soham.png" alt="Parmar Soham">
                <h3>Parmar Soham</h3>
                <p>Project Manager</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 Our Company | <a href="privacyPolicy.php">Privacy Policy</a> | <a href="termsOfService.php">Terms
                of Service</a></p>
    </div>
</body>

</html>