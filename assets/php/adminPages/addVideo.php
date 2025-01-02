<?php
// Include database connection
include './../_connectionDb.php';

try {
    // Fetch courses for the dropdown
    $query = "SELECT * FROM course";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST['courseId'];
    $videoName = trim($_POST['videoName']);
    $videoLink = trim($_POST['videoLink']);

    if (!empty($courseId) && !empty($videoName) && !empty($videoLink)) {
        try {
            $query = "INSERT INTO video (courseId, videoName, videoLink) VALUES (:courseId, :videoName, :videoLink)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
            $stmt->bindParam(':videoName', $videoName, PDO::PARAM_STR);
            $stmt->bindParam(':videoLink', $videoLink, PDO::PARAM_STR);
            $stmt->execute();
            echo "<script>alert('Video added successfully!'); window.location.href='addVideo.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Video</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #000000;
        color: #ffffff;
        margin: 0;
        padding: 20px;
    }

    .form-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background: #222;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    input,
    select,
    button {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: none;
        border-radius: 4px;
    }

    input,
    select {
        background: #2b2b2b;
        color: #ffffff;
    }

    button {
        background: #333;
        color: #ffffff;
        cursor: pointer;
    }

    button:hover {
        background: #555;
    }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Add Video</h2>
        <form method="POST">
            <label>Course:</label>
            <select name="courseId" required>
                <?php foreach ($courses as $course): ?>
                <option value="<?= $course['courseId']; ?>"><?= htmlspecialchars($course['courseName']); ?></option>
                <?php endforeach; ?>
            </select>
            <label>Video Name:</label>
            <input type="text" name="videoName" placeholder="Enter video name" required>
            <label>Video Link:</label>
            <input type="text" name="videoLink" placeholder="Enter video link" required>
            <button type="submit">Add Video</button>
        </form>
    </div>
</body>

</html>