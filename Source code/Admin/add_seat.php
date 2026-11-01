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
if (isset($_POST['add'])) {
    $theater_id  = mysqli_real_escape_string($connect, $_POST['theater_id']);
    $seat_number = mysqli_real_escape_string($connect, $_POST['seat_number']);
    $category    = mysqli_real_escape_string($connect, $_POST['category']);
    $query = "INSERT INTO seats (theater_id, seat_number, category) VALUES ('$theater_id', '$seat_number', '$category')";
    if (mysqli_query($connect, $query)) {
        header("Location: seat.php");
        exit();
    } else {
        echo "Error adding seat: " . mysqli_error($connect);
    }
}
include_once "includes/header.php";
$theaters_query = "SELECT * FROM theaters";
$theaters = mysqli_query($connect, $theaters_query);
?>
<div class="admin-main-content">
    <h1>Add Seat</h1>
    <form method="post">
        <div class="mb-3">
            <label class="form-label text-white small fw-bold">Select Theater</label>
            <select name="theater_id" class="form-select form-control-cinema" required>
                <option value="">Select Theater</option>
                <?php foreach($theaters as $t){ ?>
                    <option value="<?= $t['id']; ?>"><?= htmlspecialchars($t['name']); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label text-white small fw-bold">Seat Number</label>
            <input type="text" name="seat_number" class="form-control form-control-cinema" placeholder="Enter Seat Number (e.g., A1)" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-white small fw-bold">Category</label>
            <select name="category" class="form-select form-control-cinema" required>
                <option value="Gold Class">Gold Class</option>
                <option value="Platinum VIP">Platinum VIP</option>
                <option value="VIP Luxury Box">VIP Luxury Box</option>
            </select>
        </div>
        <button type="submit" name="add" class="btn btn-cinema py-3 fw-bold mt-2">Add Seat</button>
    </form>
</div>

<?php include_once "includes/footer.php"; ?>