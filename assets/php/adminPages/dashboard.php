<?php

include './../_connectionDb.php';

// Queries to get the counts
$userCountQuery = "SELECT COUNT(*) AS count FROM users";
$categoryCountQuery = "SELECT COUNT(*) AS count FROM category";
$courseCountQuery = "SELECT COUNT(*) AS count FROM course";
$videoCountQuery = "SELECT COUNT(*) AS count FROM video";
$commentCountQuery = "SELECT COUNT(*) AS count FROM comments";

// Fetch counts
$userCountStmt = $conn->query($userCountQuery);
$userCount = $userCountStmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

$categoryCountStmt = $conn->query($categoryCountQuery);
$categoryCount = $categoryCountStmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

$courseCountStmt = $conn->query($courseCountQuery);
$courseCount = $courseCountStmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

$videoCountStmt = $conn->query($videoCountQuery);
$videoCount = $videoCountStmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

$commentCountStmt = $conn->query($commentCountQuery);
$commentCount = $commentCountStmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

    body.admin-dashboard {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #000000;
        color: #ffffff;
    }

    .admin-dashboard header {
        text-align: center;
        padding: 30px 20px;
        background: linear-gradient(90deg, #1a1a1a, #2b2b2b);
        color: #e0e0e0;
        font-size: 2.5rem;
        font-weight: bold;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        position: relative;
    }

    .admin-dashboard header::after {
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

    .dashboard {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 30px 20px;
        gap: 20px;
        background-color: #1a1a1a;
    }

    .card {
        background: linear-gradient(135deg, #2b2b2b, #3a3a3a);
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        width: 250px;
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.7);
        border-color: #444;
    }

    .card .icon {
        font-size: 3rem;
        color: #777;
        margin-bottom: 10px;
    }

    .card h2 {
        margin: 0;
        font-size: 2.8rem;
        color: #e0e0e0;
        font-weight: bold;
    }

    .card p {
        margin: 15px 0 0;
        font-size: 1.2rem;
        color: #bbbbbb;
    }
    </style>
</head>

<body class="admin-dashboard">
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <div class="dashboard">
        <div class="card">
            <div class="icon"><i class="fa-solid fa-user"></i></div>
            <h2><?php echo $userCount; ?></h2>
            <p>Number of Users</p>
        </div>
        <div class="card">
            <div class="icon"><i class="fa-solid fa-list"></i></div>
            <h2><?php echo $categoryCount; ?></h2>
            <p>Number of Categories</p>
        </div>
        <div class="card">
            <div class="icon"><i class="fa-solid fa-book"></i></div>
            <h2><?php echo $courseCount; ?></h2>
            <p>Number of Courses</p>
        </div>
        <div class="card">
            <div class="icon"><i class="fa-solid fa-video"></i></div>
            <h2><?php echo $videoCount; ?></h2>
            <p>Number of Videos</p>
        </div>
        <div class="card">
            <div class="icon"><i class="fa-solid fa-comments"></i></div>
            <h2><?php echo $commentCount; ?></h2>
            <p>Number of Comments</p>
        </div>
    </div>
</body>

</html>