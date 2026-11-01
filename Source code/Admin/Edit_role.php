<?php
include_once "includes/header.php";
include_once "includes/db.php";
    $id = $_GET['id'];
    $query = "SELECT * FROM roles WHERE role_id = $id";
    $result = mysqli_query($connect, $query);
    $role = mysqli_fetch_assoc($result);    
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $role_name = $_POST['role'];
    $query = "UPDATE roles SET role_name = '$role_name' WHERE role_id = $id";
    $result = mysqli_query($connect, $query);
    if($result){
        header("Location: role.php");
        exit();
    }
    else{
        echo "Error updating role";
    }
}
?>
<div class="admin-main-content">
    <div class="admin-topbar">
        <div>
            <h4 class="text-white fw-bold mb-0">Edit Role</h4>
            <div class="text-white small">Update the role information.</div>
        </div>
    </div>
    <div class="admin-table-card p-4">
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $role['role_id']; ?>">
            <div class="mb-3">
                <label class="form-label text-white small fw-bold">Role Name</label>
                <input type="text" name="role" class="form-control form-control-cinema" value="<?php echo $role['role_name']; ?>"required >
            </div>
            <a href="show_roles.php"><button type="submit" name="update" class="btn btn-cinema"><i class="fa-solid fa-pen me-2"></i>Update Role</button></a>
            <a href="show_roles.php"class="btn btn-cinema-outline ms-2 ">Cancel</a>
        </form>
    </div>
</div>
<?php
include_once "includes/footer.php";
?>