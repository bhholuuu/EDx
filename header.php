<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #374f59;
        color: #d9d9d9;
        padding: 10px 5%;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .logo {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .nav {
        display: flex;
        gap: 20px;
    }

    .nav a {
        color: #d9d9d9;
        text-decoration: none;
        font-weight: bold;
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    .nav a:hover {
        color: #35636d;
    }

    @media (max-width: 768px) {
        header {
            flex-direction: column;
            align-items: flex-start;
        }

        .nav {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
    </style>
</head>

<body>
    <header>
        <div class="logo">EDx</div>
        <nav class="nav">
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <a href="account.php">My Account</a>
            <a href="courses.php">Courses</a>
            <a href="fields.php">Fields</a>
            <?php else: ?>
            <a href="explore.php">Explore</a>
            <a href="signupLogin.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>
</body>

</html>