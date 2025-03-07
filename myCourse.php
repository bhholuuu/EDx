<?php
session_start();
include './assets/php/_connectionDb.php'; // Database connection

// Ensure session variables are set
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['userId'])) {
    header("Location: signupLogin.php");
    exit;
}

$userId = $_SESSION['userId'];

// Fetch courses that the user has purchased
$query = "SELECT c.courseId, c.courseName, c.description, c.thumbnail 
          FROM course c
          JOIN purchase p ON c.courseId = p.courseId
          WHERE p.userId = :userId";

$stmt = $conn->prepare($query);
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
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

    h2 {
        text-align: center;
        margin-top: 80px;
    }

    .course-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        padding: 20px;
    }

    .course-card {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
    }

    .course-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
    }

    .course-card h3 {
        margin: 10px 0;
    }

    .course-card p {
        font-size: 14px;
        color: #555;
    }

    .course-card a {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 15px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .course-card a:hover {
        background: #0056b3;
    }

    .empty-message {
        text-align: center;
        font-size: 18px;
        margin-top: 20px;
        color: #666;
    }
    </style>
</head>

<body>

    <!-- Header Section -->
    <div class="header">
        <a href="index.php">Go to Home</a>
    </div>

    <h2>My Courses</h2>
    <div class="course-container">
        <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $course): ?>
        <?php 
        $imageData = base64_encode($course['thumbnail']); 
        $imageSrc = "data:image/jpeg;base64," . $imageData;
        ?>
        <div class="course-card">
            <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($course['courseName']); ?>">
            <h3><?php echo htmlspecialchars($course['courseName']); ?></h3>
            <p><?php echo htmlspecialchars($course['description']); ?></p>
            <a href="viewCourse.php?courseId=<?php echo $course['courseId']; ?>">Go to Course</a>
        </div>
        <?php endforeach; ?>

        <?php else: ?>
        <p class="empty-message">You have not purchased any courses.</p>
        <?php endif; ?>
    </div>

</body>

</html>