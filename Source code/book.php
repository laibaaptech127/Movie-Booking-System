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
/* -------------------- PLAN -------------------- */
$plan = isset($_GET['plan']) ? $_GET['plan'] : 'gold';

$plans = [
    'gold' => [
        'name' => 'Gold Class',
        'price' => 12
    ],
    'platinum' => [
        'name' => 'Platinum VIP',
        'price' => 18
    ],
    'vip' => [
        'name' => 'VIP Luxury Box',
        'price' => 25
    ]
];

if (!isset($plans[$plan])) {
    $plan = 'gold';
}

$selectedPlan = $plans[$plan];

/* -------------------- SHOWS -------------------- */
$show_query = "SELECT * FROM shows";
$show_result = mysqli_query($connect, $show_query);
$shows = mysqli_fetch_all($show_result, MYSQLI_ASSOC);

$showDates = [];
foreach ($shows as $show) {
    if (!in_array($show['show_date'], $showDates)) {
        $showDates[] = $show['show_date'];
    }
}
$showTimes = [];
foreach ($shows as $show) {
    if (!in_array($show['show_time'], $showTimes)) {
        $showTimes[] = $show['show_time'];
    }
}

/* -------------------- THEATERS -------------------- */
$cinema_query = "SELECT * FROM theaters";
$cinema_result = mysqli_query($connect, $cinema_query);
$cinema = mysqli_fetch_all($cinema_result, MYSQLI_ASSOC);
?>

