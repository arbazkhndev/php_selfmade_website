<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
require 'db.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id=? AND role='admin'");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

header("Location:) admin_show.php");
exit();