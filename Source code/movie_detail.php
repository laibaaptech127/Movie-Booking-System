<?php
include_once "includes/header.php";
include_once "includes/db.php";

$movie_id = $_GET['movie_id'];
$query = "SELECT * FROM movies WHERE id = $movie_id";
$result = mysqli_query($connect, $query);
$movie = mysqli_fetch_assoc($result);

if (!$movie) {
    echo '<div class="container py-5 text-white">
            <div class="alert alert-danger">Movie not found.</div>
          </div>';

    include_once "includes/footer.php";
    exit();
}
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $rate = $_POST['rate'];
    $review = $_POST['review'];

    $query = "INSERT INTO reviews (name, rate, review, movie_id) VALUES ('$name', '$rate', '$review', '$movie_id')";
    $result = mysqli_query($connect, $query);
}
$review_query = "SELECT * FROM reviews WHERE movie_id = $movie_id ORDER BY review_id DESC LIMIT 4";
$review_result = mysqli_query($connect, $review_query);
$reviews = mysqli_fetch_all($review_result, MYSQLI_ASSOC);

$show_query = "SELECT * FROM shows WHERE movie_id = $movie_id ORDER BY show_date, show_time";
$show_result = mysqli_query($connect, $show_query);
$movie_shows = mysqli_fetch_all($show_result, MYSQLI_ASSOC);

$trailer_url = $movie['trailer_url'];

