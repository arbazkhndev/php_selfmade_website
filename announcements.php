<?php
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Announcements</title>
    <link rel="stylesheet" href="dist/css/siqtheme.css">
</head>
<body class="theme-dark">
    <div class="container mt-5">
        <h1 class="text-center mb-4">All Announcements</h1>

        <div class="card">
            <ul class="list-group list-group-flush">
                <?php
                $stmt = $conn->prepare("SELECT title, description, created_at FROM announcements ORDER BY created_at DESC");
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows === 0) {
                    echo "<li class='list-group-item'>No announcements found.</li>";
                } else {
                    while($row = $result->fetch_assoc()):
                ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($row['title']) ?></strong> 
                        <small class="text-muted">(<?= date('M d, Y', strtotime($row['created_at'])) ?>)</small>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                    </li>
                <?php 
                    endwhile;
                }
                $stmt->close();
                ?>
            </ul>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>
</body>
</html>
