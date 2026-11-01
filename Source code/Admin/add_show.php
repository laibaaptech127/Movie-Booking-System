<?php
session_start();
include_once "../includes/db.php";
$error = "";
if (isset($_POST['add_show'])) {
    $movie_id = $_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];
    $price_gold = $_POST['price_gold'];
    $price_platinum = $_POST['price_platinum'];
    $price_box = $_POST['price_box'];

    $query = "INSERT INTO shows (movie_id, show_date, show_time, price_gold, price_platinum, price_box) 
              VALUES ('$movie_id', '$show_date', '$show_time', '$price_gold', '$price_platinum', '$price_box')";
    mysqli_query($connect, $query);
        if (mysqli_query($connect, $insert_query)) {
            echo "<script>
                    alert('Showtime added successfully!');
                    window.location.href = 'shows.php';
                  </script>";
            exit();
        } else {
            $error = "Database Error: " . mysqli_error($connect);
        }
    } else {
        $error = "Please fill in all required fields properly.";
    }
$movies_res = mysqli_query($connect, "SELECT id, title FROM movies ORDER BY title ASC");
$theaters_res = mysqli_query($connect, "SELECT id, name FROM theaters ORDER BY name ASC");

include_once "includes/header.php";
?>

<div class="admin-main-content py-4">
  <div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="text-white fw-bold mb-1"><i class="fa-solid fa-calendar-plus text-warning me-2"></i>Add New Showtime</h3>
        <p class="text-white small mb-0">Assign a movie to a theater hall with specific timing and price.</p>
      </div>
      <a href="shows.php" class="btn btn-cinema btn-sm">
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
          
          <!-- Movie Selection -->
          <div class="col-md-4">
            <label class="form-label text-white fw-bold">Select Movie</label>
            <select name="movie_id" class="form-select form-control-cinema bg-dark text-white border-secondary" required>
              <option value="">-- Choose Movie --</option>
              <?php while ($m = mysqli_fetch_assoc($movies_res)): ?>
                <option value="<?php echo $m['id']; ?>"><?php echo htmlspecialchars($m['title']); ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <!-- Theater Selection -->
          <div class="col-md-4">
            <label class="form-label text-white fw-bold">Select Theater / Screen</label>
            <select name="theater_id" class="form-select form-control-cinema bg-dark text-white border-secondary" required>
              <option value="">-- Choose Theater --</option>
              <?php while ($t = mysqli_fetch_assoc($theaters_res)): ?>
                <option value="<?php echo $t['id']; ?>"><?php echo $t['name']; ?></option>
              <?php endwhile; ?>
            </select>
          </div>

          <!-- Price -->
          <div class="col-md-4">
            <label class="form-label text-white fw-bold">Ticket Price ($)</label>
            <input type="number" name="ticket_price" class="form-control form-control-cinema bg-dark text-white border-secondary" placeholder="15.00" required>
          </div>

          <!-- Show Date -->
          <div class="col-md-6">
            <label class="form-label text-white fw-bold">Show Date</label>
            <input type="date" name="show_date" class="form-control form-control-cinema bg-dark text-white border-secondary" required>
          </div>

          <!-- Show Time -->
          <div class="col-md-6">
            <label class="form-label text-white fw-bold">Show Time</label>
            <input type="time" name="show_time" class="form-control bg-dark form-control-cinema text-white border-secondary" required>
          </div>

          <div class="row g-3 mb-3">
  <div class="col-md-4">
    <label class="form-label  text-white fw-bold">Gold Price (PKR)</label>
    <input type="number" step="0.01" name="price_gold" class="form-control  bg-dark form-control-cinema text-white border-secondary" placeholder="e.g. 800" required>
  </div>
  <div class="col-md-4">
    <label class="form-label  text-white fw-bold">Platinum Price (PKR)</label>
    <input type="number" step="0.01" name="price_platinum" class="form-control  bg-dark form-control-cinema text-white border-secondary" placeholder="e.g. 1200" required>
  </div>
  <div class="col-md-4">
    <label class="form-label  text-white fw-bold">Box Price (PKR)</label>
    <input type="number" step="0.01" name="price_box" class="form-control  bg-dark form-control-cinema text-white border-secondary" placeholder="e.g. 1800" required>
  </div>
</div>

          <div class="mb-3">
         <label class="form-label text-white small fw-bold">Category</label>

    <select name="category" class="form-select form-control-cinema" required>
        <option value="">Select Category</option>
        <option value="Gold Class">Gold Class</option>
        <option value="Platinum VIP">Platinum VIP</option>
        <option value="VIP Luxury Box">VIP Luxury Box</option>
    </select>
</div>
          <!-- Action Button -->
          <div class="col-12 text-end mt-4">
            <button type="submit" name="add_show" class="btn btn-cinema fw-bold px-4">
              <i class="fa-solid fa-floppy-disk me-1"></i> Save Showtime
            </button>
          </div>

        </div>
      </form>
    </div>

  </div>
</div>
<?php include_once "includes/footer.php"; ?>