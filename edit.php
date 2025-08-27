<?php
session_start();
include 'db.php';

// Only allow logged-in users
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Get card ID from URL
if (!isset($_GET['id'])) {
    echo "No card selected.";
    exit();
}
$id = $_GET['id'];

// Fetch card data
$result = $conn->query("SELECT * FROM cards WHERE id=$id");
$card = $result->fetch_assoc();

// Update card if form is submitted
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Handle image upload
    $image = $card['image']; // keep old image by default
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir);
        $target_file = $target_dir . basename($_FILES["image"]["tmp_name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image = $target_file;
    }

    $sql = "UPDATE cards SET title='$title', description='$description', image='$image' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating card: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Card</title>
</head>
<body>
    <h2>Edit Card</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo $card['title']; ?>" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" required><?php echo $card['description']; ?></textarea><br><br>

        <label>Current Image:</label><br>
        <img src="<?php echo $card['image']; ?>" width="100"><br><br>

        <label>Upload New Image:</label><br>
        <input type="file" name="image"><br><br>

        <button type="submit" name="update">Update Card</button>
    </form>
    <p><a href="index.php">⬅ Back to Home</a></p>
</body>
</html>
