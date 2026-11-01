<?php
include_once "includes/db.php";
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "DELETE FROM seats WHERE id = $id";
    $result = mysqli_query($connect, $query);
    if($result){
        header("Location: seat.php");
        exit();
    }else{
        echo "Error deleting seat.";
    }
}

?>