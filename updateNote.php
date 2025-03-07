<?php
session_start();
include './assets/php/_connectionDb.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['userId'])) {
    echo "error";
    exit;
}

$userId = $_SESSION['userId'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $videoId = $_POST['videoId'];
    $note = trim($_POST['note']);

    try {
        // Check if the note already exists
        $queryCheck = "SELECT * FROM notes WHERE videoId = :videoId AND userId = :userId";
        $stmtCheck = $conn->prepare($queryCheck);
        $stmtCheck->bindParam(':videoId', $videoId, PDO::PARAM_INT);
        $stmtCheck->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() > 0) {
            // Update existing note
            $queryUpdate = "UPDATE notes SET note = :note WHERE videoId = :videoId AND userId = :userId";
        } else {
            // Insert new note
            $queryUpdate = "INSERT INTO notes (videoId, userId, note) VALUES (:videoId, :userId, :note)";
        }

        $stmt = $conn->prepare($queryUpdate);
        $stmt->bindParam(':videoId', $videoId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
}
?>