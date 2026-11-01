<?php
session_start();
include_once "../includes/db.php";

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    mysqli_query($connect, "DELETE FROM bookings WHERE user_id = '$user_id'");
    $delete_user = mysqli_query($connect, "DELETE FROM users WHERE user_id = '$user_id'");
    if ($delete_user) {
        header("Location: users.php");
        exit();
    } else {
        echo "Error deleting user: " . mysqli_error($connect);
    }
}
?>