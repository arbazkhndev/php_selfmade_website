<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
require 'db.php';

$id = intval($_GET['id'] ?? 0);
$error = '';
$success = '';

if ($id > 0) {
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $new_password = $_POST['new_password'] ?? '';

        if ($username === '') {
            $error = 'Username cannot be empty.';
        } else {
            if ($new_password !== '') {
                $hash = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET username=?, first_name=?, last_name=?, email=?, password=? WHERE id=? AND role='admin'");
                $stmt->bind_param('sssssi', $username, $first_name, $last_name, $email, $hash, $id);
            } else {
                $stmt = $conn->prepare("UPDATE users SET username=?, first_name=?, last_name=?, email=? WHERE id=? AND role='admin'");
                $stmt->bind_param('ssssi', $username, $first_name, $last_name, $email, $id);
            }
            if ($stmt->execute()) {
                $success = 'Admin updated successfully!';
            } else {
                $error = 'Update failed.';
            }
            $stmt->close();
        }
    }

    // Fetch admin data
    $stmt = $conn->prepare("SELECT username, first_name, last_name, email FROM users WHERE id=? AND role='admin'");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $admin = $res->fetch_assoc();
    $stmt->close();
} else {
    $error = 'Invalid admin ID.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
    <h2 class="mb-4 text-info"><i class="ti-pencil"></i> Edit Admin</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($admin): ?>
    <form method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($admin['username']) ?>" required>
        </div>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($admin['first_name']) ?>">
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($admin['last_name']) ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['email']) ?>">
        </div>
        <div class="form-group">
            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="admin_show.php" class="btn btn-secondary">Back</a>
    </form>
    <?php endif; ?>
</div>