<?php
session_start();
include './assets/php/_connectionDb.php'; // Database connection

// Get categoryId from URL
$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : null;

if (!$categoryId) {
    echo "Invalid Category ID.";
    exit;
}

// Fetch category name
$queryCategory = "SELECT categoryName FROM category WHERE categoryId = :categoryId";
$stmtCategory = $conn->prepare($queryCategory);
$stmtCategory->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
$stmtCategory->execute();
$category = $stmtCategory->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    echo "Category not found.";
    exit;
}

// Fetch courses under this category
$queryCourses = "SELECT courseId, courseName, description, fees, thumbnail FROM course WHERE categoryId = :categoryId";
$stmtCourses = $conn->prepare($queryCourses);
$stmtCourses->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
$stmtCourses->execute();
$courses = $stmtCourses->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($category['categoryName']); ?> - Courses</title>
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
        padding-bottom: 15px;
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

    .fees {
        font-size: 16px;
        font-weight: bold;
        color: #28a745;
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

    .card .badge {
        /* position: absolute; */
        /* margin-top: 30px; */
        margin-right: 30px;
        align-items: right;
        width: 100%;
        background-color: red;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
    }
    </style>
</head>

<body>

    <h2><?php echo htmlspecialchars($category['categoryName']); ?> - Courses</h2>

    <div class="container">
        <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $course): ?>
        <div class="card">
            <div class="badge">100% OFF</div>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($course['thumbnail']); ?>" alt="Course Thumbnail">
            <div class="card-content">
                <h3><?php echo htmlspecialchars($course['courseName']); ?></h3>
                <p><?php echo htmlspecialchars($course['description']); ?></p>
                <p class="fees">Fees: ₹ <s><?php echo htmlspecialchars($course['fees']); ?></s> <b>FREE</b></p>
                <a href="viewCourse.php?courseId=<?php echo $course['courseId']; ?>" class="explore-btn">View Course</a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p style="text-align:center;">No courses available in this category.</p>
        <?php endif; ?>
    </div>

</body>

</html>

<?php
$conn = null;
?>