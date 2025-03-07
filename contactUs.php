<?php
session_start();
include './assets/php/_connectionDb.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST['cfname']);
    $email = trim($_POST['cemail']);
    $message = trim($_POST['comment']);

    if (!empty($fullName) && !empty($email) && !empty($message)) {
        $query = "INSERT INTO contactUs (full_name, email, message) VALUES (:full_name, :email, :message)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':full_name', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $successMessage = "✅ Message sent successfully!";
        } else {
            $errorMessage = "❌ Failed to send message.";
        }
    } else {
        $errorMessage = "❌ All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    /* Global Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Arial', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #374f59, #35636d);
        color: #d9d9d9;
        font-size: 16px;
        line-height: 1.6;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        overflow-x: hidden;
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

    /* Main Container */
    .contactusbody {
        width: 100%;
        max-width: 1200px;
        background: linear-gradient(135deg, #35636d, #374f59);
        border-radius: 20px;
        padding: 20px 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #d9d9d9;
        text-align: center;
        position: relative;
    }

    h1::after {
        content: '';
        display: block;
        width: 50px;
        height: 4px;
        background: #d9d9d9;
        margin: 10px auto 0;
    }

    /* Left Content */
    .content {
        flex: 1;
        min-width: 280px;
        margin: 10px;
        padding: 20px;
    }

    .content .card {
        background: linear-gradient(135deg, #374f59, #35636d);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .content .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
    }

    .content .card h3 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #d9d9d9;
    }

    .content .card p,
    .content .card a {
        font-size: 1rem;
        color: #d9d9d9;
        text-decoration: none;
    }

    .content .card a:hover {
        color: #00d4ff;
        text-shadow: 0 0 5px #00d4ff;
    }

    /* Right Form */
    .mail {
        flex: 1;
        min-width: 280px;
        margin: 10px;
        padding: 20px;
    }

    .mail form {
        background: linear-gradient(135deg, #35636d, #374f59);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .mail p {
        margin-bottom: 10px;
        font-size: 1.1rem;
        color: #d9d9d9;
    }

    .mail .inputtxt {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 8px;
        background: #374f59;
        color: #d9d9d9;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.2);
        font-size: 1rem;
    }

    .mail .inputtxt:focus {
        outline: none;
        background: #35636d;
        box-shadow: 0 0 10px #d9d9d9;
    }

    .mail .btnsubmit {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, #374f59, #35636d);
        color: #d9d9d9;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .mail .btnsubmit:hover {
        background: linear-gradient(135deg, #35636d, #00d4ff);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 136, 255, 0.5);
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .contactusbody {
            flex-direction: column;
            padding: 20px;
        }

        .content,
        .mail {
            margin: 0 0 20px;
        }

        h1 {
            font-size: 2rem;
        }
    }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header">
        <a href="index.php">Go to Home</a>
    </div>
    <div class="contactusbody">
        <div class="content">
            <h1>Get in Touch</h1>
            <div class="card">
                <h3>Location :</h3>
                <a href="https://www.google.com/maps" target="_blank"><i class="fa-solid fa-location-dot"></i> Visit
                    Us</a>
                <p>Reliance Industries Limited Maker Chambers - IV, Nariman Point Mumbai 400 021, India</p>
            </div>
            <div class="card">
                <h3>Call Us :</h3>
                <a href="tel:+911234567890"><i class="fa-solid fa-phone"></i> +91 123 456 7890</a>
            </div>
            <div class="card">
                <h3>WhatsApp :</h3>
                <a href="https://wa.me/+911234567890"><i class="fa-brands fa-whatsapp"></i> +91 123 456 7890</a>
            </div>
        </div>
        <div class="mail">
            <form action="" method="post">
                <h1>Contact Us</h1>
                <?php if (isset($successMessage)) echo "<p style='color: #28a745; font-weight: bold;'>$successMessage</p>"; ?>
                <?php if (isset($errorMessage)) echo "<p style='color: red; font-weight: bold;'>$errorMessage</p>"; ?>
                <p>Full Name:</p>
                <input type="text" class="inputtxt" name="cfname" required>
                <p>Email:</p>
                <input type="email" class="inputtxt" name="cemail" required>
                <p>Message:</p>
                <textarea class="inputtxt" name="comment" rows="5" required></textarea>
                <button type="submit" class="btnsubmit">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>

<?php
$conn = null;
?>