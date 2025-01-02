<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bhavya_demo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users data
$sql = "SELECT userId, userName, fName, lName, favouriteThing, Password FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Table</title>
    <style>
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

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

    tr:first-child:hover {
        background-color: #000000;
    }

    .no-data {
        text-align: center;
        font-size: 1.2rem;
        color: #bbbbbb;
        padding: 20px;
    }

    .delete-icon {
        color: #ff4d4d;
        cursor: pointer;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    .delete-icon:hover {
        color: #ff1a1a;
    }
    </style>
</head>

<body>
    <header>Users Table</header>

    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Favourite Thing</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['userId']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['userName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['favouriteThing']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Password']) . "</td>";
                    echo "<td><a href='./assets/php/adminPages/delete_user.php?userId=" . $row['userId'] . "' class='delete-icon'><i class='fa-solid fa-trash-can'></i></a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='no-data'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>

</html>