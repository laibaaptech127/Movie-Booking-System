<?php
ob_start();
session_start();
include_once "../includes/db.php";
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    echo "<script>
            alert('Unauthorized Access!');
            window.location.href='../index.php';
          </script>";
    exit();
}
$shows_query = "SELECT shows.*, movies.title AS movie_title, theaters.name AS theater_name 
                FROM shows 
                JOIN movies ON shows.movie_id = movies.id 
                JOIN theaters ON shows.theater_id = theaters.id 
                ORDER BY shows.show_date DESC, shows.show_time ASC";

$shows_res = mysqli_query($connect, $shows_query);
if (!$shows_res) {
    die("Query Failed: " . mysqli_error($connect));
}
include_once "includes/header.php";
?>
<div class="admin-main-content py-4">
  <div class="container">
    <!-- Top Action Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h3 class="text-white fw-bold mb-1"><i class="fa-solid text-brand fa-clock me-2"></i>Manage Showtimes</h3>
        <p class="text-white small mb-0">Schedule movie showtimes across different theaters and screens.</p>
      </div>
      <a href="add_show.php" class="btn btn-cinema fw-bold btn-sm">
        <i class="fa-solid fa-plus me-1"></i> Add New Showtime
      </a>
    </div>

    <!-- Scheduled Shows List -->
    <div class="admin-table-card p-4">
      <div class="table-responsive">
        <table class="table custom-table align-middle">
          <thead>
            <tr>
              <th>Movie Title</th>
              <th>Theater / Screen</th>
              <th>Show Date</th>
              <th>Show Time</th>
              <th>Category</th>
              <th>Price</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($shows_res) > 0): ?>
              <?php while ($show = mysqli_fetch_assoc($shows_res)): ?>
                <tr>
                  <td class="fw-bold text-black"><?php echo htmlspecialchars($show['movie_title'] ?? ''); ?></td>
                  <td class="text-black"><?php echo htmlspecialchars($show['theater_name'] ?? ''); ?></td>
                  <td><span class="badge bg-black"><?php echo $show['show_date'] ?? ''; ?></span></td>
                  <td class="text-warning fw-bold"><?php echo isset($show['show_time']) ? date("g:i A", strtotime($show['show_time'])) : ''; ?></td>
                  <td><span class="badge bg-black"><?php echo $show['category'] ?? ''; ?></span></td>
                  <td class="text-success fw-bold">$<?php echo number_format($show['ticket_price'] ?? 0, 2); ?></td>
                  <td class="text-end">
                    <a href="edit_show.php?id=<?php echo $show['id']; ?>" class="btn btn-sm btn-warning me-1">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="delete_show.php?id=<?php echo $show['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this showtime?')">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted py-5">No showtimes scheduled yet.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<?php include_once "includes/footer.php"; ?>