<?php
// Include database connection
include '_connectionDb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forPassResetPassword'])) {
    // Retrieve form inputs
    $username = $_POST['forPassUsername'];
    $favouriteThing = $_POST['forPassFavouriteThing'];
    $newPassword = $_POST['forPassNewPassword'];  // Get new password as it is
    $confirmNewPassword = $_POST['forPasscNewPassword'];

    // Validate that the new passwords match
    if ($newPassword !== $confirmNewPassword) {
        echo "<script>alert('New passwords do not match!'); window.history.back();</script>";
        exit;
    }

    try {
        // Prepare the SQL query to find the user by username and favourite thing
        $stmt = $conn->prepare("SELECT * FROM users WHERE userName = :userName AND favouriteThing = :favouriteThing");
        $stmt->bindParam(':userName', $username);
        $stmt->bindParam(':favouriteThing', $favouriteThing);
        $stmt->execute();

        // Check if a user was found
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if the new password is the same as the current password
            if ($user['Password'] === $newPassword) {
                echo "<script>alert('New password cannot be the same as the current password.'); window.history.back();</script>";
                exit;
            }

            // User found, proceed to update the password

            // Prepare the SQL query to update the password (without hashing)
            $updateStmt = $conn->prepare("UPDATE users SET Password = :password WHERE userName = :userName");
            $updateStmt->bindParam(':password', $newPassword);  // Store plain text password
            $updateStmt->bindParam(':userName', $username);

            // Execute the update query
            $updateStmt->execute();

            // Redirect with success message
            echo "<script>alert('Password has been successfully reset!'); window.location.href='../../signupLogin.php';</script>";
        } else {
            // User not found or favourite thing does not match
            echo "<script>alert('Invalid username or favourite thing. Please try again.'); window.history.back();</script>";
        }

    } catch (PDOException $e) {
        // Handle any database errors
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>