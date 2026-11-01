<?php
include_once "../includes/db.php";
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
$query = "SELECT * FROM movies ORDER BY id DESC";
$movies = mysqli_query($connect, $query);
include_once "includes/header.php";
?>
<div class="admin-main-content py-4">
  <div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
      <div>
        <h3 class="text-white fw-bold mb-1"><i class="fa-solid fa-film text-brand me-2"></i>Manage Movies</h3>
        <p class="text-white small mb-0">View, update, or delete current release catalog and upcoming releases.</p>
      </div>
      <a href="add_movie.php" class="btn btn-cinema btn-sm">
        <i class="fa-solid fa-plus me-1"></i> Add New Movie
      </a>
    </div>

    <div class="admin-table-card p-4">
      <div class="table-responsive">
        <table class="table custom-table align-middle">
          <thead>
            <tr>
              <th>Poster</th>
              <th>Title</th>
              <th>Genre</th>
              <th>Duration</th>
              <th>Format</th>
              <th>Category</th>
              <th>Release Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($movies) && mysqli_num_rows($movies) > 0): ?>
              <?php foreach ($movies as $movie): ?>
                <tr>
                  <td>
                    <img src="../<?php echo $movie['poster']; ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="rounded shadow-sm object-fit-cover" style="width: 50px; height: 70px;">
                  </td>
                  <td class="fw-bold"><?php echo $movie['title']; ?></td>
                  <td><span class="badge bg-secondary text-uppercase"><?php echo htmlspecialchars($movie['genre']); ?></span></td>
                  <td class="text-dark"><?php echo $movie['duration']; ?></td>
                  <td class="text-dark"><?php echo $movie['format']; ?></td>
                  <td>
                    <?php if ($movie['category'] == 'now_showing'): ?>
                      <span class="badge bg-success">Now Showing</span>
                    <?php else: ?>
                      <span class="badge bg-warning text-dark">Upcoming</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-dark"><?php echo htmlspecialchars($movie['release_date']); ?></td>
                  <td>
                    <?php if (!empty($movie['trailer_url'])): ?>
                      <a href="<?php echo htmlspecialchars($movie['trailer_url']); ?>" target="_blank" class="btn btn-sm btn-outline-info me-1" title="Watch Trailer">
                        <i class="fa-solid fa-play"></i>
                      </a>
                    <?php else: ?>
                      <button class="btn btn-sm btn-outline-secondary me-1" disabled title="No Trailer Link">
                        <i class="fa-solid fa-play"></i>
                      </button>
                    <?php endif; ?>

                    <a href="edit_movie.php?id=<?php echo $movie['id']; ?>" class="btn btn-sm btn-warning me-1">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="delete_movie.php?id=<?php echo $movie['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this movie?')">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center text-muted py-5">No movies found in the database.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once "includes/footer.php"; ?>