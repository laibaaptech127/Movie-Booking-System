<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include_once "includes/header.php";
include_once "includes/db.php";

$query = "SELECT * FROM shows";
$result = mysqli_query($connect, $query);
$dates = mysqli_fetch_all($result, MYSQLI_ASSOC);

$movies_query = "SELECT * FROM movies";
$result = mysqli_query($connect, $movies_query);
$movies = mysqli_fetch_all($result, MYSQLI_ASSOC);

$formats = [];

foreach ($movies as $movie) {
    if (!empty($movie['format'])) {
        $formats[] = $movie['format'];
    }
}

$formats = array_unique($formats);
?>

<style>
  .catalog-banner {
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.8) 100%),
                url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=1200') center/cover no-repeat;
    padding: 60px 0 40px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .glass-card {
    background: rgba(30, 41, 59, 0.7) !important;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
  }

  .movie-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 16px;
    overflow: hidden;
  }

  .movie-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(245, 158, 11, 0.25);
  }

  .poster-overlay {
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(15, 23, 42, 0.95) 100%);
  }

  .filter-pill {
    cursor: pointer;
    transition: all 0.2s ease;
    border: 1px solid rgba(255, 255, 255, 0.15);
  }

  .filter-pill.active,
  .filter-pill:hover {
    background-color: #f59e0b !important;
    color: #000 !important;
    font-weight: bold;
    border-color: #f59e0b !important;
  }

  .movie-clickable {
    cursor: pointer;
  }
</style>

