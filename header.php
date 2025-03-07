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

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #d9d9d9;
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
            <?php
                // Check if the user has an avatar stored in the session
                if (isset($_SESSION['avatar']) && !empty($_SESSION['avatar'])) {
                    // Construct the avatar image path
                    $avatarPath = './assets/img/avatar/' . $_SESSION['avatar'];
                    if (!file_exists($avatarPath)) {
                        // Fallback to a default avatar if the image is not found
                        $avatarPath = './assets/img/avatar/default-avatar.png';
                    }
                    ?>
            <a href="myAccount.php">
                <img src="<?php echo $avatarPath; ?>" alt="User Avatar" class="avatar">
            </a>
            <?php } else { ?>
            <a href="myAccount.php">My Account</a>
            <?php } ?>
            <a href="myCourse.php">My Courses</a>
            <a href="categories.php">Fields</a>
            <a href="supportUs.php">Support Us</a>
            <?php else: ?>
            <a href="exploreCategory.php">Explore</a>
            <a href="signupLogin.php">Login</a>
            <a href="supportUs.php">Support Us</a>
            <?php endif; ?>
        </nav>
    </header>
</body>

</html>