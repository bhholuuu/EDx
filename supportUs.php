<?php
session_start();
include './assets/php/_connectionDb.php'; // Database connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Us - Charity</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 20px;
        text-align: center;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #007bff;
    }

    .qr-code {
        width: 400px;
        /* height: 250px; */
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Support Our Cause</h2>
        <p>Your support helps us provide quality education and resources to those in need.</p>
        <h3>Scan to Donate</h3>
        <img src="./assets/img/GooglePay_QR.png" alt="Google Pay QR Code" class="qr-code">
        <p>Scan this QR code using Google Pay to make a donation.</p>
    </div>
</body>

</html>