<div class="page-content-wrapper text-white bg-dark min-vh-100">

  <!-- Banner -->
  <div class="catalog-banner text-center mb-4">
    <div class="container">
      <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
        Cinema Catalog
      </span>

      <h1 class="display-4 fw-black text-white mb-2">
        Explore All Movies
      </h1>

      <p class="text-light mb-0 fs-5">
        Filter movies by date, showtime, format and search.
      </p>
    </div>
  </div>

  <div class="container pb-5">

    <!-- Filters -->
    <div class="glass-card p-4 rounded-4 mb-4">
      <div class="row g-3">

        <!-- Date -->
        <div class="col-lg-3 col-md-6">
          <label class="form-label text-warning small fw-bold mb-1">
            <i class="fa-regular fa-calendar-days me-1"></i> Select Date
          </label>

          <select class="form-select bg-dark text-white border-secondary rounded-3"
                  id="filterDate"
                  onchange="applyFilters()">

            <option value="all">Any Date</option>

            <?php foreach ($dates as $date) { ?>
              <option value="<?= $date['show_date'] ?>">
                <?= $date['show_date'] ?>
              </option>
            <?php } ?>

          </select>
        </div>

        <!-- Showtime -->
        <div class="col-lg-3 col-md-6">
          <label class="form-label text-warning small fw-bold mb-1">
            <i class="fa-regular fa-clock me-1"></i> Showtime Availability
          </label>

          <select class="form-select bg-dark text-white border-secondary rounded-3"
                  id="filterTimeSlot"
                  onchange="applyFilters()">

            <option value="all">Any Time Slot</option>

            <?php foreach ($dates as $time) { ?>
              <option value="<?= $time['show_time'] ?>">
                <?= $time['show_time'] ?>
              </option>
            <?php } ?>

          </select>
        </div>

        <!-- Format -->
        <div class="col-lg-3 col-md-6">
          <label class="form-label text-warning small fw-bold mb-1">
            <i class="fa-solid fa-film me-1"></i> Cinema Format
          </label>

          <select class="form-select bg-dark text-white border-secondary rounded-3"
                  id="filterFormat"
                  onchange="applyFilters()">

            <option value="all">All Formats</option>

            <?php foreach ($formats as $format) { ?>
              <option value="<?= $format ?>">
                <?= $format ?>
              </option>
            <?php } ?>

          </select>
        </div>

        <!-- Search -->
        <div class="col-lg-3 col-md-6">
          <label class="form-label text-warning small fw-bold mb-1">
            <i class="fa-solid fa-magnifying-glass me-1"></i> Search Movie
          </label>

          <input type="text"
                 id="searchInput"
                 class="form-control bg-dark text-white border-secondary rounded-3"
                 placeholder="Search title or genre..."
                 oninput="applyFilters()">
        </div>

      </div>

      <!-- Categories -->
      <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top border-secondary border-opacity-25"
           id="categoryPills">

        <button class="btn btn-sm filter-pill bg-dark text-white active rounded-pill px-3"
                onclick="setCategory('all', this)">
          All Releases
        </button>

        <button class="btn btn-sm filter-pill bg-dark text-white rounded-pill px-3"
                onclick="setCategory('now_showing', this)">
          Now Showing
        </button>

        <button class="btn btn-sm filter-pill bg-dark text-white rounded-pill px-3"
                onclick="setCategory('upcoming', this)">
          Upcoming Presale
        </button>

      </div>
    </div>

    <!-- Count -->
    <div class="d-flex justify-content-between align-items-center mb-4 px-1">
      <h5 class="fw-bold mb-0 text-light">Available Movies</h5>

      <span class="badge bg-warning text-dark fs-6 rounded-pill">
        Showing <span id="moviesCountBadge"><?= count($movies) ?></span> Movies
      </span>
    </div>

    <!-- Movies -->
    <div class="row g-4" id="moviesGrid">

      <?php foreach ($movies as $movie) {

          $movieDates = [];
          $movieTimes = [];

          foreach ($dates as $show) {
              if (isset($show['movie_id']) && $show['movie_id'] == $movie['id']) {
                  $movieDates[] = $show['show_date'];
                  $movieTimes[] = $show['show_time'];
              }
          }

          $movieDates = array_unique($movieDates);
          $movieTimes = array_unique($movieTimes);

          $detailsUrl = "movie_detail.php?movie_id=" . $movie['id'];
      ?>

      <div class="col-lg-4 col-md-6 movie-item"
           data-category="<?= $movie['category'] ?>"
           data-format="<?= $movie['format'] ?>"
           data-title="<?= htmlspecialchars($movie['title']) ?>"
           data-genre="<?= htmlspecialchars($movie['genre']) ?>"
           data-date="<?= implode(',', $movieDates) ?>"
           data-slot="<?= implode(',', $movieTimes) ?>">

        <div class="card movie-card glass-card h-100 text-white movie-clickable"
             onclick="openMovieDetail('<?= $movie['id'] ?>')">

          <!-- Poster -->
          <div class="position-relative">

            <img src="<?= $movie['poster'] ?>"
                 class="card-img-top object-fit-cover"
                 style="height: 360px;"
                 alt="<?= htmlspecialchars($movie['title']) ?>">

            <div class="position-absolute top-0 start-0 end-0 bottom-0 poster-overlay"></div>

            <!-- Category -->
            <span class="position-absolute top-0 start-0 m-3 badge bg-danger text-uppercase fw-bold shadow">
              <?= str_replace('_', ' ', $movie['category']) ?>
            </span>

            <!-- Rating -->
            <span class="position-absolute top-0 end-0 m-3 badge bg-warning text-white fw-bold shadow">
              <i class="fa-solid fa-star me-1"></i>
              <?= !empty($movie['rating']) ? $movie['rating'] : 'N/A' ?>
            </span>

            <!-- Format -->
            <span class="position-absolute bottom-0 start-0 m-3 badge bg-info text-white fw-bold text-uppercase">
              <?= !empty($movie['format']) ? $movie['format'] : 'N/A' ?>
            </span>

          </div>

          <!-- Body -->
          <div class="card-body d-flex flex-column justify-content-between p-4">

            <div>

              <div class="d-flex justify-content-between align-items-center mb-1">

                <small class="text-warning fw-bold text-uppercase">
                  <?= $movie['genre'] ?>
                </small>

                <small class="text-white">
                  <i class="fa-regular fa-clock me-1"></i>
                  <?= $movie['duration'] ?>
                </small>

              </div>

              <h4 class="fw-bold text-white mb-3">
                <?= $movie['title'] ?>
              </h4>

              <div class="mb-3">

                <small class="text-white d-block mb-1 fw-bold">
                  Available Showtimes:
                </small>

                <div class="d-flex flex-wrap">

                  <?php foreach ($movieTimes as $time) { ?>
                    <span class="badge bg-dark border border-secondary text-light me-1 mb-1">
                      <?= $time ?>
                    </span>
                  <?php } ?>

                  <?php if (empty($movieTimes)) { ?>
                    <span class="text-muted small">
                      No showtime available
                    </span>
                  <?php } ?>

                </div>

              </div>

            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2 pt-3 border-top border-secondary border-opacity-25 mt-2">
<button type="button"
        class="btn btn-outline-light w-50 fw-bold rounded-3"
        onclick="event.stopPropagation(); openTrailer('<?= htmlspecialchars($movie['trailer_url'], ENT_QUOTES) ?>')">
  <i class="fa-solid fa-play me-1 text-warning"></i>
  Trailer
</button>

              <a href="<?= $detailsUrl ?>"
                 onclick="event.stopPropagation();"
                 class="btn btn-warning w-50 text-center fw-bold text-dark rounded-3">
                <i class="fa-solid fa-circle-info me-1"></i>
                Details
              </a>

            </div>

          </div>
        </div>
      </div>

      <?php } ?>

      <?php if (empty($movies)) { ?>
        <div class="col-12">
          <div class="glass-card rounded-4 p-5 text-center">
            <i class="fa-solid fa-film display-4 text-warning mb-3"></i>
            <h4 class="fw-bold text-white">No Movies Found</h4>
            <p class="text-white-50 mb-0">No movie record exists in the database.</p>
          </div>
        </div>
      <?php } ?>

    </div>
  </div>