if (strpos($trailer_url, 'youtu.be/') !== false) {

    $parts = explode('youtu.be/', $trailer_url);
    $video_id = explode('?', $parts[1])[0];

    $trailer_url = "https://www.youtube.com/embed/" . $video_id;

} elseif (strpos($trailer_url, 'watch?v=') !== false) {

    $parts = explode('watch?v=', $trailer_url);
    $video_id = explode('&', $parts[1])[0];

    $trailer_url = "https://www.youtube.com/embed/" . $video_id;
}
// $trailer_url = $movie['trailer_url'];
// if (strpos($trailer_url, 'youtu.be/') !== false) {
//     $parts = explode('youtu.be/', $trailer_url);
//     $video_id = explode('?', $parts[1])[0];
//     $trailer_url = 'https://www.youtube.com/embed/' . $video_id;
// }
?>
<style>
  .detail-banner {
    background: linear-gradient(90deg, rgba(15, 23, 42, 0.98) 0%, rgba(15, 23, 42, 0.75) 100%),
                url('<?= $movie['poster'] ?>') center/cover no-repeat;
    padding: 70px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .glass-card {
    background: rgba(30, 41, 59, 0.7) !important;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
  }

  .detail-poster {
    width: 100%;
    max-height: 520px;
    object-fit: cover;
    border-radius: 16px;
  }

  .show-time-btn {
    display: inline-block;
    margin: 4px;
  }
</style>

<div class="page-content-wrapper text-white bg-dark min-vh-100">

  <!-- Banner -->
  <div class="detail-banner">
    <div class="container">

      <a href="movie.php" class="btn btn-outline-light btn-sm mb-4">
        <i class="fa-solid fa-arrow-left me-2"></i>
        Back to Movies
      </a>

      <div class="row g-5 align-items-center">

        <!-- Poster -->
        <div class="col-lg-4 text-center">
          <img src="<?= $movie['poster'] ?>"
               class="detail-poster shadow"
               alt="<?= htmlspecialchars($movie['title']) ?>">
        </div>

        <!-- Details -->
        <div class="col-lg-8">

          <div class="d-flex flex-wrap gap-2 mb-3">

            <span class="badge bg-danger text-uppercase">
              <?= str_replace('_', ' ', $movie['category']) ?>
            </span>

            <span class="badge bg-warning text-dark text-uppercase">
              <?= $movie['format'] ?>
            </span>

          </div>

          <h1 class="display-4 fw-bold text-white mb-3">
            <?= $movie['title'] ?>
          </h1>

          <p class="text-warning fw-bold fs-5 mb-3">
            <?= $movie['genre'] ?> • <?= $movie['duration'] ?>
          </p>

          <p class="text-white-50 mb-4">
            <?= $movie['description'] ?>
          </p>

          <div class="row g-3 mb-4">

            <div class="col-sm-4">
              <strong class="d-block text-white">Release Date</strong>
              <span class="text-white-50">
                <?= $movie['release_date'] ?>
              </span>
            </div>

            <div class="col-sm-4">
              <strong class="d-block text-white">Format</strong>
              <span class="text-white-50">
                <?= $movie['format'] ?>
              </span>
            </div>

            <div class="col-sm-4">
              <strong class="d-block text-white">Rating</strong>
              <span class="text-warning">
                <i class="fa-solid fa-star me-1"></i>
                <?= !empty($movie['rating']) ? $movie['rating'] : 'N/A' ?>
              </span>
            </div>

          </div>

          <div class="d-flex flex-wrap gap-3">

            <a href="book.php?movie_id=<?= $movie['id'] ?>"
               class="btn btn-warning px-4 py-3 fw-bold">
              <i class="fa-solid fa-ticket me-2"></i>
              Book Tickets Now
            </a>

            <button type="button"
                    class="btn btn-outline-light px-4 py-3"
                    onclick="openTrailer()">
              <i class="fa-solid fa-play me-2"></i>
              Watch Trailer
            </button>

          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="container py-5">

    <!-- Showtimes -->
    <div class="glass-card p-4 rounded-4 mb-4">

      <h3 class="fw-bold text-warning mb-4">
        <i class="fa-regular fa-calendar-days me-2"></i>
        Available Showtimes
      </h3>

      <?php if (!empty($movie_shows)) { ?>

        <div class="row g-3">

          <?php foreach ($movie_shows as $show) { ?>

            <div class="col-md-6 col-lg-4">

              <div class="border border-secondary border-opacity-25 rounded-3 p-3">

                <div class="mb-2">
                  <small class="text-white d-block">Show Date</small>
                  <span class="fw-bold text-white">
                    <?= $show['show_date'] ?>
                  </span>
                </div>

                <div>
                  <small class="text-white d-block">Showtime</small>
                  <span class="badge bg-warning text-dark">
                    <?= $show['show_time'] ?>
                  </span>
                </div>

              </div>

            </div>

          <?php } ?>

        </div>

      <?php } else { ?>

        <p class="text-white-50 mb-0">
          No showtimes available for this movie.
        </p>

      <?php } ?>

    </div>

    <!-- Reviews -->
    <div class="glass-card p-4 rounded-4">

      <h3 class="fw-bold text-white mb-4">
        <i class="fa-solid fa-comments text-warning me-2"></i>
        Audience Reviews
      </h3>

      <form method="POST" class="mb-4">

        <div class="row g-3">

          <div class="col-md-6">
            <label class="form-label text-white-50 small">
              Your Name
            </label>

            <input type="text"
                   name="name"
                   class="form-control bg-dark text-white border-secondary"
                   placeholder="Enter your name"
                   required>
          </div>

          <div class="col-md-6">
            <label class="form-label text-white-50 small">
              Rating
            </label>

            <select name="rate"
                    class="form-select bg-dark text-white border-secondary"
                    required>
              <option value="5">5 / 5 ⭐⭐⭐⭐⭐</option>
              <option value="4">4 / 5⭐⭐⭐⭐</option>
              <option value="3">3 / 5 ⭐⭐⭐</option>
              <option value="2">2 / 5>⭐⭐</option>
              <option value="1">1 / 5 ⭐</option>
            </select>
          </div>

          <div class="col-12">
            <label class="form-label text-white-50 small">
              Your Review
            </label>

            <textarea name="review"
                      class="form-control bg-dark text-white border-secondary"
                      rows="3"
                      placeholder="Write your thoughts..."
                      required></textarea>
          </div>

          <div class="col-12 text-end">
            <button type="submit"
                    name="submit"
                    class="btn btn-warning fw-bold px-4">
              Submit Review
            </button>
          </div>

        </div>

      </form>

    </div>

  </div>
</div>
<!-- Static Review List --> 
 <div class="d-flex flex-column gap-3"> 
  <?php foreach($reviews as $review){?>
  <div class="p-3 rounded border border-secondary border-opacity-25 bg-secondary bg-opacity-10"> 
    <div class="d-flex justify-content-between align-items-center mb-2"> 
      <div class="d-flex align-items-center gap-2">
        <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">A</div> 
        <h6 class="mb-0 text-white fw-bold"><?= $review['name']?></h6>
       </div> <small class="text-white-50"><?= $review['rate']?></small>
       </div>
        <p class="text-white-50 mb-0 small"><?= $review['review']?></p>
       </div>
       <?php }?>
</div>
<!-- Trailer Modal -->
<div class="modal fade" id="detailTrailerModal" tabindex="-1" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-xl">

    <div class="modal-content bg-dark text-white border border-secondary">

      <div class="modal-header border-bottom border-secondary">

        <h5 class="modal-title text-warning fw-bold">
          <i class="fa-brands fa-youtube me-2"></i>
          Official Trailer
        </h5>

        <button type="button"
                class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>

      </div>

      <div class="modal-body p-0">

        <div class="ratio ratio-16x9">

          <iframe id="detailIframe"
                  src=""
                  title="Trailer"
                  allow="autoplay"
                  allowfullscreen></iframe>

        </div>

      </div>

    </div>

  </div>

</div>

<?php include_once "includes/footer.php"; ?>

<script>
  const trailerUrl = <?= json_encode($trailer_url) ?>;

  function openTrailer() {

    document.getElementById('detailIframe').src = trailerUrl;

    const modal = new bootstrap.Modal(
      document.getElementById('detailTrailerModal')
    );

    modal.show();
  }

  document.getElementById('detailTrailerModal').addEventListener(
    'hidden.bs.modal',
    function () {
      document.getElementById('detailIframe').src = '';
    }
  );
</script>
