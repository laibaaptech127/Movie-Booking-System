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
?>
<style>
  .page-banner {
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.85) 100%), 
                url('https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=1200') center/cover no-repeat;
    padding: 60px 0 40px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .glassmorphism {
    background: rgba(30, 41, 59, 0.7) !important;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .glassmorphism:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(245, 158, 11, 0.2);
  }

  .theater-card {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s ease;
  }

  .theater-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(245, 158, 11, 0.25);
  }

  .theater-img {
    height: 240px;
    width: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .theater-card:hover .theater-img {
    transform: scale(1.05);
  }

  .amenity-chip {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 0.82rem;
    color: #e2e8f0;
  }

  .text-brand { color: #f59e0b; }
  .text-gold { color: #fbbf24; }
  .text-cyan { color: #06b6d4; }
  .text-purple { color: #a855f7; }
</style>

<div class="page-content-wrapper text-white bg-dark min-vh-100">
  <!-- Banner Header -->
  <div class="page-banner text-center mb-5">
    <div class="container">
      <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">
        World-Class Cinema Venues
      </span>
      <h1 class="display-5 fw-black text-white mb-2">Our Multiplex Theaters</h1>
      <p class="text-light opacity-75 mb-0 fs-5 max-w-2xl mx-auto">
        Experience state-of-the-art 4K RGB Laser projection, Dolby Atmos 128-channel spatial sound, and VIP recliner lounges.
      </p>
    </div>
  </div>

  <div class="container pb-5">
    <!-- Technology Highlights Banner -->
    <div class="row g-4 mb-5">
      <div class="col-md-3 col-6">
        <div class="glassmorphism p-3 rounded-4 text-center">
          <div class="text-brand fs-3 mb-1"><i class="fa-solid fa-film"></i></div>
          <div class="text-white fw-bold">IMAX Laser 3D</div>
          <div class="text-white small">Next-Gen Sharpness</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="glassmorphism p-3 rounded-4 text-center">
          <div class="text-gold fs-3 mb-1"><i class="fa-solid fa-volume-high"></i></div>
          <div class="text-white fw-bold">Dolby Atmos</div>
          <div class="text-white small">360° Spatial Audio</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="glassmorphism p-3 rounded-4 text-center">
          <div class="text-cyan fs-3 mb-1"><i class="fa-solid fa-vr-cardboard"></i></div>
          <div class="text-white fw-bold">4DX Dynamic</div>
          <div class="text-white small">Motion & Environmental</div>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="glassmorphism p-3 rounded-4 text-center">
          <div class="text-purple fs-3 mb-1"><i class="fa-solid fa-couch"></i></div>
          <div class="text-white fw-bold">VIP Butler Service</div>
          <div class="text-white small">In-Seat Gourmet Dining</div>
        </div>
      </div>
    </div>

    <!-- Multiplex Venues Grid Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="text-white fw-bold mb-0">
        <i class="fa-solid fa-building-columns text-warning me-2"></i> Active CinePulse Multiplexes
      </h3>
      <span class="badge bg-outline-secondary border text-light px-3 py-2 rounded-pill">
        4 Locations Available
      </span>
    </div>

    <!-- Multiplex Venues Grid -->
    <div class="row g-4" id="theatersListContainer"></div>
  </div>
</div>

<?php include_once "includes/footer.php"; ?>

<script>
  // Multiplex Data Fallback Dataset
  const defaultTheaters = [
    {
      id: 1,
      name: "CinePulse Grand IMAX Multiplex",
      location: "Mall Road, Block 4, Downtown City",
      screens: "12 Auditorium Screens",
      status: "Open Now",
      image: "https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=800&auto=format&fit=crop&q=80",
      mapUrl: "https://maps.google.com"
    },
    {
      id: 2,
      name: "CinePulse Royale VIP Lounge",
      location: "Ocean Promenade, Sector 7, Marina Bay",
      screens: "6 VIP Luxe Screens",
      status: "Open Now",
      image: "https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=800&auto=format&fit=crop&q=80",
      mapUrl: "https://maps.google.com"
    },
    {
      id: 3,
      name: "CinePulse 4DX Dome Cinema",
      location: "Tech Hub Boulevard, Phase 2, Northside",
      screens: "8 Dynamic 4DX Screens",
      status: "Open Now",
      image: "https://images.unsplash.com/photo-1595769816263-9b910be24d5f?w=800&auto=format&fit=crop&q=80",
      mapUrl: "https://maps.google.com"
    },
    {
      id: 4,
      name: "CinePulse Max Central",
      location: "Central Square Plaza, Garden East",
      screens: "10 Laser Screens",
      status: "Open Now",
      image: "https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=800&auto=format&fit=crop&q=80",
      mapUrl: "https://maps.google.com"
    }
  ];

  document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('theatersListContainer');
    
    // Check if app data exists from backend JS, otherwise use default multiplex list
    const list = (window.app && window.app.data && window.app.data.theaters) 
      ? window.app.data.theaters 
      : defaultTheaters;

    if (container) {
      container.innerHTML = list.map(t => `
        <div class="col-lg-6">
          <div class="theater-card h-100 d-flex flex-column justify-content-between">
            <div>
              <div class="position-relative overflow-hidden">
                <img src="${t.image || t.poster}" alt="${t.name}" class="theater-img">
                
                <div class="position-absolute top-0 end-0 p-3">
                  <span class="badge bg-success fw-bold px-3 py-2 rounded-pill shadow">
                    <i class="fa-solid fa-circle me-1 small"></i> ${t.status || 'Open Now'}
                  </span>
                </div>

                <div class="position-absolute bottom-0 start-0 p-3 bg-dark bg-opacity-75 backdrop-blur rounded-top-end">
                  <span class="badge bg-info text-dark fw-bold px-2 py-1">
                    <i class="fa-solid fa-tv me-1"></i> ${t.screens || 'Multiple Screens'}
                  </span>
                </div>
              </div>

              <div class="p-4">
                <h4 class="text-white fw-bold mb-2">${t.name}</h4>
                <div class="text-light opacity-75 mb-3 small">
                  <i class="fa-solid fa-location-dot text-warning me-2"></i>${t.location || 'City Center Location'}
                </div>
                
                <div class="d-flex flex-wrap gap-2 mb-4">
                  <span class="amenity-chip"><i class="fa-solid fa-film text-warning me-1"></i> IMAX Laser</span>
                  <span class="amenity-chip"><i class="fa-solid fa-volume-high text-gold me-1"></i> Dolby Atmos</span>
                  <span class="amenity-chip"><i class="fa-solid fa-couch text-purple me-1"></i> VIP Recliners</span>
                  <span class="amenity-chip"><i class="fa-solid fa-square-parking text-success me-1"></i> Free Valet</span>
                </div>
              </div>
            </div>

            <div class="px-4 pb-4 pt-2 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
              <a href="${t.mapUrl || 'https://maps.google.com'}" target="_blank" class="btn btn-outline-light btn-sm fw-bold rounded-3">
                <i class="fa-solid fa-diamond-turn-right me-1 text-info"></i> Get Directions
              </a>
              <a href="book.php?theater_id=${t.id}" class="btn btn-warning btn-sm fw-bold text-dark rounded-3 px-3">
                <i class="fa-solid fa-ticket me-1"></i> Book Shows Here
              </a>
            </div>
          </div>
        </div>
      `).join('');
    }
  });
</script>