</div>

<!-- Trailer Modal -->
<div class="modal fade" id="trailerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">

    <div class="modal-content bg-dark border border-secondary text-white rounded-4 overflow-hidden">

      <div class="modal-header border-bottom border-secondary">
        <h5 class="modal-title fw-bold text-warning">
          <i class="fa-brands fa-youtube me-2"></i>
          Official Trailer
        </h5>

        <button type="button"
                class="btn-close btn-close-white"
                data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-0">
        <div class="ratio ratio-16x9">
          <iframe id="trailerIframe"
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
  let currentCategory = 'all';

  function openMovieDetail(movieId) {
    window.location.href = 'movie_detail.php?movie_id=' + movieId;
  }

  function setCategory(cat, btn) {

    currentCategory = cat;

    document.querySelectorAll('#categoryPills .filter-pill').forEach(function(b) {
      b.classList.remove('active');
    });

    btn.classList.add('active');

    applyFilters();
  }

  function applyFilters() {

    const selectedDate = document.getElementById('filterDate').value;
    const selectedSlot = document.getElementById('filterTimeSlot').value;
    const selectedFormat = document.getElementById('filterFormat').value.toLowerCase();
    const searchQuery = document.getElementById('searchInput').value.toLowerCase().trim();

    const movies = document.querySelectorAll('.movie-item');
    let visibleCount = 0;

    movies.forEach(function(movie) {

      const category = movie.dataset.category;
      const format = movie.dataset.format.toLowerCase();
      const title = movie.dataset.title.toLowerCase();
      const genre = movie.dataset.genre.toLowerCase();

      const movieDates = movie.dataset.date ? movie.dataset.date.split(',') : [];
      const movieSlots = movie.dataset.slot ? movie.dataset.slot.split(',') : [];

      let showMovie = true;

      if (currentCategory !== 'all' && category !== currentCategory) {
        showMovie = false;
      }

      if (selectedFormat !== 'all' && format !== selectedFormat) {
        showMovie = false;
      }

      if (searchQuery && !title.includes(searchQuery) && !genre.includes(searchQuery)) {
        showMovie = false;
      }

      if (selectedDate !== 'all' && !movieDates.includes(selectedDate)) {
        showMovie = false;
      }

      if (selectedSlot !== 'all' && !movieSlots.includes(selectedSlot)) {
        showMovie = false;
      }

      movie.style.display = showMovie ? '' : 'none';

      if (showMovie) {
        visibleCount++;
      }
    });

    document.getElementById('moviesCountBadge').innerText = visibleCount;
  }

function openTrailer(url) {
    if (!url) {
      alert('Trailer URL not available');
      return;
    }

    let embedUrl = url;

    // Standard YouTube link format: youtube.com/watch?v=VIDEO_ID
    if (url.includes('watch?v=')) {
      let videoId = url.split('v=')[1];
      const ampersandPosition = videoId.indexOf('&');
      if (ampersandPosition !== -1) {
        videoId = videoId.substring(0, ampersandPosition);
      }
      embedUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
    } 
    // Shortened YouTube link format: youtu.be/VIDEO_ID
    else if (url.includes('youtu.be/')) {
      let videoId = url.split('youtu.be/')[1];
      const questionMarkPosition = videoId.indexOf('?');
      if (questionMarkPosition !== -1) {
        videoId = videoId.substring(0, questionMarkPosition);
      }
      embedUrl = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
    } 
    // Agar pehle se embed URL hai
    else if (url.includes('youtube.com/embed/') && !url.includes('autoplay=1')) {
      embedUrl += (url.includes('?') ? '&' : '?') + 'autoplay=1';
    }

    document.getElementById('trailerIframe').src = embedUrl;

    const modal = new bootstrap.Modal(
      document.getElementById('trailerModal')
    );

    modal.show();
  }

  document.getElementById('trailerModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('trailerIframe').src = '';
  });

  document.addEventListener('DOMContentLoaded', function() {
    applyFilters();
  });
</script>
