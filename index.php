<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to EDx</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    /* General Reset and Basic Styles */
    html,
    body {
        scroll-behavior: smooth;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }

    /* Header Styles */
    header {
        position: fixed;
        width: 100%;
        top: 0;
        background-color: #ffffff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    /* Slider Styles */
    .slider {
        position: relative;
        max-width: 100%;
        width: 1000px;
        margin: 110px auto;
    }

    .slides {
        display: flex;
        overflow: hidden;
        position: relative;
    }

    .slide {
        min-width: 100%;
        height: 500px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        position: relative;
    }

    .slide-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: #fff;
        background: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 8px;
        width: 100%;
        height: 100%;
        position: relative;
    }

    .slide-content h2 {
        margin: 0;
        font-size: 32px;
    }

    .slide-content p {
        margin: 10px 0 20px;
        font-size: 18px;
    }

    .slide-content button {
        padding: 10px 20px;
        background-color: #0087ca;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .slide-content button:hover {
        background-color: #005f8a;
    }

    /* "New" Badge */
    .new-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #ff4d4d, #cc0000);
        color: white;
        padding: 6px 12px;
        font-size: 14px;
        font-weight: bold;
        border-radius: 20px;
        text-transform: uppercase;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        letter-spacing: 0.5px;
        transition: transform 0.2s ease-in-out;
        z-index: 9;
    }

    .new-badge:hover {
        transform: scale(1.1);
    }


    /* Navigation Arrows */
    .prev,
    .next {
        position: absolute;
        height: 100%;
        top: 0;
        width: auto;
        padding: 16px;
        font-size: 18px;
        cursor: pointer;
        background: rgba(0, 0, 0, 0);
        border: none;
        z-index: 5;
        color: #f0f0f0;
    }

    .next {
        right: 0;
    }

    .prev:hover {
        background: linear-gradient(90deg, rgb(0, 0, 0), rgba(0, 0, 0, 0));
    }

    .next:hover {
        background: linear-gradient(90deg, rgba(0, 0, 0, 0), rgb(0, 0, 0));
    }

    /* Hide scrollbar for all elements */
    ::-webkit-scrollbar {
        display: none;
        /* Hide scrollbar for Chrome, Safari, and Edge */
    }

    html,
    body {
        scrollbar-width: none;
        /* Hide scrollbar for Firefox */
        -ms-overflow-style: none;
        /* Hide scrollbar for Internet Explorer/Edge */
        overflow-y: scroll;
        /* Ensure scrolling is still possible */
    }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="greetings" style="text-align: center; margin-top: 90px;">
        <h1>Welcome to EDx</h1>
        <p>Your journey to excellence begins here!</p>
    </div>

    <!-- Slider -->
    <div class="slider">
        <div class="slides">
            <button class="prev" onclick="changeSlide(-1)">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </button>

            <?php
            include './assets/php/_connectionDb.php'; // Database connection

            $query = "SELECT categoryName, description, thumbnail FROM category ORDER BY categoryId DESC LIMIT 3";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $row) {
                $imageData = base64_encode($row['thumbnail']);
                $imageSrc = "data:image/jpeg;base64," . $imageData;
            ?>
            <div class="slide" style="background-image: url('<?php echo $imageSrc; ?>');">
                <div class="slide-content">
                    <div class="new-badge">New</div>
                    <h2><?php echo htmlspecialchars($row['categoryName']); ?></h2>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <!-- <button>Explore</button> -->
                </div>
            </div>
            <?php
            }
            ?>

            <button class="next" onclick="changeSlide(1)">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <!-- Footer -->
    <footer style="background-color: #333; color: white; text-align: center; padding: 20px; margin-top: 50px;">
        <p>&copy; 2025 EDx. All rights reserved.</p>
        <p>
            <a href="privacyPolicy.php" style="color: #0087ca; text-decoration: none; margin: 0 10px;">Privacy
                Policy</a> |
            <a href="termsOfService.php" style="color: #0087ca; text-decoration: none; margin: 0 10px;">Terms of
                Service</a> |
            <a href="contactUs.php" style="color: #0087ca; text-decoration: none; margin: 0 10px;">Contact Us</a>
        </p>
    </footer>


    <script>
    let currentSlide = 0;

    function showSlide(index) {
        const slides = document.querySelectorAll('.slide');
        if (index >= slides.length) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = index;
        }

        slides.forEach((slide, i) => {
            slide.style.display = i === currentSlide ? 'block' : 'none';
        });
    }

    function changeSlide(step) {
        showSlide(currentSlide + step);
    }

    // Automatically change slides every 2 seconds
    setInterval(() => {
        changeSlide(1);
    }, 4000);

    // Initial display
    showSlide(currentSlide);
    </script>

</body>

</html>