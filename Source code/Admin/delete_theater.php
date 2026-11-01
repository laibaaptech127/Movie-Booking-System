<?php
include_once "includes/db.php";
$id = $_GET["id"];
$query = "DELETE FROM theaters WHERE id = $id";
$resultset = mysqli_query($connect,$query);
if($resultset){
    echo "<script>
            window.location.href='theaters.php';
          </script>";
    exit();
}
else{
    echo "Error deleting theater";
}
?>