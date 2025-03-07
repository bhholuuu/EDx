<?php
session_start();

// Include database connection (PDO version)
include './assets/php/_connectionDb.php';

// Get the category name from the URL
$categoryName = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch category information (optional)
$queryCategory = "SELECT * FROM category WHERE categoryName = :categoryName";
$stmtCategory = $conn->prepare($queryCategory);
$stmtCategory->bindParam(':categoryName', $categoryName);
$stmtCategory->execute();
$category = $stmtCategory->fetch(PDO::FETCH_ASSOC);

// Fetch courses under this category
$queryCourses = "SELECT * FROM course WHERE categoryId = (SELECT categoryId FROM category WHERE categoryName = :categoryName)";
$stmtCourses = $conn->prepare($queryCourses);
$stmtCourses->bindParam(':categoryName', $categoryName);
$stmtCourses->execute();
$courses = $stmtCourses->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore <?php echo htmlspecialchars($category['categoryName']); ?></title>
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
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 20px;
        margin-top: 30px;
        padding: 20px;
    }

    .course-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease;
        max-width: 400px;
    }

    .course-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
    }

    .course-card:hover {
        transform: scale(1.05);
    }

    .explore-btn {
        text-decoration: none;
        background-color: #35636d;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        cursor: pointer;
        display: inline-block;
    }

    .explore-btn:hover {
        background-color: #4e6c72;
    }

    /* Popup Styles */
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .popup-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        width: 300px;
    }

    .popup input {
        width: 100%;
        padding: 8px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .popup button {
        margin: 10px;
        padding: 8px 15px;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .confirm-btn {
        background-color: #35636d;
        color: white;
    }

    .cancel-btn {
        background-color: #ccc;
    }

    .course-card .badge {
        /* position: absolute; */
        margin-top: -30px;
        margin-right: 30px;
        align-items: right;
        width: 50px;
        background-color: red;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
    }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header">
        <a href="index.php">Go to Home</a>
    </div>

    <!-- Courses under the category -->
    <div class="container">
        <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $course): ?>
        <?php 
            // Convert the thumbnail from BLOB to base64 format
            $imageData = base64_encode($course['thumbnail']);
            $imageSrc = "data:image/jpeg;base64," . $imageData;
        ?>
        <div class="course-card">
            <div class="badge">100% OFF</div>
            <img src="<?php echo $imageSrc; ?>" alt="<?php echo htmlspecialchars($course['courseName']); ?>">
            <h3><?php echo htmlspecialchars($course['courseName']); ?></h3>
            <p><?php echo htmlspecialchars($course['description']); ?></p>
            <p><strong>Fees:</strong> <s><?php echo $course['fees']; ?></s> <b> FREE</b></p>
            <button class="explore-btn" onclick="confirmPurchase(<?php echo $course['courseId']; ?>)">Buy</button>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>No courses available in this category.</p>
        <?php endif; ?>
    </div>

    <!-- Popup for Password Confirmation -->
    <div id="buyPopup" class="popup">
        <div class="popup-content">
            <p>Enter your username and password to confirm purchase:</p>
            <input type="text" id="usernameInput" placeholder="Enter your username">
            <input type="password" id="passwordInput" placeholder="Enter your password">
            <p id="errorMsg" style="color: red; display: none;"></p>
            <button class="confirm-btn" id="confirmBtn">Confirm</button>
            <button class="cancel-btn" onclick="closePopup()">Cancel</button>
        </div>
    </div>

    <script>
    let selectedCourseId = null;

    function confirmPurchase(courseId) {
        selectedCourseId = courseId;
        document.getElementById('buyPopup').style.display = 'flex';
    }

    function closePopup() {
        document.getElementById('buyPopup').style.display = 'none';
        document.getElementById('errorMsg').style.display = 'none';
    }

    document.getElementById('confirmBtn').addEventListener('click', function() {
        const username = document.getElementById('usernameInput').value.trim();
        const password = document.getElementById('passwordInput').value.trim();

        if (!username || !password) {
            document.getElementById('errorMsg').innerText = "Please enter both username and password.";
            document.getElementById('errorMsg').style.display = 'block';
            return;
        }

        fetch('verifyPurchase.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `courseId=${selectedCourseId}&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closePopup();
                    location.reload();
                } else {
                    document.getElementById('errorMsg').innerText = data.message;
                    document.getElementById('errorMsg').style.display = 'block';
                }
            })
            .catch(error => {
                console.error("Error:", error);
                document.getElementById('errorMsg').innerText = "An error occurred. Please try again.";
                document.getElementById('errorMsg').style.display = 'block';
            });
    });
    </script>
</body>

</html>

<?php
$conn = null;
?>