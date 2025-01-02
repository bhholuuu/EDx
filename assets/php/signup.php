<?php
// Include database connection
include '_connectionDb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    // Retrieve form inputs
    $username = $_POST['signupUsername'];
    $firstName = $_POST['signupFirstName'];
    $lastName = $_POST['signupLastName'];
    $password = $_POST['signupPassword'];  // Get password as it is
    $confirmPassword = $_POST['signupcPassword'];
    $favThing = $_POST['signupFavThing'];

    // Validate passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Check if the user is an admin
    $isAdmin = 0;  // Default is user
    if ($username === 'admin' && $password === 'admin') {
        // If username and password match the admin credentials
        $isAdmin = 1;  // Mark as admin
    }

    try {
        // Prepare the SQL statement, using 'Password' for the password column
        $stmt = $conn->prepare("INSERT INTO users (userName, fName, lName, Password, favouriteThing, isAdmin) 
                                VALUES (:userName, :fName, :lName, :password, :favThing, :isAdmin)");
        $stmt->bindParam(':userName', $username);
        $stmt->bindParam(':fName', $firstName);
        $stmt->bindParam(':lName', $lastName);
        $stmt->bindParam(':password', $password); // Pass plain password here
        $stmt->bindParam(':favThing', $favThing);
        $stmt->bindParam(':isAdmin', $isAdmin);  // Pass isAdmin value (1 for admin, 0 for regular user)

        // Execute the query
        $stmt->execute();

        // Show an alert and then redirect to signupLogin.php
        echo "<script>
                alert('Signup successful!');
                window.location.href='../../signupLogin.php';
            </script>";
        exit;

    } catch (PDOException $e) {
        // Handle duplicate entry for username
        if ($e->getCode() === '23000') { // Duplicate entry error
            echo "<script>alert('Username already exists. Please choose another one.'); window.history.back();</script>";
        } else {
            echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
        }
    }
}
?>