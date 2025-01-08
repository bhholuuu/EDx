<?php
// Include the database connection
include './../_connectionDb.php';

try {
    // Fetch all notes from the database
    $query = "SELECT * FROM notes";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Manage Notes</title>
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

    .view-button {
        background-color: #007bff;
        color: #ffffff;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        text-align: center;
        text-decoration: none;
    }

    .view-button:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>

    <header>Manage Notes</header>

    <table>
        <thead>
            <tr>
                <th>Note ID</th>
                <th>User ID</th>
                <th>Video ID</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($notes)): ?>
            <?php foreach ($notes as $note): ?>
            <tr>
                <td><?php echo htmlspecialchars($note['noteId']); ?></td>
                <td><?php echo htmlspecialchars($note['userId']); ?></td>
                <td><?php echo htmlspecialchars($note['videoId']); ?></td>
                <td>
                    <?php 
            $shortNote = strlen($note['note']) > 50 ? substr($note['note'], 0, 50) . '...' : $note['note'];
            echo htmlspecialchars($shortNote); 
            ?>
                </td>
                <td>
                    <a href="./assets/php/adminPages/viewNote.php?noteId=<?php echo $note['noteId']; ?>" target="_blank"
                        class="view-button">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5" class="no-data">No Notes Found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>