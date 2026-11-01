<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    echo "<script>
            alert('Unauthorized Access!');
            window.location.href='../index.php';
          </script>";
    exit();
}
include_once "includes/db.php";
if (isset($_POST["add"])) {
    $Theatername = mysqli_real_escape_string($connect, $_POST["Theatername"]);
    $location = mysqli_real_escape_string($connect, $_POST["location"]);

    $query = "INSERT INTO theaters (`name`, `location`) VALUES ('$Theatername', '$location')";
    $result = mysqli_query($connect, $query);

    if ($result) {
        header("Location: theaters.php");
        exit();
    } else {
        echo mysqli_error($connect);
    }
}
include_once "includes/header.php";
?>

<div class="admin-main-content">
    <h1>Add Theater</h1>
    <form method="post">
        <div class="mb-3">
            <label class="form-label text-white small fw-bold">Theater Name</label>
            <input type="text" name="Theatername" class="form-control form-control-cinema" placeholder="Enter Theater Name" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-white small fw-bold">Location</label>
            <input type="text" name="location" class="form-control form-control-cinema" placeholder="Add Theater Location" required>
        </div>
        <button type="submit" name="add" class="btn btn-cinema py-3 fw-bold mt-2">Add Theater</button>
    </form>
</div>

<?php
include_once "includes/footer.php";
?>