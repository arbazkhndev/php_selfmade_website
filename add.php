<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Card</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Add New Card</h1>
  <form action="add.php" method="POST" enctype="multipart/form-data">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Image:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit" name="submit">Add Card</button>
  </form>

  <p><a href="index.php">⬅ Back to Home</a></p>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];

  $image = $_FILES['image']['name'];
  $target = "uploads/" . basename($image);

  if (!is_dir("uploads")) {
    mkdir("uploads"); 
  }

  if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
    $sql = "INSERT INTO cards (title, description, image) VALUES ('$title', '$description', '$target')";
  } else {
    $sql = "INSERT INTO cards (title, description) VALUES ('$title', '$description')";
  }

  if ($conn->query($sql) === TRUE) {
    echo "<p>Card added successfully!</p>";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>
