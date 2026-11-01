/**
 * ==========================================================================
 * CinePulse - Online Movie Ticket Booking System
 * Core JavaScript: State Management, Dynamic Seat Map, Checkout, Admin CRUD
 * ==========================================================================
 */

// Initial Default State Data (Saved to localStorage if empty)
const INITIAL_DATA = {
  movies: [
    {
      id: "mov-1",
      title: "Dune: Part Two",
      genre: "Sci-Fi / Adventure",
      duration: "2h 46m",
      rating: 4.9,
      ratingCount: 1420,
      status: "now_showing",
      format: "IMAX 3D",
      poster: "https://images.unsplash.com/photo-1534447677768-be436bb09401?w=600&auto=format&fit=crop&q=80",
      backdrop: "https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=1200&auto=format&fit=crop&q=80",
      trailerId: "Way9Dexny3w",
      synopsis: "Paul Atreides unites with Chani and the Fremen while seeking revenge against the conspirators who destroyed his family. Facing a choice between the love of his life and the fate of the universe.",
      director: "Denis Villeneuve",
      cast: [
        { name: "TimothÃ©e Chalamet", role: "Paul Atreides", img: "https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80" },
        { name: "Zendaya", role: "Chani", img: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80" },
        { name: "Rebecca Ferguson", role: "Lady Jessica", img: "https://images.unsplash.com/photo-1580489944761-15a19d654956?w=100&auto=format&fit=crop&q=80" }
      ]
    },
    {
      id: "mov-2",
      title: "Cyberpunk: Neon City",
      genre: "Action / Cyberpunk",
      duration: "2h 15m",
      rating: 4.7,
      ratingCount: 980,
      status: "now_showing",
      format: "Dolby Atmos",
      poster: "https://images.unsplash.com/photo-1509198397868-475647b2a1e5?w=600&auto=format&fit=crop&q=80",
      backdrop: "https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1200&auto=format&fit=crop&q=80",
      trailerId: "qIcTM8WXFjk",
      synopsis: "In a dystopian 2099 metropolis, an undercover cyber-operative uncovers a rogue AI conspiracy controlling human memories and digital consciousness.",
      director: "Elena Rostova",
      cast: [
        { name: "Marcus Vance", role: "Kaelen", img: "https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?w=100&auto=format&fit=crop&q=80" },
        { name: "Sophia Chen", role: "Nyx", img: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" }
      ]
    },
    {
      id: "mov-3",
      title: "Interstellar Odyssey",
      genre: "Sci-Fi / Drama",
      duration: "2h 55m",
      rating: 4.8,
      ratingCount: 2150,
      status: "now_showing",
      format: "IMAX 70mm",
      poster: "https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=600&auto=format&fit=crop&q=80",
      backdrop: "https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?w=1200&auto=format&fit=crop&q=80",
      trailerId: "zSWdZVtXT7E",
      synopsis: "When Earth faces climatic collapse, a team of explorers travels through a newly discovered wormhole near Saturn to secure humanity's future among distant stars.",
      director: "Christopher Nolan",
      cast: [
        { name: "Matthew McConaughey", role: "Cooper", img: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&auto=format&fit=crop&q=80" },
        { name: "Anne Hathaway", role: "Brand", img: "https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&auto=format&fit=crop&q=80" }
      ]
    },
    {
      id: "mov-4",
      title: "The Dark Knight Horizon",
      genre: "Action / Thriller",
      duration: "2h 32m",
      rating: 4.9,
      ratingCount: 3100,
      status: "now_showing",
      format: "4DX",
      poster: "https://images.unsplash.com/photo-1509347528160-9a9e33742cdb?w=600&auto=format&fit=crop&q=80",
      backdrop: "https://images.unsplash.com/photo-1478760329108-5c3ed9d495a0?w=1200&auto=format&fit=crop&q=80",
      trailerId: "EXeTwQWrcwY",
      synopsis: "Gotham City plunges into chaos as a new shadow syndicate emerges, pushing the vigilante hero to test the very moral code that defines his crusade.",
      director: "David Fincher",
      cast: [
        { name: "Christian Bale", role: "Bruce Wayne", img: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&auto=format&fit=crop&q=80" },
        { name: "Gary Oldman", role: "Jim Gordon", img: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&auto=format&fit=crop&q=80" }
      ]
    },
    {
      id: "mov-5",
      title: "Avatar: The Deep Oceans",
      genre: "Fantasy / Adventure",
      duration: "3h 12m",
      rating: 4.6,
      ratingCount: 1640,
      status: "upcoming",
      format: "3D HFR",
      poster: "https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=600&auto=format&fit=crop&q=80",
      backdrop: "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&auto=format&fit=crop&q=80",
      trailerId: "d9MyW72ELq0",
      synopsis: "Jake Sully and Ney'tiri have formed a family and are doing everything to stay together. However, an ancient threat resurfaces in the unexplored bioluminescent trenches of Pandora.",
      director: "James Cameron",
      cast: [
        { name: "Sam Worthington", role: "Jake", img: "https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=100&auto=format&fit=crop&q=80" },
        { name: "Zoe Saldana", role: "Neytiri", img: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" }
      ]
    },
    {
      id: "mov-6",
      title: "Gladiator II: Legacy of Rome",
      genre: "Historical / Action",
      duration: "2h 28m",
      rating: 4.8,
      ratingCount: 890,
      status: "upcoming",
      format: "IMAX 2D",
      poster: "https://images.unsplash.com/photo-1533613220915-609f661a6fe1?w=600&auto=format&fit=crop&q=80",
      backdrop: "https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=1200&auto=format&fit=crop&q=80",
      trailerId: "4rgYUipGJNo",
      synopsis: "Years after witnessing the death of Maximus at the hands of his uncle, Lucius must enter the Colosseum after his home is conquered by the tyrannical Emperors.",
      director: "Ridley Scott",
      cast: [
        { name: "Paul Mescal", role: "Lucius", img: "https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=100&auto=format&fit=crop&q=80" },
        { name: "Denzel Washington", role: "Macrinus", img: "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=100&auto=format&fit=crop&q=80" }
      ]
    }
  ],
  theaters: [
    { id: "th-1", name: "CinePulse Grand IMAX", location: "Downtown Central, Metropolis", screens: 6, status: "Active" },
    { id: "th-2", name: "CinePulse Luxury Dolby Cinema", location: "Westfield Plaza, North Wing", screens: 8, status: "Active" },
    { id: "th-3", name: "CinePulse Royal 4DX Plex", location: "Silicon Boulevard, Tech Park", screens: 4, status: "Active" },
    { id: "th-4", name: "CinePulse Stars Promenade", location: "Bayside Baywalk, Marina", screens: 5, status: "Maintenance" }
  ],
  tierRates: {
    gold: 12,
    platinum: 18,
    box: 25
  },
  showtimes: ["10:30 AM", "01:45 PM", "04:30 PM", "07:15 PM", "10:00 PM"],
  reviews: [
    {
      id: "rev-1",
      movieId: "mov-1",
      userName: "Alex Vance",
      rating: 5,
      date: "2 days ago",
      text: "The sound design in IMAX was mind-blowing! Absolutely breathtaking visuals and unmatched score. Best cinema experience of the decade."
    },
    {
      id: "rev-2",
      movieId: "mov-1",
      userName: "Sophia Loren",
      rating: 5,
      date: "3 days ago",
      text: "Booked the VIP Box seats for date night. The recliner comfort, service, and screen sightlines were 10/10."
    },
    {
      id: "rev-3",
      movieId: "mov-2",
      userName: "David K.",
      rating: 4,
      date: "1 week ago",
      text: "Incredible world building and neon aesthetic. The booking system was super fast and seat selection was seamless."
    }
  ],
  users: [
    { id: "usr-1", name: "Nadeem Khan", email: "nadeem@cinepulse.io", role: "VIP Member", bookingsCount: 14, joinDate: "2025-01-15" },
    { id: "usr-2", name: "Sarah Jenkins", email: "sarah.j@gmail.com", role: "Standard User", bookingsCount: 5, joinDate: "2025-03-22" },
    { id: "usr-3", name: "Michael Chang", email: "mchang@outlook.com", role: "VIP Member", bookingsCount: 9, joinDate: "2025-02-10" },
    { id: "usr-4", name: "Emma Watson", email: "emma.w@cinepulse.io", role: "Admin", bookingsCount: 28, joinDate: "2024-11-01" }
  ],
  bookings: [
    { id: "CP-98241", movie: "Dune: Part Two", theater: "CinePulse Grand IMAX", seats: "B3, B4 (Box Class)", date: "2026-09-02", time: "07:15 PM", amount: 50.00, status: "Confirmed" },
    { id: "CP-78190", movie: "The Dark Knight Horizon", theater: "CinePulse Luxury Dolby Cinema", seats: "D4, D5 (Platinum Class)", date: "2026-09-03", time: "04:30 PM", amount: 36.00, status: "Confirmed" },
    { id: "CP-44120", movie: "Cyberpunk: Neon City", theater: "CinePulse Royal 4DX Plex", seats: "F6, F7, F8 (Gold Class)", date: "2026-09-04", time: "10:00 PM", amount: 36.00, status: "Confirmed" }
  ]
};

// Global App State Controller
class CinePulseApp {
  constructor() {
    this.initStorage();
    this.currentView = "user"; // 'user' or 'admin'
    this.selectedMovie = this.data.movies[0];
    this.selectedTheater = this.data.theaters[0].id;
    this.selectedDate = this.generateDates()[0];
    this.selectedTime = this.data.showtimes[2];
    this.selectedSeats = []; // [{ id: 'B3', row: 'B', num: 3, tier: 'box', price: 25 }]
    this.hasKidsConcession = false;
    this.activeFilter = "all";
    this.searchQuery = "";
    this.currentUser = { name: "Guest User", loggedIn: false };
    this.reviewRating = 5;
    
    // Seat Layout Schema (Tier assignment)
    this.seatLayout = [
      // VIP Box Class (Rows A, B)
      { row: 'A', tier: 'box', seats: [1, 2, 3, 4, 5, 6, 7, 8], reserved: [3, 4] },
      { row: 'B', tier: 'box', seats: [1, 2, 3, 4, 5, 6, 7, 8], reserved: [] },
      // Platinum Class (Rows C, D, E)
      { row: 'C', tier: 'platinum', seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], reserved: [5, 6] },
      { row: 'D', tier: 'platinum', seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], reserved: [1, 2] },
      { row: 'E', tier: 'platinum', seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], reserved: [] },
      // Gold Class (Rows F, G, H, J)
      { row: 'F', tier: 'gold', seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], reserved: [7, 8] },
      { row: 'G', tier: 'gold', seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], reserved: [] },
      { row: 'H', tier: 'gold', seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], reserved: [3, 4, 5] },
      { row: 'J', tier: 'gold', seats: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], reserved: [] }
    ];
  }

  // Initialize LocalStorage
  initStorage() {
    const saved = localStorage.getItem("cinepulse_data_v1");
    if (saved) {
      try {
        this.data = JSON.parse(saved);
      } catch (e) {
        this.data = INITIAL_DATA;
        this.saveStorage();
      }
    } else {
      this.data = INITIAL_DATA;
      this.saveStorage();
    }
  }

  saveStorage() {
    localStorage.setItem("cinepulse_data_v1", JSON.stringify(this.data));
  }

  // Generate Upcoming 7 Days
  generateDates() {
    const dates = [];
    const today = new Date();
    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    for (let i = 0; i < 7; i++) {
      const d = new Date();
      d.setDate(today.getDate() + i);
      dates.push({
        id: d.toISOString().split('T')[0],
        dayName: days[d.getDay()],
        dayNum: d.getDate(),
        month: months[d.getMonth()],
        fullString: `${days[d.getDay()]}, ${months[d.getMonth()]} ${d.getDate()}`
      });
    }
    return dates;
  }

  // Init DOM & Event Listeners
  init() {
    this.renderMovies();
    this.renderBookingSection();
    this.renderReviews();
    this.renderAdminDashboard();
    this.bindEvents();
  }

  // Bind UI Events
  bindEvents() {
    // Navbar scroll background change
    window.addEventListener('scroll', () => {
      const navbar = document.querySelector('.navbar-cinepulse');
      if (navbar) {
        if (window.scrollY > 50) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
      }
    });

    // View Switching: User Portal vs Admin Dashboard
    const btnSwitchAdmin = document.getElementById('btnSwitchAdmin');
    const btnSwitchUser = document.getElementById('btnSwitchUser');
    const userView = document.getElementById('userViewContainer');
    const adminView = document.getElementById('adminViewContainer');

    if (btnSwitchAdmin && btnSwitchUser) {
      btnSwitchAdmin.addEventListener('click', (e) => {
        e.preventDefault();
        this.currentView = "admin";
        userView.classList.add('d-none');
        adminView.classList.remove('d-none');
        this.renderAdminDashboard();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        this.showToast("Switched to Admin Dashboard", "success");
      });

      btnSwitchUser.addEventListener('click', (e) => {
        e.preventDefault();
        this.currentView = "user";
        adminView.classList.add('d-none');
        userView.classList.remove('d-none');
        window.scrollTo({ top: 0, behavior: 'smooth' });
        this.showToast("Returned to Customer Portal", "info");
      });
    }

    // Search Input Real-time Filtering
    const searchInput = document.getElementById('movieSearchInput');
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        this.searchQuery = e.target.value.toLowerCase();
        this.renderMovies();
      });
    }

    // Filter Navigation Tabs
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        filterButtons.forEach(b => b.classList.remove('active'));
        e.currentTarget.classList.add('active');
        this.activeFilter = e.currentTarget.dataset.filter;
        this.renderMovies();
      });
    });

    // Kids Concession Checkbox Change
    const kidsConcessionCheck = document.getElementById('kidsConcessionCheck');
    if (kidsConcessionCheck) {
      kidsConcessionCheck.addEventListener('change', (e) => {
        this.hasKidsConcession = e.target.checked;
        this.updateBookingSummary();
      });
    }

    // Star Rating interactive selection for review form
    const starContainer = document.getElementById('starRatingInput');
    if (starContainer) {
      const stars = starContainer.querySelectorAll('i');
      stars.forEach(star => {
        star.addEventListener('mouseover', (e) => {
          const val = parseInt(e.target.dataset.value);
          this.highlightStars(val);
        });
        star.addEventListener('mouseout', () => {
          this.highlightStars(this.reviewRating);
        });
        star.addEventListener('click', (e) => {
          this.reviewRating = parseInt(e.target.dataset.value);
          this.highlightStars(this.reviewRating);
        });
      });
    }

    // Review Submission Form
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
      reviewForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const userName = document.getElementById('reviewAuthorName').value.trim() || 'Cinephile User';
        const reviewText = document.getElementById('reviewContentText').value.trim();
        
        if (!reviewText) {
          this.showToast("Please enter your review text!", "warning");
          return;
        }

        const newReview = {
          id: `rev-${Date.now()}`,
          movieId: this.selectedMovie.id,
          userName: userName,
          rating: this.reviewRating,
          date: "Just now",
          text: reviewText
        };

        this.data.reviews.unshift(newReview);
        this.saveStorage();
        this.renderReviews();
        reviewForm.reset();
        this.highlightStars(5);
        this.reviewRating = 5;
        this.showToast("Review submitted successfully! Thank you.", "success");
      });
    }

    // Auth Form Toggle & Submission
    const authForm = document.getElementById('authForm');
    if (authForm) {
      authForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = document.getElementById('authEmail').value;
        const name = email.split('@')[0];
        this.currentUser = { name: name.charAt(0).toUpperCase() + name.slice(1), email: email, loggedIn: true };
        
        // Update Navbar User Button
        const userBtn = document.getElementById('navUserBtn');
        if (userBtn) {
          userBtn.innerHTML = `<i class="fa-solid fa-user-check text-brand me-1"></i> ${this.currentUser.name}`;
        }

        const authModal = bootstrap.Modal.getInstance(document.getElementById('authModal'));
        if (authModal) authModal.hide();

        this.showToast(`Welcome back, ${this.currentUser.name}!`, "success");
      });
    }

    // Payment Form Submit (Mock Checkout)
    const checkoutForm = document.getElementById('paymentCheckoutForm');
    if (checkoutForm) {
      checkoutForm.addEventListener('submit', (e) => {
        e.preventDefault();
        this.processPayment();
      });
    }

    // Close Video Modal Cleanup (Stops YouTube audio playback)
    const trailerModal = document.getElementById('trailerModal');
    if (trailerModal) {
      trailerModal.addEventListener('hidden.bs.modal', () => {
        const frame = document.getElementById('trailerIframe');
        if (frame) frame.src = '';
      });
    }
  }

  // Highlight Stars in Rating Input
  highlightStars(val) {
    const stars = document.querySelectorAll('#starRatingInput i');
    stars.forEach(s => {
      const v = parseInt(s.dataset.value);
      if (v <= val) {
        s.classList.remove('fa-regular', 'text-muted');
        s.classList.add('fa-solid', 'text-gold');
      } else {
        s.classList.remove('fa-solid', 'text-gold');
        s.classList.add('fa-regular', 'text-muted');
      }
    });
  }

  // Render Movies Showcase
  renderMovies() {
    const grid = document.getElementById('moviesGrid');
    if (!grid) return;

    let filtered = this.data.movies;

    // Filter by tab
    if (this.activeFilter === 'now_showing') {
      filtered = filtered.filter(m => m.status === 'now_showing');
    } else if (this.activeFilter === 'upcoming') {
      filtered = filtered.filter(m => m.status === 'upcoming');
    } else if (this.activeFilter === 'imax') {
      filtered = filtered.filter(m => m.format.includes('IMAX'));
    }

    // Filter by search query
    if (this.searchQuery) {
      filtered = filtered.filter(m => 
        m.title.toLowerCase().includes(this.searchQuery) ||
        m.genre.toLowerCase().includes(this.searchQuery)
      );
    }

    if (filtered.length === 0) {
      grid.innerHTML = `
        <div class="col-12 text-center py-5">
          <div class="glassmorphism p-5 rounded-4 d-inline-block">
            <i class="fa-solid fa-film fa-3x text-muted mb-3"></i>
            <h4 class="text-white">No Movies Found</h4>
            <p class="text-muted-custom mb-0">Try clearing your search filters or check back later.</p>
          </div>
        </div>
      `;
      return;
    }

    grid.innerHTML = filtered.map(movie => `
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="movie-card">
          <div class="movie-poster-wrap">
            <img src="${movie.poster}" alt="${movie.title}" class="movie-poster-img" loading="lazy">
            <div class="movie-poster-overlay">
              <div class="d-flex justify-content-between align-items-center">
                <span class="badge-pill-custom badge-brand">${movie.status === 'now_showing' ? 'Now Showing' : 'Presale'}</span>
                <span class="badge-pill-custom badge-cyan">${movie.format}</span>
              </div>
            </div>
            <div class="movie-hover-actions">
              <button class="play-circle-btn" onclick="app.openTrailerModal('${movie.id}')" title="Watch Trailer">
                <i class="fa-solid fa-play"></i>
              </button>
              <span class="text-white fw-bold small">Watch Official Trailer</span>
              <button class="btn btn-cinema-outline btn-sm mt-2" onclick="app.openMovieDetailsModal('${movie.id}')">
                <i class="fa-solid fa-circle-info me-1"></i> View Synopsis
              </button>
            </div>
          </div>
          <div class="movie-card-body">
            <div>
              <h5 class="movie-title text-white" title="${movie.title}">${movie.title}</h5>
              <div class="movie-meta-info">
                <span><i class="fa-solid fa-tags me-1 text-brand"></i>${movie.genre}</span>
                <span><i class="fa-regular fa-clock me-1"></i>${movie.duration}</span>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-2 border-top border-glass">
              <div class="rating-badge">
                <i class="fa-solid fa-star"></i>
                <span>${movie.rating}</span>
                <small class="text-muted fw-normal">(${movie.ratingCount})</small>
              </div>
              <button class="btn btn-cinema btn-sm" href="movie-details.php"onclick="app.selectMovieForBooking('${movie.id}')">
                <i class="fa-solid fa-ticket me-1"></i> Book Ticket
              </button>
            </div>
          </div>
        </div>
      </div>
    `).join('');
  }

  // Open Trailer Video Modal
  openTrailerModal(movieId) {
    const movie = this.data.movies.find(m => m.id === movieId);
    if (!movie) return;

    const modalTitle = document.getElementById('trailerModalLabel');
    const iframe = document.getElementById('trailerIframe');
    
    if (modalTitle) modalTitle.innerHTML = `<i class="fa-brands fa-youtube text-brand me-2"></i> ${movie.title} - Official Trailer`;
    if (iframe) iframe.src = `https://www.youtube.com/embed/${movie.trailerId}?autoplay=1&rel=0`;

    const trailerModal = new bootstrap.Modal(document.getElementById('trailerModal'));
    trailerModal.show();
  }

  // Open Movie Details Synopsis Modal
  openMovieDetailsModal(movieId) {
    const movie = this.data.movies.find(m => m.id === movieId);
    if (!movie) return;

    document.getElementById('detailMovieTitle').textContent = movie.title;
    document.getElementById('detailMoviePoster').src = movie.poster;
    document.getElementById('detailMovieGenre').textContent = movie.genre;
    document.getElementById('detailMovieDuration').textContent = movie.duration;
    document.getElementById('detailMovieFormat').textContent = movie.format;
    document.getElementById('detailMovieRating').textContent = movie.rating;
    document.getElementById('detailMovieDirector').textContent = movie.director;
    document.getElementById('detailMovieSynopsis').textContent = movie.synopsis;

    // Render Cast
    const castContainer = document.getElementById('detailMovieCast');
    if (castContainer) {
      castContainer.innerHTML = movie.cast.map(c => `
        <div class="d-flex align-items-center gap-3 bg-dark p-2 rounded-3 border border-glass">
          <img src="${c.img}" alt="${c.name}" class="cast-avatar">
          <div>
            <div class="fw-bold text-white small">${c.name}</div>
            <div class="text-whitesmall">${c.role}</div>
          </div>
        </div>
      `).join('');
    }

    const detailModal = new bootstrap.Modal(document.getElementById('movieDetailsModal'));
    detailModal.show();
  }

  // Select Movie & Jump to Booking Section
  selectMovieForBooking(movieId) {
    const movie = this.data.movies.find(m => m.id === movieId);
    if (!movie) return;

    this.selectedMovie = movie;
    this.selectedSeats = [];
    this.renderBookingSection();
    this.renderReviews();

    const bookingSection = document.getElementById('bookingSection');
    if (bookingSection) {
      bookingSection.scrollIntoView({ behavior: 'smooth' });
    }
    this.showToast(`Selected "${movie.title}". Pick your date, time & seats!`, "info");
  }

  // Render Interactive Booking Section
  renderBookingSection() {
    // Update Movie Title Header
    const currentMovieNameElem = document.getElementById('currentBookingMovieName');
    if (currentMovieNameElem) {
      currentMovieNameElem.textContent = this.selectedMovie.title;
    }

    // Populate Theater Select
    const theaterSelect = document.getElementById('bookingTheaterSelect');
    if (theaterSelect) {
      theaterSelect.innerHTML = this.data.theaters.map(t => `
        <option value="${t.id}" ${t.id === this.selectedTheater ? 'selected' : ''}>
          ${t.name} (${t.location})
        </option>
      `).join('');

      theaterSelect.onchange = (e) => {
        this.selectedTheater = e.target.value;
        this.selectedSeats = [];
        this.renderSeatGrid();
        this.updateBookingSummary();
      };
    }

    // Populate Date Pills
    const dateContainer = document.getElementById('bookingDatePills');
    if (dateContainer) {
      const dates = this.generateDates();
      dateContainer.innerHTML = dates.map((d, index) => `
        <div class="date-pill ${index === 0 ? 'active' : ''}" data-date="${d.id}" onclick="app.selectDate('${d.id}', this)">
          <div class="day-name">${d.dayName}</div>
          <div class="day-num">${d.dayNum}</div>
          <div class="small opacity-75">${d.month}</div>
        </div>
      `).join('');
    }

    // Populate Showtimes
    const showtimeContainer = document.getElementById('bookingTimeSlots');
    if (showtimeContainer) {
      showtimeContainer.innerHTML = this.data.showtimes.map((time, index) => `
        <span class="time-slot-pill ${index === 2 ? 'active' : ''}" onclick="app.selectTime('${time}', this)">
          <i class="fa-regular fa-clock me-1 text-gold"></i> ${time}
        </span>
      `).join('');
    }

    // Render Seat Grid & Summary
    this.renderSeatGrid();
    this.updateBookingSummary();
  }

  selectDate(dateId, elem) {
    this.selectedDate = this.generateDates().find(d => d.id === dateId);
    document.querySelectorAll('.date-pill').forEach(el => el.classList.remove('active'));
    elem.classList.add('active');
    this.selectedSeats = [];
    this.renderSeatGrid();
    this.updateBookingSummary();
  }

  selectTime(time, elem) {
    this.selectedTime = time;
    document.querySelectorAll('.time-slot-pill').forEach(el => el.classList.remove('active'));
    elem.classList.add('active');
    this.selectedSeats = [];
    this.renderSeatGrid();
    this.updateBookingSummary();
  }

  // Render Realistic Multi-tier Seat Grid
  renderSeatGrid() {
    const seatGridContainer = document.getElementById('seatGridContainer');
    if (!seatGridContainer) return;

    seatGridContainer.innerHTML = this.seatLayout.map(rowConfig => {
      const tierRate = this.data.tierRates[rowConfig.tier];
      const tierClass = `seat-${rowConfig.tier}-tier`;
      
      const seatsHtml = rowConfig.seats.map((seatNum, idx) => {
        const seatId = `${rowConfig.row}${seatNum}`;
        const isReserved = rowConfig.reserved.includes(seatNum);
        const isSelected = this.selectedSeats.some(s => s.id === seatId);

        // Add aisle gap in middle
        const isAisle = (rowConfig.seats.length === 8 && idx === 4) ||
                        (rowConfig.seats.length === 10 && idx === 5) ||
                        (rowConfig.seats.length === 12 && idx === 6);

        const aisleGapHtml = isAisle ? `<div class="seat-aisle-gap"></div>` : '';

        return `
          ${aisleGapHtml}
          <div 
            class="seat ${tierClass} ${isReserved ? 'reserved' : ''} ${isSelected ? 'selected' : ''}" 
            data-id="${seatId}" 
            data-row="${rowConfig.row}" 
            data-num="${seatNum}" 
            data-tier="${rowConfig.tier}" 
            data-price="${tierRate}"
            title="${seatId} [${rowConfig.tier.toUpperCase()} Class - $${tierRate}]"
            onclick="app.toggleSeat('${seatId}', '${rowConfig.row}', ${seatNum}, '${rowConfig.tier}', ${tierRate})"
          >
            ${seatNum}
          </div>
        `;
      }).join('');

      return `
        <div class="seat-row">
          <div class="row-letter">${rowConfig.row}</div>
          <div class="d-flex align-items-center gap-2">
            ${seatsHtml}
          </div>
          <div class="row-letter">${rowConfig.row}</div>
        </div>
      `;
    }).join('');
  }

  // Toggle Seat Selection
  toggleSeat(seatId, row, num, tier, price) {
    const existingIndex = this.selectedSeats.findIndex(s => s.id === seatId);
    
    if (existingIndex > -1) {
      this.selectedSeats.splice(existingIndex, 1);
    } else {
      if (this.selectedSeats.length >= 8) {
        this.showToast("Maximum 8 seats allowed per booking transaction!", "warning");
        return;
      }
      this.selectedSeats.push({ id: seatId, row, num, tier, price });
    }

    this.renderSeatGrid();
    this.updateBookingSummary();
  }

  // Remove specific seat from summary chip
  removeSeat(seatId) {
    this.selectedSeats = this.selectedSeats.filter(s => s.id !== seatId);
    this.renderSeatGrid();
    this.updateBookingSummary();
  }

  // Update Dynamic Booking Calculation Summary
  updateBookingSummary() {
    const selectedChipsContainer = document.getElementById('selectedSeatsChips');
    const summarySeatCount = document.getElementById('summarySeatCount');
    const summarySubtotal = document.getElementById('summarySubtotal');
    const summaryDiscountRow = document.getElementById('summaryDiscountRow');
    const summaryDiscountAmount = document.getElementById('summaryDiscountAmount');
    const summaryServiceFee = document.getElementById('summaryServiceFee');
    const summaryGrandTotal = document.getElementById('summaryGrandTotal');
    const btnProceedCheckout = document.getElementById('btnProceedCheckout');

    const count = this.selectedSeats.length;
    if (summarySeatCount) summarySeatCount.textContent = count;

    if (count === 0) {
      if (selectedChipsContainer) {
        selectedChipsContainer.innerHTML = `<span class="text-muted small italic">No seats selected yet. Click on the seat layout above.</span>`;
      }
      if (summarySubtotal) summarySubtotal.textContent = '$0.00';
      if (summaryDiscountRow) summaryDiscountRow.classList.add('d-none');
      if (summaryServiceFee) summaryServiceFee.textContent = '$0.00';
      if (summaryGrandTotal) summaryGrandTotal.textContent = '$0.00';
      if (btnProceedCheckout) btnProceedCheckout.disabled = true;
      return;
    }

    if (btnProceedCheckout) btnProceedCheckout.disabled = false;

    // Render Seat Chips
    if (selectedChipsContainer) {
      selectedChipsContainer.innerHTML = this.selectedSeats.map(s => `
        <span class="seat-chip">
          <i class="fa-solid fa-couch me-1"></i> ${s.id} (${s.tier.toUpperCase()})
          <span class="remove-seat ms-1" onclick="app.removeSeat('${s.id}')" title="Remove">&times;</span>
        </span>
      `).join('');
    }

    // Calculate Prices
    const subtotal = this.selectedSeats.reduce((acc, s) => acc + s.price, 0);
    let discount = 0;
    
    if (this.hasKidsConcession) {
      // 20% concession deduction
      discount = subtotal * 0.20;
      if (summaryDiscountRow) summaryDiscountRow.classList.remove('d-none');
      if (summaryDiscountAmount) summaryDiscountAmount.textContent = `-$${discount.toFixed(2)}`;
    } else {
      if (summaryDiscountRow) summaryDiscountRow.classList.add('d-none');
    }

    const serviceTax = (subtotal - discount) * 0.05; // 5% booking fee
    const grandTotal = subtotal - discount + serviceTax;

    if (summarySubtotal) summarySubtotal.textContent = `$${subtotal.toFixed(2)}`;
    if (summaryServiceFee) summaryServiceFee.textContent = `$${serviceTax.toFixed(2)}`;
    if (summaryGrandTotal) summaryGrandTotal.textContent = `$${grandTotal.toFixed(2)}`;
  }

  // Open Checkout / Payment Modal
  openCheckoutModal() {
    if (this.selectedSeats.length === 0) {
      this.showToast("Please select at least one seat to proceed!", "warning");
      return;
    }

    const theaterObj = this.data.theaters.find(t => t.id === this.selectedTheater) || this.data.theaters[0];
    const subtotal = this.selectedSeats.reduce((acc, s) => acc + s.price, 0);
    const discount = this.hasKidsConcession ? (subtotal * 0.20) : 0;
    const serviceTax = (subtotal - discount) * 0.05;
    const grandTotal = subtotal - discount + serviceTax;

    // Populate Checkout Modal details
    document.getElementById('checkoutMovieTitle').textContent = this.selectedMovie.title;
    document.getElementById('checkoutPosterImg').src = this.selectedMovie.poster;
    document.getElementById('checkoutTheaterName').textContent = theaterObj.name;
    document.getElementById('checkoutDateTime').textContent = `${this.selectedDate.fullString} @ ${this.selectedTime}`;
    document.getElementById('checkoutSeatsList').textContent = this.selectedSeats.map(s => s.id).join(', ');
    document.getElementById('checkoutAmountPayable').textContent = `$${grandTotal.toFixed(2)}`;

    const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutPaymentModal'));
    checkoutModal.show();
  }

  // Process Mock Payment & Generate Ticket
  processPayment() {
    const checkoutModal = bootstrap.Modal.getInstance(document.getElementById('checkoutPaymentModal'));
    if (checkoutModal) checkoutModal.hide();

    const bookingRef = `CP-${Math.floor(10000 + Math.random() * 90000)}`;
    const theaterObj = this.data.theaters.find(t => t.id === this.selectedTheater) || this.data.theaters[0];
    const seatsStr = this.selectedSeats.map(s => s.id).join(', ');
    const subtotal = this.selectedSeats.reduce((acc, s) => acc + s.price, 0);
    const discount = this.hasKidsConcession ? (subtotal * 0.20) : 0;
    const total = subtotal - discount + ((subtotal - discount) * 0.05);

    // Save booking to state
    const newBooking = {
      id: bookingRef,
      movie: this.selectedMovie.title,
      theater: theaterObj.name,
      seats: seatsStr,
      date: this.selectedDate.id,
      time: this.selectedTime,
      amount: parseFloat(total.toFixed(2)),
      status: "Confirmed"
    };

    this.data.bookings.unshift(newBooking);
    this.saveStorage();

    // Populate Confirmation Ticket Modal
    document.getElementById('ticketBookingId').textContent = bookingRef;
    document.getElementById('ticketMovieTitle').textContent = this.selectedMovie.title;
    document.getElementById('ticketTheater').textContent = theaterObj.name;
    document.getElementById('ticketDateTime').textContent = `${this.selectedDate.fullString} | ${this.selectedTime}`;
    document.getElementById('ticketSeats').textContent = seatsStr;
    document.getElementById('ticketTotalPaid').textContent = `$${total.toFixed(2)}`;

    // Reset selected seats
    this.selectedSeats = [];
    this.renderSeatGrid();
    this.updateBookingSummary();

    const confirmModal = new bootstrap.Modal(document.getElementById('ticketConfirmationModal'));
    confirmModal.show();

    this.showToast("Payment Successful! Your ticket has been issued.", "success");
  }

  // Render Community Reviews
  renderReviews() {
    const reviewsContainer = document.getElementById('communityReviewsList');
    if (!reviewsContainer) return;

    const movieReviews = this.data.reviews.filter(r => r.movieId === this.selectedMovie.id || !r.movieId);

    if (movieReviews.length === 0) {
      reviewsContainer.innerHTML = `
        <div class="text-center py-4 text-muted">
          <i class="fa-regular fa-comment-dots fa-2x mb-2"></i>
          <p>No reviews yet for this movie. Be the first to share your thoughts!</p>
        </div>
      `;
      return;
    }

    reviewsContainer.innerHTML = movieReviews.map(r => `
      <div class="review-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <div class="d-flex align-items-center gap-3">
            <div class="user-avatar-initial">${r.userName.charAt(0).toUpperCase()}</div>
            <div>
              <div class="fw-bold text-white">${r.userName}</div>
              <div class="small text-white">${r.date}</div>
            </div>
          </div>
          <div class="text-gold">
            ${Array.from({ length: 5 }, (_, i) => `<i class="fa-${i < r.rating ? 'solid' : 'regular'} fa-star"></i>`).join('')}
          </div>
        </div>
        <p class="text-muted-custom mb-0 mt-2 small">${r.text}</p>
      </div>
    `).join('');
  }

  // ==========================================================================
  // Admin Dashboard CRUD Operations
  // ==========================================================================
  renderAdminDashboard() {
    // 1. Render Metrics Stats
    const totalUsersElem = document.getElementById('statTotalUsers');
    const totalTheatersElem = document.getElementById('statTotalTheaters');
    const totalMoviesElem = document.getElementById('statTotalMovies');
    const totalBookingsElem = document.getElementById('statTotalBookings');

    if (totalUsersElem) totalUsersElem.textContent = this.data.users.length;
    if (totalTheatersElem) totalTheatersElem.textContent = this.data.theaters.length;
    if (totalMoviesElem) totalMoviesElem.textContent = this.data.movies.length;
    if (totalBookingsElem) totalBookingsElem.textContent = this.data.bookings.length;

    // 2. Render Theaters Table
    this.renderAdminTheaters();

    // 3. Render Movies Table
    this.renderAdminMovies();

    // 4. Render Shows & Tier Pricing
    this.renderAdminShowsAndRates();

    // 5. Render Users Table
    this.renderAdminUsers();
  }

  renderAdminTheaters() {
    const tbody = document.getElementById('adminTheatersTableBody');
    if (!tbody) return;

    tbody.innerHTML = this.data.theaters.map(t => `
      <tr>
        <td class="fw-bold text-white">${t.name}</td>
        <td><i class="fa-solid fa-location-dot text-brand me-1"></i> ${t.location}</td>
        <td><span class="badge-pill-custom badge-cyan">${t.screens} Screens</span></td>
        <td><span class="badge-pill-custom ${t.status === 'Active' ? 'badge-gold' : 'badge-brand'}">${t.status}</span></td>
        <td class="text-end">
          <button class="btn-action-icon edit me-1" onclick="app.editTheater('${t.id}')" title="Edit Theater">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button class="btn-action-icon" onclick="app.deleteTheater('${t.id}')" title="Delete Theater">
            <i class="fa-solid fa-trash"></i>
          </button>
        </td>
      </tr>
    `).join('');
  }

  // Add / Edit Theater Modal Trigger
  openTheaterModal(theaterId = null) {
    const title = document.getElementById('theaterModalTitle');
    const idInput = document.getElementById('theaterIdInput');
    const nameInput = document.getElementById('theaterNameInput');
    const locInput = document.getElementById('theaterLocationInput');
    const screensInput = document.getElementById('theaterScreensInput');
    const statusInput = document.getElementById('theaterStatusInput');

    if (theaterId) {
      const theater = this.data.theaters.find(t => t.id === theaterId);
      if (!theater) return;
      title.textContent = "Edit Theater Details";
      idInput.value = theater.id;
      nameInput.value = theater.name;
      locInput.value = theater.location;
      screensInput.value = theater.screens;
      statusInput.value = theater.status;
    } else {
      title.textContent = "Add New Theater";
      idInput.value = "";
      nameInput.value = "";
      locInput.value = "";
      screensInput.value = "6";
      statusInput.value = "Active";
    }

    const modal = new bootstrap.Modal(document.getElementById('theaterCrudModal'));
    modal.show();
  }

  saveTheater() {
    const id = document.getElementById('theaterIdInput').value;
    const name = document.getElementById('theaterNameInput').value.trim();
    const location = document.getElementById('theaterLocationInput').value.trim();
    const screens = parseInt(document.getElementById('theaterScreensInput').value) || 4;
    const status = document.getElementById('theaterStatusInput').value;

    if (!name || !location) {
      this.showToast("Please fill in theater name and location.", "warning");
      return;
    }

    if (id) {
      // Edit
      const index = this.data.theaters.findIndex(t => t.id === id);
      if (index > -1) {
        this.data.theaters[index] = { id, name, location, screens, status };
        this.showToast("Theater updated successfully!", "success");
      }
    } else {
      // Add
      const newTheater = {
        id: `th-${Date.now()}`,
        name, location, screens, status
      };
      this.data.theaters.push(newTheater);
      this.showToast("New theater added successfully!", "success");
    }

    this.saveStorage();
    this.renderAdminDashboard();
    this.renderBookingSection();

    const modal = bootstrap.Modal.getInstance(document.getElementById('theaterCrudModal'));
    if (modal) modal.hide();
  }

  editTheater(id) {
    this.openTheaterModal(id);
  }

  deleteTheater(id) {
    if (confirm("Are you sure you want to delete this theater?")) {
      this.data.theaters = this.data.theaters.filter(t => t.id !== id);
      this.saveStorage();
      this.renderAdminDashboard();
      this.renderBookingSection();
      this.showToast("Theater deleted.", "info");
    }
  }

  // Manage Movies Table
  renderAdminMovies() {
    const tbody = document.getElementById('adminMoviesTableBody');
    if (!tbody) return;

    tbody.innerHTML = this.data.movies.map(m => `
      <tr>
        <td>
          <div class="d-flex align-items-center gap-2">
            <img src="${m.poster}" style="width: 36px; height: 50px; object-fit: cover; border-radius: 4px;">
            <div>
              <div class="fw-bold text-white">${m.title}</div>
              <div class="small text-muted">${m.format}</div>
            </div>
          </div>
        </td>
        <td>${m.genre}</td>
        <td>${m.duration}</td>
        <td><span class="badge-pill-custom badge-gold"><i class="fa-solid fa-star"></i> ${m.rating}</span></td>
        <td><span class="badge-pill-custom ${m.status === 'now_showing' ? 'badge-brand' : 'badge-cyan'}">${m.status}</span></td>
        <td class="text-end">
          <button class="btn-action-icon edit me-1" onclick="app.editMovie('${m.id}')" title="Edit Movie">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button class="btn-action-icon" onclick="app.deleteMovie('${m.id}')" title="Delete Movie">
            <i class="fa-solid fa-trash"></i>
          </button>
        </td>
      </tr>
    `).join('');
  }

  openMovieModal(movieId = null) {
    const title = document.getElementById('movieModalTitle');
    const idInput = document.getElementById('movieIdInput');
    const titleInput = document.getElementById('movieTitleInput');
    const genreInput = document.getElementById('movieGenreInput');
    const durationInput = document.getElementById('movieDurationInput');
    const formatInput = document.getElementById('movieFormatInput');
    const statusInput = document.getElementById('movieStatusInput');
    const posterInput = document.getElementById('moviePosterInput');
    const trailerInput = document.getElementById('movieTrailerInput');
    const synopsisInput = document.getElementById('movieSynopsisInput');

    if (movieId) {
      const movie = this.data.movies.find(m => m.id === movieId);
      if (!movie) return;
      title.textContent = "Edit Movie Details";
      idInput.value = movie.id;
      titleInput.value = movie.title;
      genreInput.value = movie.genre;
      durationInput.value = movie.duration;
      formatInput.value = movie.format;
      statusInput.value = movie.status;
      posterInput.value = movie.poster;
      trailerInput.value = movie.trailerId;
      synopsisInput.value = movie.synopsis;
    } else {
      title.textContent = "Add New Movie";
      idInput.value = "";
      titleInput.value = "";
      genreInput.value = "Action / Adventure";
      durationInput.value = "2h 10m";
      formatInput.value = "IMAX 3D";
      statusInput.value = "now_showing";
      posterInput.value = "https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=600&auto=format&fit=crop&q=80";
      trailerInput.value = "Way9Dexny3w";
      synopsisInput.value = "";
    }

    const modal = new bootstrap.Modal(document.getElementById('movieCrudModal'));
    modal.show();
  }

  saveMovie() {
    const id = document.getElementById('movieIdInput').value;
    const title = document.getElementById('movieTitleInput').value.trim();
    const genre = document.getElementById('movieGenreInput').value.trim();
    const duration = document.getElementById('movieDurationInput').value.trim();
    const format = document.getElementById('movieFormatInput').value.trim();
    const status = document.getElementById('movieStatusInput').value;
    const poster = document.getElementById('moviePosterInput').value.trim();
    const trailerId = document.getElementById('movieTrailerInput').value.trim();
    const synopsis = document.getElementById('movieSynopsisInput').value.trim();

    if (!title || !genre || !poster) {
      this.showToast("Please fill in movie title, genre, and poster URL.", "warning");
      return;
    }

    if (id) {
      // Edit
      const index = this.data.movies.findIndex(m => m.id === id);
      if (index > -1) {
        this.data.movies[index] = {
          ...this.data.movies[index],
          title, genre, duration, format, status, poster, trailerId, synopsis
        };
        this.showToast("Movie updated successfully!", "success");
      }
    } else {
      // Add
      const newMovie = {
        id: `mov-${Date.now()}`,
        title, genre, duration, format, status, poster, trailerId, synopsis,
        rating: 4.8,
        ratingCount: 1,
        backdrop: poster,
        director: "Featured Director",
        cast: [
          { name: "Lead Star", role: "Protagonist", img: "https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&auto=format&fit=crop&q=80" }
        ]
      };
      this.data.movies.unshift(newMovie);
      this.showToast("New movie added to catalog!", "success");
    }

    this.saveStorage();
    this.renderMovies();
    this.renderAdminDashboard();

    const modal = bootstrap.Modal.getInstance(document.getElementById('movieCrudModal'));
    if (modal) modal.hide();
  }

  editMovie(id) {
    this.openMovieModal(id);
  }

  deleteMovie(id) {
    if (confirm("Are you sure you want to delete this movie?")) {
      this.data.movies = this.data.movies.filter(m => m.id !== id);
      this.saveStorage();
      this.renderMovies();
      this.renderAdminDashboard();
      this.showToast("Movie deleted.", "info");
    }
  }

  // Manage Shows & Rates
  renderAdminShowsAndRates() {
    const goldInput = document.getElementById('rateGoldClass');
    const platInput = document.getElementById('ratePlatinumClass');
    const boxInput = document.getElementById('rateBoxClass');

    if (goldInput) goldInput.value = this.data.tierRates.gold;
    if (platInput) platInput.value = this.data.tierRates.platinum;
    if (boxInput) boxInput.value = this.data.tierRates.box;

    const timingsContainer = document.getElementById('adminTimingsBadges');
    if (timingsContainer) {
      timingsContainer.innerHTML = this.data.showtimes.map(t => `
        <span class="badge-pill-custom badge-cyan me-2 mb-2">
          <i class="fa-regular fa-clock me-1"></i> ${t}
        </span>
      `).join('');
    }
  }

  saveTierRates() {
    const gold = parseFloat(document.getElementById('rateGoldClass').value) || 12;
    const plat = parseFloat(document.getElementById('ratePlatinumClass').value) || 18;
    const box = parseFloat(document.getElementById('rateBoxClass').value) || 25;

    this.data.tierRates = { gold, platinum: plat, box };
    this.saveStorage();
    this.renderSeatGrid();
    this.updateBookingSummary();
    this.showToast("Seat tier pricing rates updated successfully!", "success");
  }

  // Registered Users Table
  renderAdminUsers() {
    const tbody = document.getElementById('adminUsersTableBody');
    if (!tbody) return;

    tbody.innerHTML = this.data.users.map(u => `
      <tr>
        <td>
          <div class="d-flex align-items-center gap-2">
            <div class="user-avatar-initial" style="width: 32px; height: 32px; font-size: 0.85rem;">${u.name.charAt(0)}</div>
            <span class="fw-bold text-white">${u.name}</span>
          </div>
        </td>
        <td>${u.email}</td>
        <td><span class="badge-pill-custom ${u.role === 'Admin' ? 'badge-brand' : u.role === 'VIP Member' ? 'badge-gold' : 'badge-cyan'}">${u.role}</span></td>
        <td><span class="fw-bold text-white">${u.bookingsCount}</span> bookings</td>
        <td class="text-muted small">${u.joinDate}</td>
      </tr>
    `).join('');
  }

  // Toast Notification Helper
  showToast(message, type = "info") {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toastId = `toast-${Date.now()}`;
    const bgIcon = type === 'success' ? 'fa-circle-check text-success' : 
                   type === 'warning' ? 'fa-triangle-exclamation text-warning' : 
                   'fa-circle-info text-cyan';

    const toastHtml = `
      <div id="${toastId}" class="toast toast-cinema align-items-center border-0 show mb-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body d-flex align-items-center gap-2">
            <i class="fa-solid ${bgIcon} fa-lg"></i>
            <span>${message}</span>
          </div>
          <button type="button" class="btn-close btn-close-cinema me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    `;

    container.insertAdjacentHTML('beforeend', toastHtml);

    setTimeout(() => {
      const el = document.getElementById(toastId);
      if (el) el.remove();
    }, 4500);
  }
}

// Global App Instance
let app;
document.addEventListener('DOMContentLoaded', () => {
  app = new CinePulseApp();
  app.init();
});