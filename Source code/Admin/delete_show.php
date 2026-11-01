<?php
session_start();
include_once "../includes/db.php";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $show_id = intval($_GET['id']);
    
    $delete_query = "DELETE FROM shows WHERE id = $show_id";
    if (mysqli_query($connect, $delete_query)) {
        echo "<script>alert('Showtime deleted successfully!'); window.location.href='shows.php';</script>";
    } else {
        echo "<script>alert('Error deleting showtime!'); window.location.href='shows.php';</script>";
    }
} else {
    header("Location: shows.php");
    exit();
}
?>