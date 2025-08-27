<?php
session_start();
require 'db.php';

// Only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!empty($title) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO announcements (title, description, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $title, $description);
        $stmt->execute();
        $stmt->close();

        // Redirect back to dashboard
        header("Location: index.php?msg=Announcement+Created+Successfully");
        exit();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Announcement</title>
    <link rel="stylesheet" href="dist/css/siqtheme.css">
    <link rel="stylesheet" href="dist/fonts/fontawesome.css">
</head>
<body class="theme-dark">
    <div class="container mt-5">
        <h2 class="text-info mb-4">Create Announcement</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label text-light">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Description</label>
                <textarea name="description" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
