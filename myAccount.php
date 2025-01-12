<?php
session_start();
include './assets/php/_connectionDb.php'; // Ensure this file connects to your database

// Redirect if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: signupLogin.php');
    exit();
}

// Fetch user data from the database using username from session
if (!isset($_SESSION['username'])) {
    die('Username not found in session.');
}

$username = $_SESSION['username'];

try {
    $query = "SELECT username, fname, lname, favouriteThing, avatar, password FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die('User not found.');
    }

    // Assign user data for display
    $displayName = $user['username'];
    $fname = $user['fname'];
    $lname = $user['lname'];
    $favThing = $user['favouriteThing'];
    $avatarPath = $user['avatar'] 
        ? './assets/img/avatar/' . $user['avatar'] 
        : './assets/img/avatar/default.png';

    // Fetch available avatars
    $avatarDir = './assets/img/avatar/';
    $avatars = array_diff(scandir($avatarDir), ['.', '..']);

    // Update logic (handle form submission)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle profile update (avatar, fname, lname)
        $newAvatar = $_POST['new_avatar'] ?? '';
        $newFname = $_POST['new_fname'] ?? '';
        $newLname = $_POST['new_lname'] ?? '';

        if ($newAvatar && $newFname && $newLname) {
            $updateQuery = "UPDATE users SET avatar = :avatar, fname = :fname, lname = :lname WHERE username = :username";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindValue(':avatar', $newAvatar, PDO::PARAM_STR);
            $updateStmt->bindValue(':fname', $newFname, PDO::PARAM_STR);
            $updateStmt->bindValue(':lname', $newLname, PDO::PARAM_STR);
            $updateStmt->bindValue(':username', $username, PDO::PARAM_STR);
            $updateStmt->execute();

            // Refresh the page to show updated data
            header("Location: myAccount.php");
            exit();
        }

        // Handle password change
        if (isset($_POST['change_password'])) {
            $enteredFavThing = $_POST['favourite_thing'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Check if favourite thing matches
            if ($enteredFavThing !== $favThing) {
                echo "<script>alert('Favourite thing does not match.');</script>";
            }
            // Check if new password and confirm password match
            elseif ($newPassword !== $confirmPassword) {
                echo "<script>alert('Passwords do not match.');</script>";
            }
            // Update password (store as plain text)
            else {
                // Do not hash the password, store it as plain text
                $updatePasswordQuery = "UPDATE users SET password = :password WHERE username = :username";
                $updatePasswordStmt = $conn->prepare($updatePasswordQuery);
                $updatePasswordStmt->bindValue(':password', $newPassword, PDO::PARAM_STR);
                $updatePasswordStmt->bindValue(':username', $username, PDO::PARAM_STR);
                $updatePasswordStmt->execute();

                echo "<script>
    alert('Password updated successfully.');
    window.location.href = 'myAccount.php';
</script>";
exit();

            }
        }
    }

} catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        text-align: center;
        position: relative;
        max-width: 400px;
        width: 100%;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin: 20px auto;
        display: block;
        object-fit: cover;
        border: 2px solid #ddd;
    }

    .edit-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #0077cc;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 14px;
    }

    .edit-btn:hover {
        background-color: #005799;
    }

    .edit-pass-btn {
        top: 10px;
        right: 10px;
        background-color: #0077cc;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 14px;
    }

    .edit-pass-btn:hover {
        background-color: #005799;
    }

    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        display: none;
    }

    .popup.active {
        display: block;
    }

    .popup .close-btn {
        background-color: #ff5c5c;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 14px;
    }

    .popup .close-btn:hover {
        background-color: #e53e3e;
    }

    .popup form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .popup input {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .popup button {
        padding: 10px;
        background-color: #0077cc;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .popup button:hover {
        background-color: #005799;
    }

    .avatar-options {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    .avatar-options img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.3s;
    }

    .avatar-options img:hover {
        border-color: #0077cc;
    }

    .avatar-options input[type="radio"] {
        display: none;
    }

    .avatar-options input[type="radio"]:checked+img {
        border-color: #0077cc;
    }

    .logout-btn {
        background-color: #f44336;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 14px;
        margin-top: 15px;
        transition: background-color 0.3s;
    }

    .logout-btn:hover {
        background-color: #d32f2f;
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Display user avatar -->
        <img src="<?= htmlspecialchars($avatarPath) ?>" alt="User Avatar" class="avatar">
        <p class="username"><b>@<?= htmlspecialchars($displayName) ?></b></p>

        <div class="info">
            <p><span>First Name:</span> <?= htmlspecialchars($fname) ?></p>
            <p><span>Last Name:</span> <?= htmlspecialchars($lname) ?></p>
            <p><span>Password:</span> **********</p>
            <button class="edit-pass-btn">Edit Password</button>
            <p><span>Favourite Thing:</span> **********</p>
        </div>

        <button class="edit-btn" onclick="showPopup()">Edit</button>

        <!-- Edit Password Popup -->
        <div class="popup" id="passwordPopup">
            <button class="close-btn" onclick="closePasswordPopup()">Close</button>
            <form method="POST" action="">
                <label for="favourite_thing">Favourite Thing:</label>
                <input type="text" name="favourite_thing" placeholder="Enter your favourite thing" required>

                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" placeholder="Enter new password" required>

                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>

                <button type="submit" name="change_password">Change Password</button>
            </form>
        </div>

        <!-- Edit Profile Popup -->
        <div class="popup" id="editPopup">
            <button class="close-btn" onclick="closePopup()">Close</button>
            <form method="POST" action="">
                <label for="new_fname">New First Name:</label>
                <input type="text" name="new_fname" value="<?= htmlspecialchars($fname) ?>"
                    placeholder="Enter new first name" required>

                <label for="new_lname">New Last Name:</label>
                <input type="text" name="new_lname" value="<?= htmlspecialchars($lname) ?>"
                    placeholder="Enter new last name" required>

                <label for="new_avatar">Choose Avatar:</label>
                <div class="avatar-options">
                    <?php foreach ($avatars as $avatar): ?>
                    <label>
                        <input type="radio" name="new_avatar" value="<?= htmlspecialchars($avatar) ?>" required>
                        <img src="<?= $avatarDir . htmlspecialchars($avatar) ?>" alt="Avatar Option">
                    </label>
                    <?php endforeach; ?>
                </div>

                <button type="submit">Update</button>
            </form>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="./assets/php/logout.php">
            <button type="submit" class="logout-btn">Logout</button>
        </form>

    </div>

    <script>
    const passwordPopup = document.getElementById('passwordPopup');
    const editPopup = document.getElementById('editPopup');

    function showPopup() {
        editPopup.classList.add('active');
    }

    function closePopup() {
        editPopup.classList.remove('active');
    }

    function showPasswordPopup() {
        passwordPopup.classList.add('active');
    }

    function closePasswordPopup() {
        passwordPopup.classList.remove('active');
    }

    document.querySelector('.edit-pass-btn').addEventListener('click', showPasswordPopup);
    </script>
</body>

</html>