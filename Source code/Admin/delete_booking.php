<?php
include_once "../includes/db.php";
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $query = "DELETE FROM bookings WHERE booking_id = $id";
    if(mysqli_query($connect, $query)){
        header("Location: booking.php");
        exit();
    }
    else{
        echo "Error deleting booking: " . mysqli_error($connect);
    }
}
?>