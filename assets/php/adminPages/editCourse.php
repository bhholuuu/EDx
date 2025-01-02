<?php
// Include the database connection
include './../_connectionDb.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    try {
        $query = "DELETE FROM course WHERE courseId = :courseId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':courseId', $idToDelete, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Course deleted successfully!'); window.location.href='editCourse.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Handle edit request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editCourseId'])) {
    $courseId = $_POST['editCourseId'];
    $categoryId = $_POST['categoryId'];
    $courseName = trim($_POST['courseName']);
    $fees = trim($_POST['fees']);
    $description = trim($_POST['description']);
    $thumbnail = $_FILES['thumbnail'];

    // Validate required fields
    if (!empty($categoryId) && !empty($courseName) && !empty($fees) && !empty($description)) {
        try {
            // Handle thumbnail upload if provided
            $thumbnailName = null;
            if (!empty($thumbnail['name'])) {
                $targetDir = "./courseImg/";
                $thumbnailName = time() . '_' . basename($thumbnail['name']);
                $targetFile = $targetDir . $thumbnailName;

                if (!move_uploaded_file($thumbnail['tmp_name'], $targetFile)) {
                    echo "<script>alert('Error uploading thumbnail.');</script>";
                    $thumbnailName = null;
                }
            }

            // Update course in the database
            $query = "UPDATE course 
                      SET categoryId = :categoryId, courseName = :courseName, fees = :fees, description = :description" .
                      ($thumbnailName ? ", thumbnail = :thumbnail" : "") .
                      " WHERE courseId = :courseId";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->bindParam(':courseName', $courseName, PDO::PARAM_STR);
            $stmt->bindParam(':fees', $fees, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            if ($thumbnailName) {
                $stmt->bindParam(':thumbnail', $thumbnailName, PDO::PARAM_STR);
            }
            $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
            $stmt->execute();

            echo "<script>alert('Course updated successfully!'); window.location.href='editCourse.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}

// Fetch courses
try {
    $query = "SELECT * FROM course";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    $courses = [];
}

// Fetch categories for dropdown
try {
    $query = "SELECT * FROM category";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    $categories = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Courses</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #000000;
        color: #ffffff;
        margin: 0;
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background: #1a1a1a;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #333;
    }

    th {
        background-color: #333;
        color: #fff;
    }

    tr:hover {
        background-color: #444;
    }

    img.thumbnail {
        height: 50px;
        border-radius: 4px;
    }

    .actions button {
        padding: 5px 10px;
        margin: 0 5px;
        font-size: 0.9rem;
        color: #fff;
        background: #555;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .actions button:hover {
        background: #777;
    }

    .form-container {
        margin-top: 20px;
        padding: 15px;
        background: #222;
        border-radius: 8px;
    }

    select,
    input[type="text"],
    textarea,
    input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #555;
        border-radius: 4px;
        background: #1a1a1a;
        color: #fff;
    }

    button[type="submit"] {
        padding: 10px 15px;
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
    <h1>Edit or Delete Courses</h1>

    <table>
        <thead>
            <tr>
                <th>Course ID</th>
                <th>Category ID</th>
                <th>Course Name</th>
                <th>Fees</th>
                <th>Description</th>
                <th>Thumbnail</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
            <tr>
                <td><?= htmlspecialchars($course['courseId']); ?></td>
                <td><?= htmlspecialchars($course['categoryId']); ?></td>
                <td><?= htmlspecialchars($course['courseName']); ?></td>
                <td><?= htmlspecialchars($course['fees']); ?></td>
                <td><?= htmlspecialchars($course['description']); ?></td>
                <td>
                    <?php if (!empty($course['thumbnail'])): ?>
                    <img src="./courseImg/<?= htmlspecialchars($course['thumbnail']); ?>" alt="Thumbnail"
                        class="thumbnail">
                    <?php else: ?>
                    N/A
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <button
                        onclick="showEditForm('<?= $course['courseId']; ?>', '<?= $course['categoryId']; ?>', '<?= htmlspecialchars($course['courseName']); ?>', '<?= htmlspecialchars($course['fees']); ?>', '<?= htmlspecialchars($course['description']); ?>', '<?= htmlspecialchars($course['thumbnail']); ?>')">Edit</button>
                    <button onclick="deleteCourse('<?= $course['courseId']; ?>')">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="7">No courses found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="editForm" style="display: none;">
        <h2>Edit Course</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="editCourseId" id="editCourseId">
            <label>Category:</label>
            <select name="categoryId" id="editCategoryId" required>
                <?php foreach ($categories as $category): ?>
                <option value="<?= $category['categoryId']; ?>"><?= $category['categoryName']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="courseName" id="editCourseName" placeholder="Course Name" required>
            <input type="text" name="fees" id="editFees" placeholder="Fees" required>
            <textarea name="description" id="editDescription" placeholder="Description" required></textarea>
            <input type="file" name="thumbnail" accept="image/*">
            <button type="submit">Update</button>
        </form>
    </div>

    <script>
    function showEditForm(id, categoryId, name, fees, description, thumbnail) {
        const form = document.getElementById('editForm');
        document.getElementById('editCourseId').value = id;
        document.getElementById('editCategoryId').value = categoryId;
        document.getElementById('editCourseName').value = name;
        document.getElementById('editFees').value = fees;
        document.getElementById('editDescription').value = description;
        form.style.display = 'block';
    }

    function deleteCourse(id) {
        if (confirm('Are you sure you want to delete this course?')) {
            window.location.href = 'editCourse.php?delete=' + id;
        }
    }
    </script>
</body>

</html>