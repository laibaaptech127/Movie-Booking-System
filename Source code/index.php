<?php
include_once "includes/header.php";
include_once "includes/db.php";
?>
  <!-- Carousel Indicators Warning Color Overwrite Style -->
  <style>
    .hero-carousel-indicators button.active {
      background-color: #ffc107 !important; /* Bootstrap Warning Color */
    }
  </style>

  <div class="page-content-wrapper p-0">
    <!-- Hero Trailer Carousel -->
    <section class="hero-section pt-4 pb-4">
      <div class="container">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6500">
          <div class="carousel-indicators hero-carousel-indicators mb-4">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active bg-warning"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" class="bg-warning"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" class="bg-warning"></button>
          </div>
          <div class="carousel-inner rounded-4 shadow-elevated">
            
            <!-- Hero Slide 1: Dune -->
            <div class="carousel-item active">
             <div class="hero-banner-card" style="background-image: url('assets/images/Hero.jpg')">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                  <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge-pill-custom badge-brand"><i class="fa-solid fa-fire"></i> Trending #1 Worldwide</span>
                    <span class="badge-pill-custom badge-gold"><i class="fa-solid fa-star"></i> 4.9 Rating (1.4K Reviews)</span>
                    <span class="badge-pill-custom badge-cyan"><i class="fa-solid fa-film"></i> IMAX Laser 3D</span>
                  </div>
                  <h1 class="display-4 fw-black text-white mb-3" style="text-shadow: 0 4px 20px rgba(0,0,0,0.8);">DUNE: PART TWO</h1>
                  <p class="text-white fs-6 mb-4 d-none d-md-block" style="max-width: 620px; line-height: 1.7; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                    Paul Atreides unites with Chani and the Fremen to wage war against the Harkonnens in Denis Villeneuve's cinematic magnum opus.
                  </p>
                  <div class="d-flex flex-wrap gap-3">
                    <a href="book.php?movie=mov-1" class="btn btn-warning fw-bold py-2 btn-lg">
                      <i class="fa-solid fa-ticket me-2"></i> Book Tickets Now
                    </a>
                    <button class="btn btn-cinema-outline btn-lg">
                      <a href="movie.php"><i class="fa-solid pt-1 fa-circle-play text-gold me-2"></i> Explore Movies</a>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Hero Slide 2: Cyberpunk -->
            <div class="carousel-item">
              <div class="hero-banner-card" style="background-image:url('assets/images/Hero sec2.jpg')">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                  <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge-pill-custom badge-cyan"><i class="fa-solid fa-bolt"></i> Cyber Action Thriller</span>
                    <span class="badge-pill-custom badge-gold"><i class="fa-solid fa-star"></i> 4.7 Rating</span>
                    <span class="badge-pill-custom badge-platinum"><i class="fa-solid fa-vr-cardboard"></i> 4DX Dynamic Motion</span>
                  </div>
                  <h1 class="display-4 fw-black text-white mb-3" style="text-shadow: 0 4px 20px rgba(0,0,0,0.8);">CYBERPUNK: NEON CITY</h1>
                  <p class="text-white fs-6 mb-4 d-none d-md-block" style="max-width: 620px; line-height: 1.7; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                    In a neon-drenched 2099 metropolis, an undercover cyber-operative uncovers a rogue AI conspiracy controlling human memories.
                  </p>
                  <div class="d-flex flex-wrap gap-3">
                    <a href="book.php?movie=mov-2" class="btn btn-warning fw-bold py-2 btn-lg">
                      <i class="fa-solid fa-ticket me-2"></i> Book Tickets Now
                    </a>
                    <button class="btn btn-cinema-outline btn-lg">
                      <a href="movie.php"><i class="fa-solid pt-1 fa-circle-play text-gold me-2"></i> Explore Movies</a>                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Hero Slide 3: Interstellar -->
            <div class="carousel-item">
               <div class="hero-banner-card" style="background-image:url('assets/images/poopcorn.avif')">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                  <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge-pill-custom badge-gold"><i class="fa-solid fa-award"></i> Nolan 10th Anniversary</span>
                    <span class="badge-pill-custom badge-brand"><i class="fa-solid fa-star"></i> 4.8 Rating</span>
                    <span class="badge-pill-custom badge-box"><i class="fa-solid fa-video"></i> IMAX 70mm Special</span>
                  </div>
                  <h1 class="display-4 fw-black text-white mb-3" style="text-shadow: 0 4px 20px rgba(0,0,0,0.8);">INTERSTELLAR ODYSSEY</h1>
                  <p class="text-white fs-6 mb-4 d-none d-md-block" style="max-width: 620px; line-height: 1.7; text-shadow: 0 2px 10px rgba(0,0,0,0.8);">
                    A daring crew of explorers travels through a newly discovered wormhole in space to secure mankind's survival among distant galaxies.
                  </p>
                  <div class="d-flex flex-wrap gap-3">
                    <a href="book.php?movie=mov-3" class="btn btn-warning fw-bold py-2 btn-lg">
                      <i class="fa-solid fa-ticket me-2"></i> Book Tickets Now
                    </a>
                    <button class="btn btn-cinema-outline btn-lg">
                      <a href="movie.php"><i class="fa-solid pt-1 fa-circle-play text-gold me-2"></i> Explore Movies</a>                    </button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- Quick Movie Filter Bar & Now Showing Showcase -->
    <section class="py-5">
      <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4 pb-3 border-bottom border-glass">
          <div>
            <div class="text-warning fw-bold fs-5 mt-2 pr-2">Live In Auditoriums</div>
            <h2 class="display-6 fw-bold text-white mb-0">Featured Now Showing</h2>
          </div>
          <div class="d-flex align-items-center gap-2 mb-2">
            <a href="movie.php" class="btn btn-cinema-outline btn-sm">Browse All Movies <i class="fa-solid fa-arrow-right ms-1"></i></a>
          </div>
        </div>

        <div class="row" id="homeMoviesGrid"></div>
      </div>
    </section>

    <!-- Transparent Luxury Seat Pricing Tiers Showcase -->
   <div class="page-content-wrapper text-white bg-dark min-vh-100">
  <div class="page-banner text-center py-5 bg-secondary bg-opacity-10 border-bottom border-secondary border-opacity-25">
    <div class="container">
      <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">Transparent Pricing System</span>
      <h1 class="display-5 fw-bold text-white mb-2">Cinema Ticket Rates & Tiers</h1>
      <p class="text-light opacity-75 mb-0">Experience transparent rates, premium amenities, and family concessions.</p>
    </div>
  </div>

      <div class="container py-5">
    <!-- 3 Tier Cards -->
    <div class="row g-4 mb-5">
      <!-- Gold Class -->
      <div class="col-lg-4">
        <div class="pricing-tier-card">
          <div>
            <div class="pricing-icon-wrap bg-warning text-dark"><i class="fa-solid fa-medal"></i></div>
            <h4 class="text-white fw-bold">Gold Class</h4>
            <p class="text-light opacity-75 small">Standard luxury plush seating with crystal clear stereo surround audio.</p>
            <div class="pricing-price-tag text-warning">
              <span class="currency">$</span>12<span class="period">/ ticket</span>
            </div>
            <ul class="pricing-feature-list">
              <li><i class="fa-solid fa-circle-check text-warning"></i> High-resilience cushioned seats</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> Front & Middle auditorium rows (F-J)</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> 20% Kids Special Concession valid</li>
              <li class="text-muted"><i class="fa-solid fa-circle-xmark opacity-50"></i> Motorized recliners</li>
            </ul>
          </div>
          <a href="book.php" class="btn btn-outline-warning w-100 py-3 fw-bold rounded-3">Book Gold Class</a>
        </div>
      </div>

      <!-- Platinum Class -->
      <div class="col-lg-4">
        <div class="pricing-tier-card featured-tier">
          <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill fw-bold">Most Popular</span>
          <div>
            <div class="pricing-icon-wrap bg-warning text-dark"><i class="fa-solid fa-gem"></i></div>
            <h4 class="text-white fw-bold">Platinum VIP</h4>
            <p class="text-light opacity-75 small">Prime center auditorium sweet spot with semi-recliners & Dolby Atmos.</p>
            <div class="pricing-price-tag text-warning">
              <span class="currency">$</span>18<span class="period">/ ticket</span>
            </div>
            <ul class="pricing-feature-list">
              <li><i class="fa-solid fa-circle-check text-warning"></i> Center rows (C-E) sweet-spot alignment</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> Ergonomic semi-reclining leather seats</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> 20% Kids Special Concession valid</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> Priority express snack counter line</li>
            </ul>
          </div>
          <a href="book.php" class="btn btn-warning w-100 py-3 fw-bold text-dark rounded-3">Book Platinum VIP</a>
        </div>
      </div>

      <!-- VIP Box Class -->
      <div class="col-lg-4">
        <div class="pricing-tier-card">
          <div>
            <div class="pricing-icon-wrap bg-warning text-dark"><i class="fa-solid fa-crown"></i></div>
            <h4 class="text-white fw-bold">VIP Luxury Box</h4>
            <p class="text-light opacity-75 small">Motorized sofa recliners, blanket service, and in-seat gourmet dining.</p>
            <div class="pricing-price-tag text-warning">
              <span class="currency">$</span>25<span class="period">/ ticket</span>
            </div>
            <ul class="pricing-feature-list">
              <li><i class="fa-solid fa-circle-check text-warning"></i> Full motorized leather sofa recliners (A-B)</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> In-seat butler & gourmet dining service</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> Exclusive VIP Lounge access with free coffee</li>
              <li><i class="fa-solid fa-circle-check text-warning"></i> USB fast-charging ports on armrest</li>
            </ul>
          </div>
          <a href="book.php" class="btn btn-warning w-100 py-3 fw-bold text-dark rounded-3">Book VIP Box</a>
        </div>
      </div>
    </div>

  </div>
      </div>
    </section>
  </div>

  <!-- Trailer Video Modal -->
  <div class="modal fade" id="trailerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content modal-content-cinema">
        <div class="modal-header modal-header-cinema">
          <h5 class="modal-title text-white fw-bold" id="trailerModalLabel"><i class="fa-brands fa-youtube text-brand me-2"></i> Official Trailer</h5>
          <button type="button" class="btn-close btn-close-cinema" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-0">
          <div class="ratio ratio-16x9">
            <iframe id="trailerIframe" src="" title="Trailer" allow="autoplay" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include_once "includes/footer.php";?>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const grid = document.getElementById('homeMoviesGrid');
      if (grid && app) {
        grid.innerHTML = app.data.movies.slice(0, 3).map(m => `
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="movie-card">
              <div class="movie-poster-wrap">
                <img src="${m.poster}" alt="${m.title}" class="movie-poster-img">
                <div class="movie-poster-overlay">
                  <span class="badge-pill-custom badge-brand">${m.badge || ''}</span>
                  <span class="badge-pill-custom badge-cyan">${m.format || ''}</span>
                </div>
                <div class="movie-hover-actions">
                  <button class="play-circle-btn" onclick="app.openTrailerModal('${m.id}')" title="Watch Trailer"><i class="fa-solid fa-play"></i></button>
                  <span class="text-white fw-bold small">Watch 4K Trailer</span>
                  <a href="movie-details.html?id=${m.id}" class="btn btn-cinema-outline btn-sm mt-2"><i class="fa-solid fa-circle-info me-1"></i> View Synopsis</a>
                </div>
              </div>
              <div class="movie-card-body">
                <div>
                  <h5 class="movie-title text-white">${m.title}</h5>
                  <div class="movie-meta-info">
                    <span><i class="fa-solid fa-tags me-1 text-brand"></i>${m.genre}</span>
                    <span><i class="fa-regular fa-clock me-1 text-cyan"></i>${m.duration}</span>
                  </div>
                </div>
                <div class="d-flex align-items-center justify-content-between pt-3 border-top border-glass">
                  <div class="rating-badge"><i class="fa-solid fa-star"></i> ${m.rating} <small class="text-muted-custom fw-normal">(${m.reviews})</small></div>
                  <a href="booking.html?movie=${m.id}" class="btn btn-cinema btn-sm"><i class="fa-solid fa-ticket me-1"></i> Book Ticket</a>
                </div>
              </div>
            </div>
          </div>
        `).join('');
      }
    });
  </script>