<div class="page-content-wrapper text-white">
  <div class="page-banner mb-4 text-center">
    <div class="container">
      <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">Real-Time Seat Reservation</span>
      <h1 class="display-4 fw-black text-white mb-2">Book Your Seats</h1>
      <p class="text-light mb-0 fs-5">
        Selected Plan:
        <strong class="text-warning" id="selectedPlanName"><?= $selectedPlan['name'] ?></strong>
        <span class="ms-2">($<span id="planPrice"><?= $selectedPlan['price'] ?></span> / ticket)</span>
      </p>
    </div>
  </div>

  <div class="container pb-5">
    <div class="glass-card mb-4 p-3 rounded-4">
      <div class="row g-3 align-items-center">

        <!-- Plan -->
        <div class="col-lg-3">
          <label class="form-label text-warning small fw-bold mb-1">
            <i class="fa-solid fa-crown me-1"></i> Ticket Plan
          </label>
          <select class="form-select bg-dark text-white border-secondary rounded-3" id="bookingPlanSelect" onchange="changePlan(this.value)">
            <option value="gold" <?= $plan == 'gold' ? 'selected' : '' ?>>Gold Class - $12</option>
            <option value="platinum" <?= $plan == 'platinum' ? 'selected' : '' ?>>Platinum VIP - $18</option>
            <option value="vip" <?= $plan == 'vip' ? 'selected' : '' ?>>VIP Luxury Box - $25</option>
          </select>
        </div>

        <!-- Theater -->
        <div class="col-lg-3">
          <label class="form-label text-warning small fw-bold mb-1">
            <i class="fa-solid fa-building-columns me-1"></i> Theater
          </label>
          <select class="form-select bg-dark text-white border-secondary rounded-3" id="bookingTheaterSelect">
            <option value="all">All Theaters</option>
            <?php foreach ($cinema as $cinemas) { ?>
              <option value="<?= $cinemas['name'] ?>"><?= $cinemas['name'] ?></option>
            <?php } ?>
          </select>
        </div>

        <!-- Date -->
        <div class="col-lg-3">
          <label class="form-label text-warning small fw-bold mb-1">
            <i class="fa-regular fa-calendar-days me-1"></i> Show Date
          </label>
          <select class="form-select bg-dark text-white border-secondary rounded-3" id="bookingDateSelect" onchange="selectDate(this)">
            <?php if (count($showDates) > 0) { ?>
              <?php foreach ($showDates as $date) { ?>
                <option value="<?= $date ?>"><?= $date ?></option>
              <?php } ?>
            <?php } else { ?>
              <option value="">No show date available</option>
            <?php } ?>
          </select>
        </div>

        <!-- Time -->
        <div class="col-lg-3">
          <label class="form-label text-warning small fw-bold mb-1">
            <i class="fa-regular fa-clock me-1"></i> Showtime
          </label>
          <select class="form-select bg-dark text-white border-secondary rounded-3" id="bookingTimeSelect" onchange="selectTime(this)">
            <?php if (count($showTimes) > 0) { ?>
              <?php foreach ($showTimes as $time) { ?>
                <option value="<?= $time ?>"><?= $time ?></option>
              <?php } ?>
            <?php } else { ?>
              <option value="">No showtime available</option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-8">
        <div class="glass-card p-4 rounded-4">
          <div class="d-flex justify-content-center gap-4 small mb-4 flex-wrap">
            <div class="d-flex align-items-center gap-2"><span class="badge bg-secondary p-2 rounded-circle"></span> Available</div>
            <div class="d-flex align-items-center gap-2"><span class="badge bg-warning p-2 rounded-circle"></span> Selected</div>
            <div class="d-flex align-items-center gap-2"><span class="badge bg-danger p-2 rounded-circle"></span> Reserved</div>
          </div>

          <div class="text-center mb-5">
            <div class="cinema-screen py-2 border-bottom border-3 border-info text-info fw-bold letter-spacing-2">
              <i class="fa-solid fa-tv me-2"></i> SCREEN THIS WAY
            </div>
          </div>

          <div class="d-flex justify-content-between text-muted small px-3 mb-4 fw-bold text-center">
            <span class="text-warning"><i class="fa-solid fa-crown me-1"></i> Gold - $12</span>
            <span class="text-info"><i class="fa-solid fa-gem me-1"></i> Platinum - $18</span>
            <span class="text-light"><i class="fa-solid fa-star me-1"></i> VIP - $25</span>
          </div>

          <div id="seatGridContainer" class="py-2 d-flex flex-column align-items-center gap-2"></div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="glass-card p-4 rounded-4 text-white">
          <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-secondary mb-3">
            <h5 class="fw-bold mb-0 text-warning"><i class="fa-solid fa-receipt me-2"></i> Summary</h5>
            <span class="badge bg-warning text-dark fs-6 rounded-pill" id="summarySeatCount">0 Seats</span>
          </div>

          <div class="mb-3">
            <small class="text-muted">Plan:</small>
            <div class="fw-bold text-warning" id="summaryPlanName"><?= $selectedPlan['name'] ?></div>
          </div>

          <div class="mb-3">
            <small class="text-muted">Price Per Ticket:</small>
            <div class="fw-bold text-light">$<span id="summaryPlanPrice"><?= $selectedPlan['price'] ?></span></div>
          </div>

          <div class="mb-3">
            <small class="text-muted">Show Date:</small>
            <div class="fw-semibold text-light" id="summaryShowDate">
              <?= count($showDates) > 0 ? $showDates[0] : 'N/A' ?>
            </div>
          </div>

          <div class="mb-3">
            <small class="text-muted">Showtime:</small>
            <div class="fw-semibold text-light" id="summaryShowTime">
              <?= count($showTimes) > 0 ? $showTimes[0] : 'N/A' ?>
            </div>
          </div>

          <label class="small fw-bold text-light mb-1">Selected Seats:</label>
          <div id="selectedSeatsChips" class="my-2 d-flex flex-wrap gap-1">
            <span class="text-muted small italic">No seats selected yet.</span>
          </div>

          <div class="p-3 bg-dark bg-opacity-50 rounded-3 border border-secondary my-3">
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox" role="switch" id="kidsConcessionCheck" onchange="handleKidsDiscountToggle(this)">
              <label class="form-check-label fw-bold small text-light" for="kidsConcessionCheck">
                <i class="fa-solid fa-child text-warning me-1"></i> Kids Discount (20% Off)
              </label>
            </div>
          </div>

          <div class="mt-3 pt-2">
            <div class="d-flex justify-content-between small mb-2 text-light">
              <span>Total Tickets Subtotal:</span>
              <span class="fw-bold fs-6" id="summarySubtotal">$0.00</span>
            </div>
            <div class="d-flex justify-content-between text-warning small mb-2 d-none" id="summaryDiscountRow">
              <span>Kids Discount Applied:</span>
              <span class="fw-bold" id="summaryDiscountAmount">-$0.00</span>
            </div>
            <div class="d-flex justify-content-between small mb-2 text-light">
              <span>Tax & Service Fee (5%):</span>
              <span class="fw-semibold" id="summaryServiceFee">$0.00</span>
            </div>
            <hr class="border-secondary">
            <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
              <span>Grand Total:</span>
              <span class="text-warning fs-3" id="summaryGrandTotal">$0.00</span>
            </div>

            <button class="btn btn-warning w-100 py-3 fw-bold rounded-3 shadow" id="btnProceedCheckout" data-bs-toggle="modal" data-bs-target="#checkoutPaymentModal" disabled>
              <i class="fa-solid fa-credit-card me-2"></i> Proceed to Payment
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Kids Modal -->
<div class="modal fade" id="kidsCountModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content glass-card text-white border-warning">
      <div class="modal-header border-bottom border-secondary">
        <h6 class="modal-title fw-bold text-warning"><i class="fa-solid fa-child me-2"></i> How many kids?</h6>
        <button type="button" class="btn-close btn-close-white" onclick="cancelKidsDiscount()"></button>
      </div>
      <div class="modal-body text-center p-4">
        <p class="small text-muted mb-3">Select how many kids are attending (20% Off per kid ticket):</p>
        <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap" id="kidsCountButtons">
          <?php for ($i = 1; $i <= 6; $i++) { ?>
            <button type="button" class="btn btn-outline-warning fw-bold px-3" onclick="applyKidsCount(<?= $i ?>)"><?= $i ?></button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="checkoutPaymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content glass-card text-white">
      <div class="modal-header border-bottom border-secondary">
        <h5 class="modal-title fw-bold text-warning"><i class="fa-solid fa-lock me-2"></i> Secure Payment</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form onsubmit="handlePayment(event)">
          <div class="mb-3">
            <label class="form-label small fw-bold">Cardholder Name</label>
            <input type="text" class="form-control bg-dark text-white border-secondary" required>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-bold">Card Number</label>
            <input type="text" class="form-control bg-dark text-white border-secondary" required>
          </div>
          <button type="submit" class="btn btn-warning w-100 py-3 fw-bold rounded-3 mt-2">Pay Now & Generate Ticket</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Ticket Modal -->
<div class="modal fade" id="ticketConfirmationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content bg-dark text-white border border-warning rounded-4 p-2">
      <div class="modal-body p-4" id="printableTicket">
        <div class="ticket-card p-4 rounded-4 position-relative">
          <div class="text-center border-bottom border-secondary pb-3 mb-3">
            <h3 class="fw-black text-warning mb-0"><i class="fa-solid fa-film me-2"></i> CINEMA TICKET</h3>
            <small class="text-muted">Booking ID: #CNM-<?php echo rand(10000, 99999); ?></small>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-12">
              <span class="text-muted small">Plan:</span>
              <h5 class="fw-bold text-warning mb-0" id="ticketPlan"><?= $selectedPlan['name'] ?></h5>
            </div>
            <div class="col-6 mt-2">
              <span class="text-muted small">Theater:</span>
              <p class="fw-semibold text-light mb-0" id="ticketHall">-</p>
            </div>
            <div class="col-6 mt-2">
              <span class="text-muted small">Show Date:</span>
              <p class="fw-semibold text-light mb-0" id="ticketDate">-</p>
            </div>
            <div class="col-6 mt-2">
              <span class="text-muted small">Showtime:</span>
              <p class="fw-semibold text-light mb-0" id="ticketTime">-</p>
            </div>
            <div class="col-6 mt-2">
              <span class="text-muted small">Selected Seats:</span>
              <p class="fw-bold text-warning mb-0" id="ticketSeats">-</p>
            </div>
            <div class="col-12 mt-2">
              <span class="text-muted small">Total Paid:</span>
              <p class="fw-bold text-success mb-0" id="ticketAmount">$0.00</p>
            </div>
          </div>

          <div class="text-center pt-3 border-top border-secondary">
            <i class="fa-solid fa-qrcode display-4 text-white mb-2"></i>
            <p class="small text-muted mb-0">Scan this QR code at the entrance</p>
          </div>
        </div>

        <div class="mt-4 text-center no-print d-flex gap-2">
          <button class="btn btn-warning w-100 fw-bold" onclick="window.print()"><i class="fa-solid fa-print me-1"></i> Print / Save PDF</button>
          <button class="btn btn-outline-light w-100" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .page-banner {
    background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.6) 100%), url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=1200') center/cover;
    padding: 50px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  }

  .glass-card {
    background: rgba(30, 41, 59, 0.7) !important;
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
  }

  .cinema-screen {
    background: linear-gradient(180deg, rgba(56, 189, 248, 0.3) 0%, rgba(0,0,0,0) 100%);
    box-shadow: 0 -10px 25px rgba(56, 189, 248, 0.3);
    border-radius: 50% / 20px;
  }

  .seat-btn {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .seat-btn:hover { transform: scale(1.15); }

  .ticket-card {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border: 2px dashed #f59e0b;
  }

  @media print {
    body * { visibility: hidden; }
    #printableTicket, #printableTicket * { visibility: visible; }
    #printableTicket {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      color: #000 !important;
      background: #fff !important;
    }
    .no-print { display: none !important; }
  }
