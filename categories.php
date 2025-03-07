<?php
session_start();

// Include database connection (PDO version)
include './assets/php/_connectionDb.php'; // Ensure this file connects to your database

// Fetch categories from the database using PDO
$query = "SELECT * FROM category";
$stmt = $conn->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <style>
    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f0f0f0;
        padding-top: 20px;
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

    .container {
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 20px;
        padding: 20px;
    }

    .category-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        flex: 1 1 calc(33% - 20px);
        /* Flexbox: dynamically adjust based on screen size */
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease;
        max-width: 400px;
        /* Prevent the card from becoming too wide */
    }

    .category-card:hover {
        transform: scale(1.05);
    }

    .category-card img {
        width: 100%;
        height: auto;
        /* Automatically adjust height based on width */
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .category-card h3 {
        font-size: 1.5rem;
        color: #35636d;
        margin-bottom: 10px;
    }

    .category-card p {
        font-size: 1rem;
        color: #666;
        margin-bottom: 15px;
    }

    .explore-btn {
        text-decoration: none;
        background-color: #35636d;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .explore-btn:hover {
        background-color: #4e6c72;
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        .category-card {
            flex: 1 1 100%;
            /* Full width on smaller screens */
            max-width: none;
            /* Remove max-width restriction */
        }
    }
    </style>
</head>

<body>
    <div class="header">
        <a href="index.php">Go to Home</a>
    </div>
    <div class="container">
        <?php foreach ($categories as $category): ?>
        <div class="category-card">
            <?php if (!empty($category['thumbnail'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($category['thumbnail']); ?>"
                alt="<?php echo htmlspecialchars($category['categoryName']); ?>">
            <?php else: ?>
            <img src="./assets/img/default-thumbnail.png" alt="Default Thumbnail">
            <?php endif; ?>
            <h3><?php echo htmlspecialchars($category['categoryName']); ?></h3>
            <p><?php echo htmlspecialchars($category['description']); ?></p>
            <a href="courses.php?category=<?php echo urlencode($category['categoryName']); ?>"
                class="explore-btn">Explore</a>
        </div>
        <?php endforeach; ?>
    </div>
</body>

</html>

<?php
// Close the PDO connection (optional, as it's automatically closed at the end of the script)
$conn = null;
?>