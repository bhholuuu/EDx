<?php
// Include the database connection
include './../_connectionDb.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    try {
        $query = "DELETE FROM category WHERE categoryId = :categoryId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':categoryId', $idToDelete, PDO::PARAM_INT);
        $stmt->execute();
        echo "<script>alert('Category deleted successfully!'); window.location.href='editCategory.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Handle edit request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editCategoryId'])) {
    $categoryId = $_POST['editCategoryId'];
    $categoryName = trim($_POST['categoryName']);
    $description = trim($_POST['description']);
    $thumbnail = $_FILES['thumbnail'];

    if (!empty($categoryName)) {
        try {
            $query = "UPDATE category SET categoryName = :categoryName, description = :description WHERE categoryId = :categoryId";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->execute();

            // Handle thumbnail upload
            if (!empty($thumbnail['name'])) {
                $targetDir = "./categoryImg/";
                $targetFile = $targetDir . basename($thumbnail['name']);
                if (move_uploaded_file($thumbnail['tmp_name'], $targetFile)) {
                    $query = "UPDATE category SET thumbnail = :thumbnail WHERE categoryId = :categoryId";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':thumbnail', $thumbnail['name'], PDO::PARAM_STR);
                    $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    echo "<script>alert('Error uploading thumbnail.');</script>";
                }
            }

            echo "<script>alert('Category updated successfully!'); window.location.href='editCategory.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Please enter a category name.');</script>";
    }
}

// Fetch categories
try {
    $query = "SELECT * FROM category";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    $categories = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Categories</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #000000;
        color: #ffffff;
        margin: 0;
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background: #1a1a1a;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #333;
    }

    th {
        background-color: #333;
        color: #fff;
    }

    tr:hover {
        background-color: #444;
    }

    .actions button {
        padding: 5px 10px;
        margin: 0 5px;
        font-size: 0.9rem;
        color: #fff;
        background: #555;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .actions button:hover {
        background: #777;
    }

    .form-container {
        margin-top: 20px;
        padding: 15px;
        background: #222;
        border-radius: 8px;
    }

    input[type="text"],
    textarea {
        padding: 10px;
        width: calc(100% - 22px);
        margin-bottom: 10px;
        border: 1px solid #555;
        border-radius: 4px;
        background: #1a1a1a;
        color: #fff;
    }

    button[type="submit"] {
        padding: 10px 15px;
        color: #fff;
        background: #333;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background: #555;
    }

    input[type="file"] {
        padding: 10px 15px;
        color: #fff;
        background: #333;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: auto;
    }

    input[type="file"]:hover {
        background: #555;
    }
    </style>
</head>

<body>
    <h1>Edit or Delete Categories</h1>

    <table>
        <thead>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Thumbnail</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo $category['categoryId']; ?></td>
                <td><?php echo htmlspecialchars($category['categoryName']); ?></td>
                <td><?php echo htmlspecialchars($category['description']); ?></td>
                <td>
                    <?php if (!empty($category['thumbnail'])): ?>
                    <img src="./categoryImg/<?php echo htmlspecialchars($category['thumbnail']); ?>" alt="Thumbnail"
                        style="height: 50px;">
                    <?php else: ?>
                    No Image
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <button
                        onclick="showEditForm('<?php echo $category['categoryId']; ?>', '<?php echo htmlspecialchars($category['categoryName']); ?>', '<?php echo htmlspecialchars($category['description']); ?>')">Edit</button>
                    <button onclick="deleteCategory('<?php echo $category['categoryId']; ?>')">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="5">No categories found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="editForm" class="form-container" style="display: none;">
        <h2>Edit Category</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="editCategoryId" id="editCategoryId">
            <input type="text" name="categoryName" id="editCategoryName" placeholder="Enter New Category Name" required>
            <textarea name="description" id="editDescription" placeholder="Enter Description" required></textarea>
            <input type="file" name="thumbnail" accept="image/*">
            <button type="submit">Update</button>
        </form>
    </div>

    <script>
    function showEditForm(id, name, description) {
        document.getElementById('editForm').style.display = 'block';
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editDescription').value = description;
    }

    function deleteCategory(id) {
        if (confirm('Are you sure you want to delete this category?')) {
            window.location.href = 'editCategory.php?delete=' + id;
        }
    }
    </script>
</body>

</html>