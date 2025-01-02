<?php
// Include database connection
include './../_connectionDb.php';

// Fetch categories for the dropdown
try {
    $query = "SELECT categoryId, categoryName FROM category";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

// Handle form submission to add a course
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = trim($_POST['categoryId']);
    $courseName = trim($_POST['courseName']);
    $fees = trim($_POST['fees']);
    $description = trim($_POST['description']);
    $thumbnail = $_FILES['thumbnail'];

    // Validate required fields
    if (!empty($categoryId) && !empty($courseName) && !empty($fees) && !empty($description)) {
        try {
            // Handle file upload
            $thumbnailName = null;
            if (!empty($thumbnail['name'])) {
                $targetDir = "./courseImg/";
                $thumbnailName = time() . '_' . basename($thumbnail['name']);
                $targetFile = $targetDir . $thumbnailName;

                if (!move_uploaded_file($thumbnail['tmp_name'], $targetFile)) {
                    echo "<script>alert('Error uploading thumbnail.');</script>";
                    $thumbnailName = null; // Reset if upload fails
                }
            }

            // Insert course into the database
            $query = "INSERT INTO course (categoryId, courseName, fees, description, thumbnail) 
                      VALUES (:categoryId, :courseName, :fees, :description, :thumbnail)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->bindParam(':courseName', $courseName, PDO::PARAM_STR);
            $stmt->bindParam(':fees', $fees, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':thumbnail', $thumbnailName, PDO::PARAM_STR);
            $stmt->execute();

            echo "<script>alert('Course added successfully!'); window.location.href='addCourse.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #000000;
        color: #ffffff;
        padding: 20px;
    }

    .form-container {
        background: #222;
        padding: 20px;
        border-radius: 8px;
        max-width: 500px;
        margin: 0 auto;
    }

    select,
    input[type="text"],
    input[type="number"],
    textarea,
    input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #555;
        border-radius: 4px;
        background: #1a1a1a;
        color: #fff;
    }

    button[type="submit"] {
        width: 100%;
        padding: 10px;
        color: #fff;
        background: #333;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background: #555;
    }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Add a New Course</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <select name="categoryId" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['categoryId']); ?>">
                    <?php echo htmlspecialchars($category['categoryName']); ?>
                </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="courseName" placeholder="Course Name" required>
            <input type="number" name="fees" placeholder="Fees" required>
            <textarea name="description" placeholder="Course Description" rows="4" required></textarea>
            <input type="file" name="thumbnail" accept="image/*" required>
            <button type="submit">Add Course</button>
        </form>
    </div>

</body>

</html>