</style>

<?php include_once "includes/footer.php"; ?>

<script>
  const rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
  const seatsPerRow = 8;
  let selectedSeats = [];
  let kidsCount = 0;
  let currentPlan = <?= json_encode($plan) ?>;
  let currentPlanPrice = <?= (float)$selectedPlan['price'] ?>;

  const plans = <?= json_encode($plans) ?>;

  function changePlan(plan) {
    currentPlan = plan;
    currentPlanPrice = Number(plans[plan].price);

    document.getElementById('selectedPlanName').innerText = plans[plan].name;
    document.getElementById('planPrice').innerText = currentPlanPrice;
    document.getElementById('summaryPlanName').innerText = plans[plan].name;
    document.getElementById('summaryPlanPrice').innerText = currentPlanPrice;
    document.getElementById('ticketPlan').innerText = plans[plan].name;

    updateCalculations();
  }

  function getSeatPrice() {
    return currentPlanPrice;
  }

  function renderSeats() {
    const container = document.getElementById('seatGridContainer');
    container.innerHTML = '';

    rows.forEach(row => {
      const rowDiv = document.createElement('div');
      rowDiv.className = 'd-flex gap-2 align-items-center mb-1';

      const label = document.createElement('span');
      label.className = 'text-warning fw-bold me-2';
      label.style.width = '20px';
      label.innerText = row;
      rowDiv.appendChild(label);

      for (let i = 1; i <= seatsPerRow; i++) {
        const seatId = `${row}${i}`;
        const btn = document.createElement('button');
        const isSelected = selectedSeats.includes(seatId);
        btn.className = `btn seat-btn ${isSelected ? 'btn-warning text-dark' : 'btn-outline-secondary text-white'}`;
        btn.innerText = i;
        btn.onclick = () => toggleSeat(seatId);
        rowDiv.appendChild(btn);
      }

      container.appendChild(rowDiv);
    });
  }

  function toggleSeat(seatId) {
    if (selectedSeats.includes(seatId)) {
      selectedSeats = selectedSeats.filter(s => s !== seatId);
    } else {
      if (selectedSeats.length >= 8) {
        alert('Maximum 8 seats allowed per booking.');
        return;
      }
      selectedSeats.push(seatId);
    }

    if (kidsCount > selectedSeats.length) {
      kidsCount = selectedSeats.length;
      if (kidsCount === 0) {
        document.getElementById('kidsConcessionCheck').checked = false;
      }
    }

    renderSeats();
    updateCalculations();
  }

  function handleKidsDiscountToggle(checkbox) {
    if (selectedSeats.length === 0) {
      alert("Please select seats on the grid first.");
      checkbox.checked = false;
      return;
    }

    if (checkbox.checked) {
      const kidsModal = new bootstrap.Modal(document.getElementById('kidsCountModal'));
      kidsModal.show();
    } else {
      kidsCount = 0;
      updateCalculations();
    }
  }

  function cancelKidsDiscount() {
    document.getElementById('kidsConcessionCheck').checked = false;
    kidsCount = 0;
    const modalEl = document.getElementById('kidsCountModal');
    const modalInstance = bootstrap.Modal.getInstance(modalEl);
    if (modalInstance) modalInstance.hide();
    updateCalculations();
  }

  function applyKidsCount(count) {
    if (count > selectedSeats.length) {
      alert(`You have selected ${selectedSeats.length} seat(s) in total. Please select at least ${count} seats on the grid first.`);
      return;
    }

    kidsCount = count;
    const modalEl = document.getElementById('kidsCountModal');
    const modalInstance = bootstrap.Modal.getInstance(modalEl);
    if (modalInstance) modalInstance.hide();
    updateCalculations();
  }

  function updateCalculations() {
    const chips = document.getElementById('selectedSeatsChips');
    const countBadge = document.getElementById('summarySeatCount');
    const checkoutBtn = document.getElementById('btnProceedCheckout');

    countBadge.innerText = `${selectedSeats.length} Seats`;

    if (selectedSeats.length === 0) {
      chips.innerHTML = `<span class="text-muted small italic">No seats selected yet.</span>`;
      checkoutBtn.disabled = true;
      document.getElementById('kidsConcessionCheck').checked = false;
      kidsCount = 0;
    } else {
      chips.innerHTML = selectedSeats.map(s => `<span class="badge bg-warning text-dark">${s}</span>`).join(' ');
      checkoutBtn.disabled = false;
    }

    const fullSubtotal = selectedSeats.length * getSeatPrice();
    let discount = 0;

    if (document.getElementById('kidsConcessionCheck').checked && kidsCount > 0) {
      const applicableKids = Math.min(kidsCount, selectedSeats.length);
      discount = applicableKids * getSeatPrice() * 0.20;
    }

    const discountRow = document.getElementById('summaryDiscountRow');

    if (discount > 0) {
      discountRow.classList.remove('d-none');
      const adultSeatsCount = selectedSeats.length - kidsCount;
      document.getElementById('summaryDiscountAmount').innerText = `-$${discount.toFixed(2)} (${kidsCount} Kids, ${adultSeatsCount} Adult)`;
    } else {
      discountRow.classList.add('d-none');
    }

    const discountedSubtotal = fullSubtotal - discount;
    const serviceFee = discountedSubtotal * 0.05;
    const grandTotal = discountedSubtotal + serviceFee;

    document.getElementById('summarySubtotal').innerText = `$${fullSubtotal.toFixed(2)}`;
    document.getElementById('summaryServiceFee').innerText = `$${serviceFee.toFixed(2)}`;
    document.getElementById('summaryGrandTotal').innerText = `$${grandTotal.toFixed(2)}`;
  }

  function selectDate(select) {
    document.getElementById('summaryShowDate').innerText = select.value || 'N/A';
  }

  function selectTime(select) {
    document.getElementById('summaryShowTime').innerText = select.value || 'N/A';
  }

  function handlePayment(e) {
    e.preventDefault();

    document.getElementById('ticketPlan').innerText = plans[currentPlan].name;
    document.getElementById('ticketHall').innerText = document.getElementById('bookingTheaterSelect').value;
    document.getElementById('ticketDate').innerText = document.getElementById('bookingDateSelect').value;
    document.getElementById('ticketTime').innerText = document.getElementById('bookingTimeSelect').value;
    document.getElementById('ticketSeats').innerText = selectedSeats.join(', ');
    document.getElementById('ticketAmount').innerText = document.getElementById('summaryGrandTotal').innerText;

    const payModal = bootstrap.Modal.getInstance(document.getElementById('checkoutPaymentModal'));
    payModal.hide();

    const ticketModal = new bootstrap.Modal(document.getElementById('ticketConfirmationModal'));
    ticketModal.show();
  }

  document.addEventListener('DOMContentLoaded', () => {
    renderSeats();
    updateCalculations();
  });
</script>
