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
    <title>Privacy Policy</title>
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

    /* Container for the privacy content */
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

    <!-- Privacy Policy Content -->
    <div class="container">
        <h1>Privacy Policy</h1>

        <p>We at Our Company value your privacy and are committed to protecting the personal information you share with
            us. This Privacy Policy outlines how we collect, use, and safeguard your information.</p>

        <h2>1. Information We Collect</h2>
        <p>We collect personal information such as your name, email, and any other relevant details when you sign up for
            our services, access our website, or engage with our platform in other ways. This information helps us
            provide
            a personalized and efficient experience.</p>

        <h2>2. How We Use Your Information</h2>
        <p>Your information is primarily used to process and enhance your experience with our services. We may use it to
            send you updates, news, promotional offers, and other communications to keep you informed of our offerings.
        </p>

        <h2>3. How We Protect Your Information</h2>
        <p>We utilize secure encryption and privacy practices to protect your information from unauthorized access. We
            ensure
            that your personal data remains secure in compliance with industry standards.</p>

        <h2>4. Sharing Your Information</h2>
        <p>We do not share your personal information with third parties, except as necessary to provide our services or
            as
            required by law. We take your privacy seriously and share your data only with trusted partners who are in
            alignment with our privacy practices.</p>

        <h2>5. Your Rights</h2>
        <p>You have the right to access, correct, or delete your personal data at any time. If you wish to exercise
            these
            rights, please contact us using the information provided below.</p>

        <h2>6. Changes to This Policy</h2>
        <p>We reserve the right to update this Privacy Policy as necessary. Changes will be reflected on this page and
            will
            take effect immediately. Please check this policy periodically for any updates.</p>

        <h2>7. Contact Us</h2>
        <p>If you have any questions about our Privacy Policy or how we handle your data, please reach out to us at
            <a href="mailto:support@ourcompany.com">support@ourcompany.com</a>.
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 Our Company | <a href="termsOfService.php">Terms of Service</a></p>
    </div>
</body>

</html>