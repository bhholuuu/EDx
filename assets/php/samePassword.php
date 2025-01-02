<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $username = $_POST['signupUsername'];
    $firstName = $_POST['signupFirstName'];
    $lastName = $_POST['signupLastName'];
    $password = $_POST['signupPassword'];
    $confirmPassword = $_POST['signupcPassword'];
    $favThing = $_POST['signupFavThing'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<p style='color: red;'>Passwords do not match!</p>";
    } else {
        // Proceed with saving the user to the database
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Database insertion logic here (use prepared statements)
        echo "<p style='color: green;'>Signup successful!</p>";
    }
}
?>