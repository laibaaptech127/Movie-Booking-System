<?php
include_once "includes/header.php";
include_once "includes/db.php";
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "SELECT * FROM theaters WHERE id = $id";
    $result = mysqli_query($connect, $query);
    $theater = mysqli_fetch_assoc($result);
}
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['theater'];
    $location = $_POST['location'];
    $query = "UPDATE theaters SET name = '$name', location = '$location'  WHERE id = $id";
    $result = mysqli_query($connect, $query);
    if($result){
        header("Location: theaters.php");
        exit();
    }
    else{
        echo "Error updating theater: " . mysqli_error($connect);
    }
}
?>
<div class="admin-main-content">
    <div class="admin-topbar">
        <div>
            <h4 class="text-white fw-bold mb-0">Edit Theater</h4>
            <div class="text-white small">
                Update the theater information.
            </div>
        </div>
    </div>
    <div class="admin-table-card p-4">
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $theater['id']; ?>">
            <div class="mb-3">
            <label class="form-label text-white small fw-bold">Theater Name </label>
            <input type="text" name="theater" class="form-control form-control-cinema" value="<?php echo $theater['name']; ?>" required>
            </div>
            <div class="mb-3">
            <label class="form-label text-white small fw-bold">Location</label>
            <input type="text" name="location" class="form-control form-control-cinema" value="<?php echo $theater['location']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-cinema"><i class="fa-solid fa-pen me-2"></i>Update Theater</button>
            <a href="theaters.php" 
               class="btn btn-cinema-outline ms-2">
                Cancel
            </a>

        </form>

    </div>
</div>

<?php
include_once "includes/footer.php";
?>