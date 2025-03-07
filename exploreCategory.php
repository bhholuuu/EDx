<?php
session_start();
include './assets/php/_connectionDb.php'; // Database connection

// Fetch all categories
$queryCategories = "SELECT categoryId, categoryName, description, thumbnail FROM category";
$stmt = $conn->prepare($queryCategories);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Categories</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 300px;
        text-align: center;
        transition: 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .card-content {
        padding: 15px;
    }

    .card h3 {
        margin: 10px 0;
        font-size: 20px;
        color: #333;
    }

    .card p {
        font-size: 14px;
        color: #666;
        min-height: 40px;
    }

    .explore-btn {
        background: #007bff;
        color: white;
        padding: 10px 15px;
        display: inline-block;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
        font-weight: bold;
    }

    .explore-btn:hover {
        background: #0056b3;
    }
    </style>
</head>

<body>

    <h2>Explore Categories</h2>

    <div class="container">
        <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $category): ?>
        <div class="card">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($category['thumbnail']); ?>"
                alt="Category Thumbnail">
            <div class="card-content">
                <h3><?php echo htmlspecialchars($category['categoryName']); ?></h3>
                <p><?php echo htmlspecialchars($category['description']); ?></p>
                <a href="exploreCourses.php?categoryId=<?php echo $category['categoryId']; ?>"
                    class="explore-btn">Explore
                    Courses</a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p style="text-align:center;">No categories available.</p>
        <?php endif; ?>
    </div>

</body>

</html>

<?php
$conn = null;
?>