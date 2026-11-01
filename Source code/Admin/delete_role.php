<?php
include_once "includes/db.php";
$id = $_GET["id"];
$query = "DELETE FROM roles WHERE role_id = $id";
$resultset = mysqli_query($connect,$query);
if($resultset){
    echo "<script>
            window.location.href='role.php';
          </script>";
    exit();
}
else{
    echo "Error deleting role";
}
?>