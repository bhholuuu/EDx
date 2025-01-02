<?php
// Include the database connection
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

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = $_POST['courseId'];
    $que = trim($_POST['que']);
    $ans1 = trim($_POST['ans1']);
    $ans2 = trim($_POST['ans2']);
    $ans3 = trim($_POST['ans3']);
    $ans4 = trim($_POST['ans4']);
    $ans = trim($_POST['ans']);

    if (!empty($courseId) && !empty($que) && !empty($ans1) && !empty($ans2) && !empty($ans3) && !empty($ans4) && !empty($ans)) {
        try {
            // Insert new question into the database
            $query = "INSERT INTO que (courseId, que, ans1, ans2, ans3, ans4, ans) VALUES (:courseId, :que, :ans1, :ans2, :ans3, :ans4, :ans)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':courseId', $courseId);
            $stmt->bindParam(':que', $que);
            $stmt->bindParam(':ans1', $ans1);
            $stmt->bindParam(':ans2', $ans2);
            $stmt->bindParam(':ans3', $ans3);
            $stmt->bindParam(':ans4', $ans4);
            $stmt->bindParam(':ans', $ans);
            $stmt->execute();
            echo "<script>alert('Question added successfully!'); window.location.href='addQue.php';</script>";
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
    <title>Add Question</title>
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
    button,
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: none;
        border-radius: 4px;
    }

    input,
    select,
    textarea {
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
        <h2>Add Question</h2>
        <form method="POST">
            <label>Course:</label>
            <select name="courseId" required>
                <?php foreach ($courses as $course): ?>
                <option value="<?= $course['courseId']; ?>"><?= htmlspecialchars($course['courseName']); ?></option>
                <?php endforeach; ?>
            </select>

            <label>Question:</label>
            <textarea name="que" placeholder="Enter question" rows="4" required></textarea>

            <label>Option 1:</label>
            <input type="text" name="ans1" placeholder="Enter option 1" required>

            <label>Option 2:</label>
            <input type="text" name="ans2" placeholder="Enter option 2" required>

            <label>Option 3:</label>
            <input type="text" name="ans3" placeholder="Enter option 3" required>

            <label>Option 4:</label>
            <input type="text" name="ans4" placeholder="Enter option 4" required>

            <label>Correct Answer:</label>
            <input type="text" name="ans" placeholder="Enter the correct answer" required>

            <button type="submit">Add Question</button>
        </form>
    </div>
</body>

</html>