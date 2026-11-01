<?php
include_once "includes/header.php";
include_once "includes/db.php";
?>
<div class="admin-main-content">
<?php
if(isset($_POST["add"])){
    $role=$_POST["role"];
    $query= "INSERT INTO `roles`(`role_name`) VALUES ('$role')";
    $result= mysqli_query($connect,$query);
    if($result){
        header("Location: role.php");
        exit();
    }
    else{
        echo "error"; 
    }
}
?>
<h1>Add Role</h1>
<form method="post">
    <div class="mb-3">
            <label class="form-label text-white small fw-bold">Role Name</label>
            <input type="text" name="role" class="form-control form-control-cinema" placeholder="Enter Role Name" >
            </div>
            <a href="role.php"><button type="submit" name="add" class="btn btn-cinema py-3 fw-bold mt-2">Add Role</button></a>
</form>
</div>
<?php
include_once "includes/footer.php";
?>