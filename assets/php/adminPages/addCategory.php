<?php
// Include the database connection
include './../_connectionDb.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = trim($_POST['categoryName']);
    $description = trim($_POST['description']);

    // File upload handling
    $targetDir = "categoryImg/";
    $thumbnailName = $_FILES['thumbnail']['name'];
    $targetFilePath = $targetDir . basename($thumbnailName);
    $uploadOk = true;

    // Validate file upload
    if (!empty($thumbnailName)) {
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array(strtolower($fileType), $allowedTypes)) {
            echo "<script>alert('Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
            $uploadOk = false;
        } elseif (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetFilePath)) {
            echo "<script>alert('There was an error uploading the file.');</script>";
            $uploadOk = false;
        }
    } else {
        echo "<script>alert('Please upload a thumbnail.');</script>";
        $uploadOk = false;
    }

    if (!empty($categoryName) && !empty($description) && $uploadOk) {
        try {
            // Prepare and execute the query
            $query = "INSERT INTO category (categoryName, description, thumbnail) VALUES (:categoryName, :description, :thumbnail)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':thumbnail', $thumbnailName, PDO::PARAM_STR);
            $stmt->execute();

            // Success message
            echo "<script>alert('Category added successfully!'); window.close();</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #000000;
        color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .form-container {
        background: #1a1a1a;
        padding: 20px 30px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
        text-align: center;
        width: 350px;
    }

    h1 {
        margin-bottom: 20px;
        font-size: 1.8rem;
        color: #e0e0e0;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #333;
        border-radius: 4px;
        background: #2b2b2b;
        color: #ffffff;
        font-size: 1rem;
    }

    textarea {
        height: 80px;
        resize: none;
    }

    input[type="file"] {
        margin-bottom: 15px;
        color: #ffffff;
    }

    button {
        padding: 10px 20px;
        font-size: 1rem;
        color: #fff;
        background: #333;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
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
    <div class="form-container">
        <h1>Add New Category</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="text" name="categoryName" placeholder="Enter Category Name" required>
            <textarea name="description" placeholder="Enter Description" required></textarea>
            <input type="file" name="thumbnail" accept="image/*" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>

</html>