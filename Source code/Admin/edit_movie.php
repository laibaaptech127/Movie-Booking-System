<?php
session_start();
include_once "../includes/db.php";
$error = "";
$success = "";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: movies.php");
    exit();
}
$movie_id = intval($_GET['id']);
$fetch_query = "SELECT * FROM movies WHERE id = $movie_id";
$result = mysqli_query($connect, $fetch_query);

if (mysqli_num_rows($result) == 0) {
    header("Location: movies.php");
    exit();
}
$movie = mysqli_fetch_assoc($result);
if (isset($_POST['update_movie'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $duration = $_POST['duration'];
    $format  = $_POST['format'];
    $category = $_POST['category'];
    $release_date = $_POST['release_date'];
    $trailer_url = $_POST['trailer_url'];
    $poster_path = $movie['poster']; 
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] == 0) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
        $file_name = $_FILES['poster']['name'];
        $file_tmp = $_FILES['poster']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = "poster_" . time() . "_" . rand(1000, 9999) . "." . $file_ext;
            $upload_directory = "../uploads/posters/";
            if (!is_dir($upload_directory)) {
                mkdir($upload_directory, 0777, true);
            }
            $target_path = $upload_directory . $new_file_name;
            if (move_uploaded_file($file_tmp, $target_path)) {
                if (!empty($movie['poster']) && file_exists("../" . $movie['poster'])) {
                    unlink("../" . $movie['poster']);
                }
                $poster_path = "uploads/posters/" . $new_file_name;
            } else {
                $error = "Failed to upload new poster image.";
            }
        } else {
            $error = "Invalid image format! Only JPG, JPEG, PNG, and WEBP allowed.";
        }
    }
    if (empty($error)) {
        $update_query = "UPDATE movies SET title = '$title', format='$format', genre = '$genre', duration = '$duration', category = '$category', release_date = '$release_date', trailer_url = '$trailer_url', poster = '$poster_path' WHERE id = $movie_id";
        if (mysqli_query($connect, $update_query)) {
            echo "<script>
                    alert('Movie updated successfully!');
                    window.location.href = 'movie.php';
                  </script>";
            exit();
        } else {
            $error = "Database Error: " . mysqli_error($connect);
        }
    }
}
include_once "includes/header.php";
?>
<div class="admin-main-content py-4">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="text-white fw-bold mb-1"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Edit Movie</h3>
        <p class="text-muted small mb-0">Update movie details, trailer link, or change poster image.</p>
      </div>
      <a href="movies.php" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to Movies
      </a>
    </div>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-circle-exclamation me-2"></i><?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="admin-table-card p-4">
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label text-white fw-bold">Movie Title</label>
            <input type="text" name="title" class="form-control bg-dark text-white border-secondary" value="<?php echo htmlspecialchars($movie['title']); ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label text-white fw-bold">Genre</label>
            <input type="text" name="genre" class="form-control bg-dark text-white border-secondary" value="<?php echo htmlspecialchars($movie['genre']); ?>" placeholder="e.g. Action, Sci-Fi" required>
          </div>
          <div class="col-md-4">
            <label class="form-label text-white fw-bold">Duration</label>
            <input type="text" name="duration" class="form-control bg-dark text-white border-secondary" value="<?php echo htmlspecialchars($movie['duration']); ?>" placeholder="e.g. 2h 45m" required>
          </div>
          <div class="col-md-4">
            <label class="form-label text-white fw-bold">Format</label>
            <input type="text" name="format" class="form-control bg-dark text-white border-secondary" value="<?php echo htmlspecialchars($movie['format']); ?>" placeholder="e.g. 2h 45m" required>
          </div>
          <div class="col-md-4">
            <label class="form-label text-white fw-bold">Category</label>
            <select name="category" class="form-select bg-dark text-white border-secondary" required>
              <option value="now_showing" <?php echo ($movie['category'] == 'now_showing') ? 'selected' : ''; ?>>Now Showing</option>
              <option value="upcoming" <?php echo ($movie['category'] == 'upcoming') ? 'selected' : ''; ?>>Upcoming</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label text-white fw-bold">Release Date</label>
            <input type="date" name="release_date" class="form-control bg-dark text-white border-secondary" value="<?php echo $movie['release_date']; ?>" required>
          </div>
          <div class="col-md-12">
            <label class="form-label text-white fw-bold">Trailer URL (YouTube Link)</label>
            <input type="url" name="trailer_url" class="form-control bg-dark text-white border-secondary" value="<?php echo htmlspecialchars($movie['trailer_url']); ?>" placeholder="https://www.youtube.com/watch?v=..." required>
          </div>
          <div class="col-md-12">
            <label class="form-label text-white fw-bold">Movie Poster</label>
            <div class="d-flex align-items-center gap-3">
              <img src="../<?php echo $movie['poster']; ?>" alt="Current Poster" class="rounded border border-secondary" style="width: 70px; height: 95px; object-fit: cover;">
              <div class="flex-grow-1">
                <input type="file" name="poster" class="form-control bg-dark text-white border-secondary" accept="image/*">
                <small class="text-muted">Leave empty if you don't want to change the poster image.</small>
              </div>
            </div>
          </div>
          <div class="col-12 mt-4 text-end">
            <button type="submit" name="update_movie" class="btn btn-warning px-4 fw-bold">
              <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include_once "includes/footer.php"; ?>