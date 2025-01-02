<?php

include './../_connectionDb.php';

if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);

    // Delete the user
    $sql = "DELETE FROM users WHERE userId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

// Redirect back to the table page
header("Location: users_table.php");
exit;
?>