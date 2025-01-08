<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to EDx</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }

    .hero {
        background: url('https://source.unsplash.com/1920x1080/?education,learning') no-repeat center center/cover;
        height: 70vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        text-align: center;
        padding: 20px;
    }

    .hero h2 {
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 20px;
    }

    .hero a {
        display: inline-block;
        padding: 10px 20px;
        font-size: 1rem;
        color: #fff;
        background-color: #007bff;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .hero a:hover {
        background-color: #0056b3;
    }

    .features {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 20px;
        padding: 40px 10%;
    }

    .feature-card {
        flex: 1 1 calc(30% - 20px);
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .feature-card .icon {
        font-size: 3rem;
        color: #007bff;
        margin-bottom: 15px;
    }

    .feature-card h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .feature-card p {
        font-size: 1rem;
        color: #555;
    }

    footer {
        text-align: center;
        padding: 20px 10%;
        background: #007bff;
        color: #fff;
        font-size: 0.9rem;
    }

    footer a {
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    footer a:hover {
        color: #f4f4f4;
    }

    @media (max-width: 768px) {
        .features {
            flex-direction: column;
            gap: 30px;
        }

        .feature-card {
            flex: 1 1 100%;
        }
    }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>


    <section class="hero">
        <div>
            <h2>Welcome to EDx</h2>
            <p>Learn, Explore, and Grow with the best online courses available.</p>
            <a href="#courses">Browse Courses</a>
        </div>
    </section>

    <section id="features" class="features">
        <div class="feature-card">
            <div class="icon"><i class="fa-solid fa-book-open"></i></div>
            <h3>Quality Courses</h3>
            <p>Access a wide variety of high-quality educational content from top instructors.</p>
        </div>
        <div class="feature-card">
            <div class="icon"><i class="fa-solid fa-certificate"></i></div>
            <h3>Certifications</h3>
            <p>Earn globally recognized certifications to boost your career prospects.</p>
        </div>
        <div class="feature-card">
            <div class="icon"><i class="fa-solid fa-user-group"></i></div>
            <h3>Expert Support</h3>
            <p>Get guidance and support from our team of experts and mentors.</p>
        </div>
    </section>

    <footer>
        &copy; <?php echo date("Y"); ?> EDx. All rights reserved. <a href="#contact">Contact Us</a>
    </footer>

</body>

</html>