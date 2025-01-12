<?php
// Include database connection
include '_connectionDb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    // Retrieve form inputs
    $username = $_POST['signupUsername'];
    $firstName = $_POST['signupFirstName'];
    $lastName = $_POST['signupLastName'];
    $password = $_POST['signupPassword']; // Get password as it is
    $confirmPassword = $_POST['signupcPassword'];
    $favThing = $_POST['signupFavThing'];
    $avatar = $_POST['signupAvatar']; // Get selected avatar

    // Reserved usernames that cannot be used
    $reservedUsernames = ['admin', 'a1', 'a2', 'a3', 'a4', 'a5', 'a6', 'a7', 'a8'];

    // Validate username is not reserved
    if (in_array(strtolower($username), $reservedUsernames)) {
        echo "<script>
                alert('The username you entered is reserved and cannot be used. Please choose another username.');
                window.history.back();
            </script>";
        exit;
    }

    // Validate passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // Check if the username already exists in the database
    try {
        $stmt = $conn->prepare("SELECT userName FROM users WHERE userName = :userName");
        $stmt->bindParam(':userName', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<script>
                    alert('The username already exists. Please choose another one.');
                    window.history.back();
                </script>";
            exit;
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error checking username: " . $e->getMessage() . "'); window.history.back();</script>";
        exit;
    }

    // Check if the user is an admin (Old functionality remains unchanged)
    $isAdmin = 0; // Default is user
    if ($username === 'admin' && $password === 'admin') {
        // If username and password match the admin credentials
        $isAdmin = 1; // Mark as admin
    }

    try {
        // Prepare the SQL statement, adding 'avatar' column
        $stmt = $conn->prepare("INSERT INTO users (userName, fName, lName, Password, favouriteThing, isAdmin, avatar) 
                                VALUES (:userName, :fName, :lName, :password, :favThing, :isAdmin, :avatar)");
        $stmt->bindParam(':userName', $username);
        $stmt->bindParam(':fName', $firstName);
        $stmt->bindParam(':lName', $lastName);
        $stmt->bindParam(':password', $password); // Pass plain password here
        $stmt->bindParam(':favThing', $favThing);
        $stmt->bindParam(':isAdmin', $isAdmin); // Pass isAdmin value (1 for admin, 0 for regular user)
        $stmt->bindParam(':avatar', $avatar);

        // Execute the query
        $stmt->execute();

        // Show an alert and then redirect to signupLogin.php
        echo "<script>
                alert('Signup successful!');
                window.location.href='../../signupLogin.php';
            </script>";
        exit;

    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>