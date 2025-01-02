<?php
// Include the database connection
include './../_connectionDb.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    try {
        $query = "DELETE FROM video WHERE videoId = :videoId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':videoId', $idToDelete, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Video deleted successfully!'); window.location.href='editVideo.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Handle edit request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editVideoId'])) {
    $videoId = $_POST['editVideoId'];
    $courseId = $_POST['courseId'];
    $videoName = trim($_POST['videoName']);
    $videoLink = trim($_POST['videoLink']);

    if (!empty($courseId) && !empty($videoName) && !empty($videoLink)) {
        try {
            $query = "UPDATE video SET courseId = :courseId, videoName = :videoName, videoLink = :videoLink WHERE videoId = :videoId";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
            $stmt->bindParam(':videoName', $videoName, PDO::PARAM_STR);
            $stmt->bindParam(':videoLink', $videoLink, PDO::PARAM_STR);
            $stmt->bindParam(':videoId', $videoId, PDO::PARAM_INT);
            $stmt->execute();
            echo "<script>alert('Video updated successfully!'); window.location.href='editVideo.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Please provide all required fields.');</script>";
    }
}

// Fetch videos
try {
    $query = "SELECT video.*, course.courseName FROM video INNER JOIN course ON video.courseId = course.courseId";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch courses for the dropdown
    $courseQuery = "SELECT * FROM course";
    $courseStmt = $conn->prepare($courseQuery);
    $courseStmt->execute();
    $courses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    $videos = [];
    $courses = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Videos</title>
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

    input[type="text"],
    select {
        padding: 10px;
        width: calc(100% - 22px);
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
    <h1>Edit or Delete Videos</h1>

    <table>
        <thead>
            <tr>
                <th>Video ID</th>
                <th>Course Name</th>
                <th>Video Name</th>
                <th>Video Link</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($videos)): ?>
            <?php foreach ($videos as $video): ?>
            <tr>
                <td><?php echo $video['videoId']; ?></td>
                <td><?php echo htmlspecialchars($video['courseName']); ?></td>
                <td><?php echo htmlspecialchars($video['videoName']); ?></td>
                <td><?php echo htmlspecialchars($video['videoLink']); ?></td>
                <td class="actions">
                    <button
                        onclick="showEditForm('<?php echo $video['videoId']; ?>', '<?php echo $video['courseId']; ?>', '<?php echo htmlspecialchars($video['videoName']); ?>', '<?php echo htmlspecialchars($video['videoLink']); ?>')">Edit</button>
                    <button onclick="deleteVideo('<?php echo $video['videoId']; ?>')">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5">No videos found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="editForm" class="form-container" style="display: none;">
        <h2>Edit Video</h2>
        <form method="POST" action="">
            <input type="hidden" name="editVideoId" id="editVideoId">
            <label>Course:</label>
            <select name="courseId" id="editCourseId" required>
                <?php foreach ($courses as $course): ?>
                <option value="<?php echo $course['courseId']; ?>">
                    <?php echo htmlspecialchars($course['courseName']); ?></option>
                <?php endforeach; ?>
            </select>
            <label>Video Name:</label>
            <input type="text" name="videoName" id="editVideoName" placeholder="Enter Video Name" required>
            <label>Video Link:</label>
            <input type="text" name="videoLink" id="editVideoLink" placeholder="Enter Video Link" required>
            <button type="submit">Update</button>
        </form>
    </div>

    <script>
    function showEditForm(videoId, courseId, videoName, videoLink) {
        document.getElementById('editForm').style.display = 'block';
        document.getElementById('editVideoId').value = videoId;
        document.getElementById('editCourseId').value = courseId;
        document.getElementById('editVideoName').value = videoName;
        document.getElementById('editVideoLink').value = videoLink;
    }

    function deleteVideo(id) {
        if (confirm('Are you sure you want to delete this video?')) {
            window.location.href = 'editVideo.php?delete=' + id;
        }
    }
    </script>
</body>

</html>