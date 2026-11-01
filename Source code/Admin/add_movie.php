<?php
session_start();
include_once "../includes/db.php";
$error_msg = "";
if (isset($_POST['add_movie'])) {
    $title        = $_POST['title'];
    $genre        = $_POST['genre'];
    $duration     = $_POST['duration'];
    $format       = $_POST['format'];
    $release_date = $_POST['release_date'];
    $category     = $_POST['category'];
    $trailer_url  = $_POST['trailer_url'];
    $description  = $_POST['description'];

    $image_name = $_FILES['poster']['name'];
    $image_tmp  = $_FILES['poster']['tmp_name'];

    $image_ext = strtolower(
        pathinfo($image_name, PATHINFO_EXTENSION)
    );
    $allowed_ext = array('jpg', 'jpeg', 'png', 'webp');
    if (in_array($image_ext, $allowed_ext)) {
        $new_image_name = time() . "_" . uniqid() . "." . $image_ext;
        $upload_folder = "../uploads/";
        if (!is_dir($upload_folder)) {
            mkdir($upload_folder, 0777, true);
        }
        $upload_path = $upload_folder . $new_image_name;
        if (move_uploaded_file($image_tmp, $upload_path)) {
            $db_image_path = "uploads/" . $new_image_name;
            $query = "INSERT INTO movies(title,description,genre,duration,format,release_date,poster,trailer_url,category)
            VALUES(
                '$title',
                '$description',
                '$genre',
                '$duration',
                '$format',
                '$release_date',
                '$db_image_path',
                '$trailer_url',
                '$category'
            )";
            if (mysqli_query($connect, $query)) {
                echo "<script>
                        alert('Movie Added Successfully!');
                        window.location.href='movie.php';
                      </script>";
                exit();
            } else {
                $error_msg = "Database Error: " . mysqli_error($connect);
            }
        } else {
            $error_msg = "Failed to upload image file.";
        }
    } else {
        $error_msg = "Invalid image format. Only JPG, JPEG, PNG, WEBP allowed.";
    }
}
include_once "includes/header.php";
?>
<div class="admin-main-content py-4">
  <div class="container" style="max-width: 900px;">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="text-white fw-bold mb-1">
          <i class="fa-solid fa-film text-brand me-2"></i>
          Add New Movie
        </h3>
        <p class="text-white small mb-0">
          Publish new cinema releases, duration, and trailer media.
        </p>
      </div>
      <a href="movie.php" class="btn btn-cinema-outline btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i>
        Back to Movies
      </a>
    </div>

    <!-- Error Message -->
    <?php if (!empty($error_msg)) { ?>
      <div class="alert alert-danger py-2 small text-center mb-4">
        <?= $error_msg ?>
      </div>
    <?php } ?>
    <!-- Form Card -->
    <div class="glassmorphism p-4 p-md-5 rounded-4 shadow-elevated">
      <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
          <!-- Title -->
          <div class="col-md-8">
            <label class="form-label text-white small fw-bold">
              Movie Title:
            </label>
            <input
              type="text"
              name="title"
              class="form-control form-control-cinema"
              placeholder="e.g. Dune: Part Two"
              required
            >
          </div>
          <!-- Category -->
          <div class="col-md-4">
            <label class="form-label text-white small fw-bold">
              Category:
            </label>
            <select
              name="category"
              class="form-select filter-select-custom"
              required
            >
              <option value="now_showing">
                Now Showing
              </option>
              <option value="upcoming">
                Upcoming
              </option>
            </select>
          </div>
          <!-- Genre -->
          <div class="col-md-4">
            <label class="form-label text-white small fw-bold">
              Genre:
            </label>
            <input
              type="text"
              name="genre"
              class="form-control form-control-cinema"
              placeholder="e.g. Sci-Fi / Action"
              required
            >
          </div>
          <!-- Duration -->
          <div class="col-md-4">
            <label class="form-label text-white small fw-bold">
              Duration:
            </label>
            <input
              type="text"
              name="duration"
              class="form-control form-control-cinema"
              placeholder="e.g. 2h 45m"
              required
            >
          </div>
          <!--Format -->
          <div class="col-md-4">

            <label class="form-label text-white small fw-bold">
              Format:
            </label>

            <input
              type="text"
              name="format"
              class="form-control form-control-cinema"
              placeholder="e.g. IMAX, VIP, Standard / 2D"
              required
            >

          </div>


          <!-- Release Date -->
          <div class="col-md-4">

            <label class="form-label text-white small fw-bold">
              Release Date:
            </label>

            <input
              type="date"
              name="release_date"
              class="form-control form-control-cinema"
              required
            >

          </div>


          <!-- Poster -->
          <div class="col-md-6">

            <label class="form-label text-white small fw-bold">
              Poster Image File:
            </label>

            <input
              type="file"
              name="poster"
              class="form-control form-control-cinema"
              accept=".jpg,.jpeg,.png,.webp,image/*"
              required
            >

          </div>


          <!-- Trailer -->
          <div class="col-md-6">

            <label class="form-label text-white small fw-bold">
              YouTube Embed URL:
            </label>

            <input
              type="url"
              name="trailer_url"
              class="form-control form-control-cinema"
              placeholder="https://www.youtube.com/embed/VIDEO_ID"
              required
            >

          </div>


          <!-- Description -->
          <div class="col-12">

            <label class="form-label text-white small fw-bold">
              Synopsis / Story Description:
            </label>

            <textarea
              name="description"
              rows="4"
              class="form-control form-control-cinema"
              placeholder="Enter movie storyline details..."
              required
            ></textarea>

          </div>


          <!-- Submit -->
          <div class="col-12 mt-4">

            <button
              type="submit"
              name="add_movie"
              class="btn btn-cinema w-100 py-3 fw-bold fs-6"
            >

              <i class="fa-solid fa-plus-circle me-2"></i>
              Save & Add Movie

            </button>

          </div>

        </div>

      </form>

    </div>

  </div>

</div>

<?php include_once "includes/footer.php"; ?>