<?php
// Include the database connection
include './../_connectionDb.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    try {
        $query = "DELETE FROM que WHERE queId = :queId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':queId', $idToDelete, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Question deleted successfully!'); window.location.href='editQue.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Handle edit request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editQueId'])) {
    $queId = $_POST['editQueId'];
    $courseId = $_POST['courseId'];
    $que = trim($_POST['que']);
    $ans1 = trim($_POST['ans1']);
    $ans2 = trim($_POST['ans2']);
    $ans3 = trim($_POST['ans3']);
    $ans4 = trim($_POST['ans4']);
    $ans = trim($_POST['ans']);

    if (!empty($courseId) && !empty($que) && !empty($ans1) && !empty($ans2) && !empty($ans3) && !empty($ans4) && !empty($ans)) {
        try {
            $query = "UPDATE que SET courseId = :courseId, que = :que, ans1 = :ans1, ans2 = :ans2, ans3 = :ans3, ans4 = :ans4, ans = :ans WHERE queId = :queId";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':courseId', $courseId, PDO::PARAM_INT);
            $stmt->bindParam(':que', $que, PDO::PARAM_STR);
            $stmt->bindParam(':ans1', $ans1, PDO::PARAM_STR);
            $stmt->bindParam(':ans2', $ans2, PDO::PARAM_STR);
            $stmt->bindParam(':ans3', $ans3, PDO::PARAM_STR);
            $stmt->bindParam(':ans4', $ans4, PDO::PARAM_STR);
            $stmt->bindParam(':ans', $ans, PDO::PARAM_STR);
            $stmt->bindParam(':queId', $queId, PDO::PARAM_INT);
            $stmt->execute();
            echo "<script>alert('Question updated successfully!'); window.location.href='editQue.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Please provide all required fields.');</script>";
    }
}

// Fetch questions and courses
try {
    $query = "SELECT que.*, course.courseName FROM que INNER JOIN course ON que.courseId = course.courseId";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $courseQuery = "SELECT * FROM course";
    $courseStmt = $conn->prepare($courseQuery);
    $courseStmt->execute();
    $courses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    $questions = [];
    $courses = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Questions</title>
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
    select,
    textarea {
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
    <h1>Edit or Delete Questions</h1>

    <table>
        <thead>
            <tr>
                <th>Question ID</th>
                <th>Course Name</th>
                <th>Question</th>
                <th>Option 1</th>
                <th>Option 2</th>
                <th>Option 3</th>
                <th>Option 4</th>
                <th>Correct Answer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($questions)): ?>
            <?php foreach ($questions as $question): ?>
            <tr>
                <td><?= $question['queId']; ?></td>
                <td><?= htmlspecialchars($question['courseName']); ?></td>
                <td><?= htmlspecialchars($question['que']); ?></td>
                <td><?= htmlspecialchars($question['ans1']); ?></td>
                <td><?= htmlspecialchars($question['ans2']); ?></td>
                <td><?= htmlspecialchars($question['ans3']); ?></td>
                <td><?= htmlspecialchars($question['ans4']); ?></td>
                <td><?= htmlspecialchars($question['ans']); ?></td>
                <td class="actions">
                    <button
                        onclick="showEditForm('<?= $question['queId']; ?>', '<?= $question['courseId']; ?>', '<?= htmlspecialchars($question['que']); ?>', '<?= htmlspecialchars($question['ans1']); ?>', '<?= htmlspecialchars($question['ans2']); ?>', '<?= htmlspecialchars($question['ans3']); ?>', '<?= htmlspecialchars($question['ans4']); ?>', '<?= htmlspecialchars($question['ans']); ?>')">Edit</button>
                    <button onclick="deleteQuestion('<?= $question['queId']; ?>')">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="9">No questions found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>


    <div id="editForm" class="form-container" style="display: none;">
        <h2>Edit Question</h2>
        <form method="POST" action="">
            <input type="hidden" name="editQueId" id="editQueId">
            <label>Course:</label>
            <select name="courseId" id="editCourseId" required>
                <?php foreach ($courses as $course): ?>
                <option value="<?= $course['courseId']; ?>"><?= htmlspecialchars($course['courseName']); ?></option>
                <?php endforeach; ?>
            </select>
            <label>Question:</label>
            <textarea name="que" id="editQue" rows="4" required></textarea>
            <label>Option 1:</label>
            <input type="text" name="ans1" id="editAns1" required>
            <label>Option 2:</label>
            <input type="text" name="ans2" id="editAns2" required>
            <label>Option 3:</label>
            <input type="text" name="ans3" id="editAns3" required>
            <label>Option 4:</label>
            <input type="text" name="ans4" id="editAns4" required>
            <label>Correct Answer:</label>
            <input type="text" name="ans" id="editAns" required>
            <button type="submit">Update</button>
        </form>
    </div>

    <script>
    function showEditForm(queId, courseId, que, ans1, ans2, ans3, ans4, ans) {
        document.getElementById('editForm').style.display = 'block';
        document.getElementById('editQueId').value = queId;
        document.getElementById('editCourseId').value = courseId;
        document.getElementById('editQue').value = que;
        document.getElementById('editAns1').value = ans1;
        document.getElementById('editAns2').value = ans2;
        document.getElementById('editAns3').value = ans3;
        document.getElementById('editAns4').value = ans4;
        document.getElementById('editAns').value = ans;
    }

    function deleteQuestion(id) {
        if (confirm('Are you sure you want to delete this question?')) {
            window.location.href = 'editQue.php?delete=' + id;
        }
    }
    </script>
</body>

</html>