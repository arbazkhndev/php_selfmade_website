<?php
session_start();
require 'db.php';

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Only allow normal users to see their own profile
if ($_SESSION['role'] !== 'admin' && $id !== $_SESSION['user_id']) {
    die("Access denied.");
}

// Fetch user data
$stmt = $conn->prepare("SELECT id, username, first_name, last_name, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Profile</title>
    <link rel="stylesheet" href="dist/css/siqtheme.css">
    <link rel="stylesheet" href="dist/fonts/fontawesome.css">
</head>
<body class="theme-dark">
    <div class="container mt-5">
        <h2 class="text-info mb-4">User Profile</h2>
        <div class="card bg-dark text-white mb-4">
            <div class="card-body">
                <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                <p><strong>First Name:</strong> <?= htmlspecialchars($user['first_name']) ?></p>
                <p><strong>Last Name:</strong> <?= htmlspecialchars($user['last_name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary">Back to page</a>
    </div>
</body>
</html>
