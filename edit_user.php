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
                $stmt = $conn->prepare("UPDATE users SET username=?, first_name=?, last_name=?, email=?, password=? WHERE id=?");
                $stmt->bind_param('sssssi', $username, $first_name, $last_name, $email, $hash, $id);
            } else {
                $stmt = $conn->prepare("UPDATE users SET username=?, first_name=?, last_name=?, email=? WHERE id=?");
                $stmt->bind_param('ssssi', $username, $first_name, $last_name, $email, $id);
            }
            if ($stmt->execute()) {
                $success = 'User updated successfully!';
            } else {
                $error = 'Update failed.';
            }
            $stmt->close();
        }
    }

    // Fetch user data
    $stmt = $conn->prepare("SELECT username, first_name, last_name, email FROM users WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();
} else {
    $error = 'Invalid user ID.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
    <h2 class="mb-4 text-info"><i class="ti-pencil"></i> Edit User</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <?php if ($user): ?>
    <form method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>">
        </div>
        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>">
        </div>
        <div class="form-group">
            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="user_show.php" class="btn btn-secondary">Back</a>
    </form>
    <?php endif; ?>
</div>
</body>
</html>