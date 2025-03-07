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
    <title>Terms of Service</title>
    <style>
    /* Global styles */
    body {
        font-family: 'Helvetica', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        color: #333;
        line-height: 1.6;
    }

    h1,
    h2 {
        color: #374f59;
    }

    /* Header styles */
    .header {
        background-color: #35636d;
        padding: 20px 40px;
        color: #fff;
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

    /* Container for the terms content */
    .container {
        background-color: #fff;
        padding: 40px;
        margin: 40px auto;
        max-width: 900px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
    }

    .container h1 {
        font-size: 2.4rem;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .container p {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 25px;
        line-height: 1.8;
    }

    .container h2 {
        font-size: 1.8rem;
        margin-top: 30px;
        color: #374f59;
        border-bottom: 2px solid #374f59;
        padding-bottom: 8px;
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

    /* Mobile responsive */
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
            <a href="myCourses.php">My Courses</a>
            <a href="aboutUs.php">About Us</a>
            <a href="contactUs.php">Contact Us</a>
        </nav>
    </div>

    <!-- Terms of Service Content -->
    <div class="container">
        <h1>Terms of Service</h1>

        <p>Welcome to our Terms of Service page! By accessing or using our services, you agree to comply with the
            following terms. Please read them carefully.</p>

        <h2>1. Acceptance of Terms</h2>
        <p>By using our website or services, you agree to abide by these Terms of Service. If you do not agree with any
            of these terms, please refrain from using our services.</p>

        <h2>2. Use of Service</h2>
        <p>Our services are provided to you with a limited, non-exclusive, non-transferable license. You agree to use
            the services for personal, non-commercial purposes only.</p>

        <h2>3. User Responsibilities</h2>
        <p>You are responsible for maintaining the confidentiality of your account information, including your username
            and password. You also agree to notify us immediately of any unauthorized access to your account.</p>

        <h2>4. Prohibited Conduct</h2>
        <p>You agree not to engage in any of the following activities:
        <ul>
            <li>Using our services for illegal or unauthorized purposes.</li>
            <li>Uploading malicious content or engaging in harmful activities.</li>
            <li>Interfering with or disrupting the normal operation of our website.</li>
        </ul>
        </p>

        <h2>5. Limitation of Liability</h2>
        <p>We are not liable for any direct, indirect, or consequential damages that may arise from the use of our
            services, even if we have been advised of the possibility of such damages.</p>

        <h2>6. Termination</h2>
        <p>We may suspend or terminate your access to our services at any time, without notice, for violating these
            terms or for any reason deemed necessary by us.</p>

        <h2>7. Changes to Terms</h2>
        <p>We reserve the right to update or change these Terms of Service at any time. You are encouraged to review
            this page periodically for any changes.</p>

        <h2>8. Governing Law</h2>
        <p>These Terms of Service are governed by the laws of the jurisdiction in which our company operates, without
            regard to its conflict of law principles.</p>

        <h2>9. Contact Information</h2>
        <p>If you have any questions or concerns regarding these Terms of Service, please contact us at <a
                href="mailto:support@ourcompany.com">support@ourcompany.com</a>.</p>

        <a href="privacyPolicy.php" class="btn-cta">Read our Privacy Policy</a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 My Website | <a href="privacyPolicy.php">Privacy Policy</a></p>
    </div>
</body>

</html>