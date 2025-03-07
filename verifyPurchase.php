<?php
session_start();
include './assets/php/_connectionDb.php';

header('Content-Type: application/json');

// Check if all required fields are provided
if (!isset($_POST['courseId'], $_POST['username'], $_POST['password'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields!"]);
    exit();
}

$courseId = $_POST['courseId'];
$username = $_POST['username'];
$password = $_POST['password'];

// Fetch user details
$query = "SELECT userId, Password FROM users WHERE userName = :username";
$stmt = $conn->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["success" => false, "message" => "Username does not exist!"]);
    exit();
}

// Check if entered password matches the stored password (plain text comparison)
if ($password !== $user['Password']) {
    echo json_encode(["success" => false, "message" => "Incorrect password!"]);
    exit();
}

// Check if the user has already purchased this course
$queryCheck = "SELECT * FROM purchase WHERE userId = :userId AND courseId = :courseId";
$stmtCheck = $conn->prepare($queryCheck);
$stmtCheck->bindParam(':userId', $user['userId']);
$stmtCheck->bindParam(':courseId', $courseId);
$stmtCheck->execute();

if ($stmtCheck->rowCount() > 0) {
    echo json_encode(["success" => false, "message" => "You have already purchased this course."]);
    exit();
}

// Insert purchase record
$queryInsert = "INSERT INTO purchase (userId, courseId) VALUES (:userId, :courseId)";
$stmtInsert = $conn->prepare($queryInsert);
$stmtInsert->bindParam(':userId', $user['userId']);
$stmtInsert->bindParam(':courseId', $courseId);

if ($stmtInsert->execute()) {
    echo json_encode(["success" => true, "message" => "Purchase successful!"]);
} else {
    echo json_encode(["success" => false, "message" => "Database error, try again later."]);
}

$conn = null;
?>