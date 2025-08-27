<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = $conn->query("SELECT image FROM cards WHERE id=$id");
    $card = $result->fetch_assoc();
    if ($card && file_exists($card['image'])) {
        unlink($card['image']); 
    }

    $sql = "DELETE FROM cards WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); 
        exit();
    } else {
        echo "Error deleting card: " . $conn->error;
    }
} else {
    echo "No card selected to delete.";
}
?>
