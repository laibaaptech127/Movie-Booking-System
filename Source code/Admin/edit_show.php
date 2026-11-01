<?php
session_start();
include_once "../includes/db.php";
$error = "";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: shows.php");
    exit();
}
$show_id = $_GET['id'];
$fetch_show = mysqli_query($connect, "SELECT * FROM shows WHERE id = $show_id");
if (mysqli_num_rows($fetch_show) == 0) {
    header("Location: shows.php");
    exit();
}
$show_data = mysqli_fetch_assoc($fetch_show);
if (isset($_POST['update_show'])) {
    $movie_id = $_POST['movie_id'];
    $theater_id = $_POST['theater_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];
    $ticket_price = $_POST['ticket_price'];

    $update_query = "UPDATE shows SET movie_id = '$movie_id', theater_id = '$theater_id', show_date = '$show_date', show_time = '$show_time', ticket_price = '$ticket_price' WHERE id = $show_id";
    if (mysqli_query($connect, $update_query)) {
        echo "<script>alert('Showtime updated successfully!'); window.location.href='shows.php';</script>";
        exit();
    } else {
        $error = "Database Error: " . mysqli_error($connect);
    }
}
$movies_res = mysqli_query($connect, "SELECT id, title FROM movies ORDER BY title ASC");
$theaters_res = mysqli_query($connect, "SELECT id, name FROM theaters ORDER BY name ASC");
include_once "includes/header.php";
?>
<div class="admin-main-content py-4">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="text-white fw-bold mb-1"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Edit Showtime</h3>
        <p class="text-white small mb-0">Modify date, time, or assigned theater screen.</p>
      </div>
      <a href="shows.php" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Shows
      </a>
    </div>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-exclamation me-2"></i><?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <div class="admin-table-card p-4">
      <form action="" method="POST">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label text-white fw-bold">Movie</label>
            <select name="movie_id" class="form-select form-control bg-dark text-white border-secondary" required>
              <?php while ($m = mysqli_fetch_assoc($movies_res)): ?>
                <option value="<?php echo $m['id']; ?>" <?php echo ($m['id'] == $show_data['movie_id']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($m['title']); ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label text-white fw-bold">Theater / Screen</label>
            <select name="theater_id" class="form-select form-control bg-dark text-white border-secondary" required>
              <?php while ($t = mysqli_fetch_assoc($theaters_res)): ?>
                <option value="<?php echo $t['id']; ?>" <?php echo ($t['id'] == $show_data['theater_id']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($t['name']); ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label text-white fw-bold">Base Ticket Price ($)</label>
            <input type="number" step="0.01" name="ticket_price" class="form-control bg-dark text-white border-secondary" value="<?php echo $show_data['ticket_price']; ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label text-white fw-bold">Show Date</label>
            <input type="date" name="show_date" class="form-control bg-dark text-white border-secondary" value="<?php echo $show_data['show_date']; ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label text-white fw-bold">Show Time</label>
            <input type="time" name="show_time" class="form-control bg-dark text-white border-secondary" value="<?php echo $show_data['show_time']; ?>" required>
          </div>
          <div class="col-12 text-end mt-4">
            <button type="submit" name="update_show" class="btn btn-warning fw-bold px-4">
              <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include_once "includes/footer.php"; ?>