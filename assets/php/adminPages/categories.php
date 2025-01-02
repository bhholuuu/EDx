<?php
// Include database connection
include './../_connectionDb.php';

try {
    // Fetch categories from the database using PDO
    $query = "SELECT * FROM category";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
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

    .thumbnail {
        height: 50px;
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

    <header>Categories</header>

    <div class="btn-group">
        <button onclick="window.open('./assets/php/adminPages/addCategory.php', '_blank')">Add Categories</button>
        <button onclick="window.open('./assets/php/adminPages/editCategory.php', '_blank')">Edit Categories</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Thumbnail</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['categoryId']); ?></td>
                <td><?php echo htmlspecialchars($row['categoryName']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>
                    <?php if (!empty($row['thumbnail'])): ?>
                    <img class="thumbnail"
                        src="./assets/php/adminPages/categoryImg/<?php echo htmlspecialchars($row['thumbnail']); ?>"
                        alt="Thumbnail">
                    <?php else: ?>
                    No Image
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="4" class="no-data">No Categories Found</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>