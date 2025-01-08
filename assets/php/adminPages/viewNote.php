<?php
// Include the database connection
include './../_connectionDb.php';

// Validate `noteId` in the GET request
if (!isset($_GET['noteId']) || empty($_GET['noteId'])) {
    echo "Invalid request. Note ID is required.";
    exit;
}

$noteId = $_GET['noteId'];

try {
    // Fetch the specific note by ID
    $query = "SELECT * FROM notes WHERE noteId = :noteId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':noteId', $noteId, PDO::PARAM_INT);
    $stmt->execute();
    $note = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the note exists
    if (!$note) {
        echo "Note not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Note</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #000000;
        color: #ffffff;
        margin: 0;
        padding: 20px;
    }

    .note-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #1a1a1a;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

    h1 {
        text-align: center;
        color: #e0e0e0;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 0 auto;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
        border: 1px solid #333;
    }

    th {
        background-color: #000000;
        color: #e0e0e0;
        font-weight: bold;
    }

    td {
        background-color: #1a1a1a;
        color: #bbbbbb;
        word-break: break-all;
    }
    </style>
</head>

<body>

    <div class="note-container">
        <h1>Note Details</h1>
        <table>
            <tr>
                <th>Note ID</th>
                <td><?php echo htmlspecialchars($note['noteId']); ?></td>
            </tr>
            <tr>
                <th>User ID</th>
                <td><?php echo htmlspecialchars($note['userId']); ?></td>
            </tr>
            <tr>
                <th>Video ID</th>
                <td><?php echo htmlspecialchars($note['videoId']); ?></td>
            </tr>
            <tr>
                <th>Note</th>
                <td><?php echo htmlspecialchars($note['note']); ?></td>
            </tr>
        </table>
    </div>

</body>

</html>