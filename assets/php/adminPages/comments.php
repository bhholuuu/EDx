<?php
// Include the database connection
include './../_connectionDb.php';

try {
    // Fetch all comments from the database
    $query = "SELECT * FROM comments";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Comments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

    <header>Manage Comments</header>

    <table>
        <thead>
            <tr>
                <th>Comment ID</th>
                <th>Course ID</th>
                <th>User Name</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
            <tr>
                <td><?php echo htmlspecialchars($comment['commentId']); ?></td>
                <td><?php echo htmlspecialchars($comment['courseId']); ?></td>
                <td><?php echo htmlspecialchars($comment['userName']); ?></td>
                <td><?php echo htmlspecialchars($comment['comment']); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="4" class="no-data">No Comments Found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>