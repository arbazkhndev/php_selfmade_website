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

// Delete announcement
$stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: announcements.php");
exit();
?>
