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

    body {
        padding-top: 0px;
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

    .container {
        height: 70px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 30px;
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
    }

    .slide {
        position: relative;
        min-width: 100%;
        height: 500px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        overflow: hidden;
    }

    .slide-content {
        text-align: center;
        justify-content: center;
        color: #fff;
        background: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 8px;
        height: 100%;
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

    .prev,
    .next {
        position: absolute;
        height: 100%;
        top: 0;
        width: auto;
        padding: 16px;
        font-weight: bold;
        font-size: 18px;
        cursor: pointer;
        user-select: none;
        background: rgba(0, 0, 0, 0);
        border: none;
        border-radius: 0 3px 3px 0;
        z-index: 5;
        color: #f0f0f0;
        background: transparent;
    }

    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    .prev:hover {
        background: linear-gradient(90deg, rgb(0, 0, 0), rgba(0, 0, 0, 0));
    }

    .next:hover {
        background: linear-gradient(90deg, rgba(0, 0, 0, 0), rgb(0, 0, 0));
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

            <!-- Slide 1 -->
            <div class="slide"
                style="background-image: url('https://images.unsplash.com/photo-1485470733090-0aae1788d5af?q=80&w=1834&auto=format&fit=crop');">
                <div class="slide-content">
                    <h2>Explore the Universe</h2>
                    <p>Discover the wonders of the cosmos with our resources.</p>
                    <button>Explore</button>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide"
                style="background-image: url('https://images.unsplash.com/photo-1503614472-8c93d56e92ce?q=80&w=2011&auto=format&fit=crop');">
                <div class="slide-content">
                    <h2>Innovate and Inspire</h2>
                    <p>Learn the skills to change the world.</p>
                    <button>Explore</button>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slide"
                style="background-image: url('https://images.unsplash.com/photo-1545641203-7d072a14e3b2?q=80&w=1933&auto=format&fit=crop');">
                <div class="slide-content">
                    <h2>Achieve Your Goals</h2>
                    <p>Let EDx guide your way to success.</p>
                    <button>Explore</button>
                </div>
            </div>

            <!-- Slide 4 -->
            <div class="slide"
                style="background-image: url('https://images.pexels.com/photos/956981/milky-way-starry-sky-night-sky-star-956981.jpeg?auto=compress&cs=tinysrgb');">
                <div class="slide-content">
                    <h2>Explore the Night Sky</h2>
                    <p>Get inspired by the beauty of the stars.</p>
                    <button>Explore</button>
                </div>
            </div>

            <button class="next" onclick="changeSlide(1)">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </button>
        </div>
    </div>

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

    // Initial display
    showSlide(currentSlide);
    </script>
</body>

</html>