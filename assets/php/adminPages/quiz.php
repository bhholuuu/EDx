<?php
// Include the database connection
include './../_connectionDb.php';

try {
    // Fetch quiz questions from the database
    $query = "SELECT * FROM que";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    $questions = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Questions</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #000000;
        color: #ffffff;
        margin: 0;
        padding: 0;
    }

    header {
        text-align: center;
        padding: 30px 20px;
        background: linear-gradient(90deg, #1a1a1a, #2b2b2b);
        color: #e0e0e0;
        font-size: 2.5rem;
        font-weight: bold;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        position: relative;
    }

    header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: #e0e0e0;
        border-radius: 2px;
    }

    .btn-group {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin: 20px;
    }

    .btn-group button {
        padding: 10px 20px;
        font-size: 1rem;
        color: #fff;
        background: #333;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-group button:hover {
        background: #555;
    }

    table {
        width: 90%;
        margin: 30px auto;
        border-collapse: collapse;
        background: linear-gradient(135deg, #2b2b2b, #3a3a3a);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        overflow: hidden;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
    }

    th {
        background-color: #000000;
        color: #e0e0e0;
        font-weight: bold;
        border-bottom: 2px solid #333;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
    }

    tr:nth-child(even) {
        background-color: #1a1a1a;
    }

    tr:hover {
        background-color: #2a2a2a;
    }

    td {
        color: #bbbbbb;
        font-size: 1rem;
    }

    .no-data {
        text-align: center;
        font-size: 1.2rem;
        color: #bbbbbb;
        padding: 20px;
    }
    </style>
</head>

<body>

    <header>Quiz Questions</header>

    <div class="btn-group">
        <button onclick="window.open('./assets/php/adminPages/addQue.php', '_blank')">Add Video</button>
        <button onclick="window.open('./assets/php/adminPages/editQue.php', '_blank')">Edit Videos</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Question ID</th>
                <th>Course ID</th>
                <th>Question</th>
                <th>Option 1</th>
                <th>Option 2</th>
                <th>Option 3</th>
                <th>Option 4</th>
                <th>Answer</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($questions)): ?>
            <?php foreach ($questions as $question): ?>
            <tr>
                <td><?php echo htmlspecialchars($question['queId']); ?></td>
                <td><?php echo htmlspecialchars($question['courseId']); ?></td>
                <td><?php echo htmlspecialchars($question['que']); ?></td>
                <td><?php echo htmlspecialchars($question['ans1']); ?></td>
                <td><?php echo htmlspecialchars($question['ans2']); ?></td>
                <td><?php echo htmlspecialchars($question['ans3']); ?></td>
                <td><?php echo htmlspecialchars($question['ans4']); ?></td>
                <td><?php echo htmlspecialchars($question['ans']); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="8" class="no-data">No Questions Found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>