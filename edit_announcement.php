<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require 'db.php';

if (!isset($_GET['id'])) {
    header("Location: announcements.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT title, description FROM announcements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$announcement = $result->fetch_assoc();
$stmt->close();

if (!$announcement) {
    echo "Announcement not found!";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE announcements SET title = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $description, $id);
    if ($stmt->execute()) {
        header("Location: announcements.php");
        exit();
    } else {
        echo "Update failed!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Announcement</title>
<link rel="stylesheet" href="dist/css/siqtheme.css">
</head>
<body class="theme-dark">
<div class="container mt-5">
    <h2>Edit Announcement</h2>
    <form method="POST">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($announcement['title']) ?>" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($announcement['description']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="announcements.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
