<?php
// Include the database connection
include './../_connectionDb.php';

try {
    // Fetch courses
    $query = "SELECT * FROM course";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error fetching courses: " . $e->getMessage() . "');</script>";
    $courses = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
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

    .btn-group {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin: 20px;
    }

    .btn-group button {
        padding: 10px 20px;
        font-size: 1rem;
        color: #fff;
        background: #333;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-group button:hover {
        background: #555;
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
    </style>
</head>

<body>
    <header>Courses</header>

    <div class="btn-group">
        <button onclick="window.open('./assets/php/adminPages/addCourse.php', '_blank')">Add Course</button>
        <button onclick="window.open('./assets/php/adminPages/editCourse.php', '_blank')">Edit Courses</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Course ID</th>
                <th>Category ID</th>
                <th>Course Name</th>
                <th>Fees</th>
                <th>Description</th>
                <th>Thumbnail</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['courseId']); ?></td>
                <td><?php echo htmlspecialchars($row['categoryId']); ?></td>
                <td><?php echo htmlspecialchars($row['courseName']); ?></td>
                <td><?php echo htmlspecialchars($row['fees']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>
                    <?php if (!empty($row['thumbnail'])): ?>
                    <img src="./assets/php/adminPages/courseImg/<?php echo htmlspecialchars($row['thumbnail']); ?>"
                        alt="Thumbnail" style="height: 50px;">
                    <?php else: ?>
                    No Image
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="6" class="no-data">No Courses Found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>