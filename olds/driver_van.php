<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
session_start();

if (!isset($_SESSION['driver_id']) || $_SESSION['is_approved'] !== 'approved') {
    header("Location: driver_login.php");
    exit;
}

include 'dbconnection.php';

$driver_id = $_SESSION['driver_id'];

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seats = intval($_POST['seats']);
    $status = $_POST['status'];

    if ($seats < 0) {
        $seats = 0;
    } elseif ($seats > 18) {
        $seats = 18;
    }

    try {
        $query = "UPDATE vans SET available_seats = :seats, status = :status";

        if ($status == 'traveling') {
            $query .= ", departure_time = NOW()";
        }
        if ($status == 'arrived') {
            $query .= ", arrival_time = NOW()";
        }

        $query .= " WHERE driver_id = :driver_id";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':seats' => $seats,
            ':status' => $status,
            ':driver_id' => $driver_id
        ]);

        header("Location: driver_van.php");
        exit;
    } catch (PDOException $e) {
        echo "Error updating van information.";
    }
}

try {
    $stmt = $pdo->prepare("SELECT plate_number, available_seats, status FROM vans WHERE driver_id = :driver_id LIMIT 1");
    $stmt->execute([':driver_id' => $driver_id]);
    $van = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$van) {
        echo "No van information found for this driver.";
        exit;
    }

    $initialSeats = (isset($van['available_seats']) && $van['available_seats'] > 0) ? intval($van['available_seats']) : 18;

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Driver Van Update</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Added Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: 'Poppins', sans-serif; /* Updated font */
    background-color: #f5f5f5;
    overflow-x: hidden;
}
/* --- remaining styles unchanged --- */
.top-banner {
    background-color: #00b050;
    height: 120px;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 10;
    display: flex;
    align-items: center;
    padding: 0 20px;
}
.menu-icon {
    font-size: 28px;
    cursor: pointer;
    color: black;
    margin-left: 50px;
}
.menu {
    display: none;
      position: absolute;
      top: 100px;
      left: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      overflow: hidden;
      width: 220px;
      z-index: 2000;
}
.menu a {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    text-decoration: none;
    color: #333;
    border-bottom: 1px solid #eee;
    gap: 10px;
}
.menu a img {
   width: 30px;
      margin-right: 12px;
}
.menu a:hover {
    background-color: #00b050;
    color: white;
}
.navbar-title {
    flex-grow: 1;
    text-align: center;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.navbar-title-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.navbar-title-row img {
    height: 60px;
}
.navbar-title-row h2 {
    font-size: 38px;
    font-weight: 700;
    margin: 0;
    text-align: center;
}
.navbar-subtitle {
    margin-top: 5px;
    font-weight: 400;
    font-size: 20px;
    color: black;
    letter-spacing: 15px;
    text-align: center;
}
@media (max-width: 768px) {
    .navbar-title-row h2 {
        font-size: 28px;
    }
    .navbar-subtitle {
        font-size: 14px;
        letter-spacing: 10px;
    }
    .navbar-title-row img {
        height: 40px;
    }
    .menu-icon {
        margin-left: 10px;
    }
}
@media (max-width: 480px) {
    .navbar-title-row h2 {
        font-size: 22px;
        font-weight: 400;
    }
    .navbar-subtitle {
        font-size: 12px;
        letter-spacing: 6px;
    }
    .navbar-title-row img {
        height: 30px;
    }
}
.container { display: flex; justify-content: space-between; align-items: flex-start; background: white; margin: 150px auto 30px auto; padding: 30px; border-radius: 15px; width: 90%; max-width: 1200px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
.left-side { width: 60%; text-align: center; }
.van { width: 400px; animation: drive 1s linear infinite; }
@keyframes drive { 0% { transform: translateX(0); } 100% { transform: translateX(60px); } }
.right-side { width: 35%; padding: 20px; }
.form-section { margin-bottom: 30px; }
.form-section label { font-weight: bold; font-size: 18px; display: block; margin-bottom: 10px; }
.counter { display: flex; justify-content: center; align-items: center; gap: 20px; font-size: 30px; font-weight: bold; }
.counter button { background: none; border: none; font-size: 40px; cursor: pointer; color: #00b050; }
select, .plate-number-display { width: 100%; padding: 10px; font-size: 18px; margin-top: 10px; border-radius: 8px; border: 1px solid #ccc; background: #eee; text-align: center; user-select: none; }
.update-btn { width: 100%; padding: 15px; background: #00b050; color: white; font-size: 20px; font-weight: bold; border: none; border-radius: 10px; cursor: pointer; margin-top: 20px; }
.update-btn:hover { background: #008b3d; }
@media (max-width: 768px) { .container { flex-direction: column; align-items: center; } .left-side, .right-side { width: 100%; } }
#logoutModal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); }
.modal-content {
  background: white;
  padding: 30px 20px;
  border-radius: 16px; /* Make rectangular */
  width: 350px;
  margin: auto;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.progress-container { display: flex; justify-content: space-between; align-items: center; margin-top: -15px; margin-bottom: 30px; background:rgb(241, 235, 235); padding: 15px 10px; border-radius: 10px; position: relative; width: 100%; max-width: 400px; margin-left: auto; margin-right: auto; }
.progress-step { flex: 1; text-align: center; font-size: 14px; font-weight: bold; color: green; position: relative; }
.progress-step::before { content: ''; width: 15px; height: 15px; background-color: #ccc; border-radius: 50%; display: block; margin: 0 auto 10px; position: relative; z-index: 2; }
.progress-step:not(:last-child)::after { content: ''; position: absolute; top: 14px; left: 50%; transform: translateX(0); width: 100%; height: 4px; background: #ccc; z-index: 1; }
.progress-step.active { color: #00b050; }
.progress-step.active::before { background-color: #00b050; }
.progress-step:not(:last-child)::after { top: 7px; right: -50%; width: 100%; height: 4px; background: #ccc; z-index: 0; }
.progress-step.active ~ .progress-step::before,
.progress-step.active ~ .progress-step::after { background-color: #ccc !important; }
.progress-step.active + .progress-step::after { background-color: #00b050; }
</style>
</head>
<body>
<div class="top-banner">
  <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
  <div id="menu" class="menu">
    <a href="driver_home.php"><img src="home.png"> Home</a>
    <a href="myprofile.php"><img src="profile.png"> My Profile</a>
    <a href="about.php"><img src="us.png"> About Us</a>
    <a href="#" onclick="showLogoutModal()"><img src="out.png"> Logout</a>
  </div>
  <div class="navbar-title">
    <div class="navbar-title-row">
      <img src="car.png" alt="Car Icon" />
      <h2>UV EXPRESS</h2>
    </div>
    <div class="navbar-subtitle">POLANGUI - LEGAZPI</div>
  </div>
</div>
<div class="container">
    <div class="left-side">
        <img src="van.png" alt="Van" class="van">
        <div class="progress-container">
            <div class="progress-step <?php echo ($van['status'] == 'waiting') ? 'active' : ''; ?>">Waiting</div>
            <div class="progress-step <?php echo ($van['status'] == 'traveling') ? 'active' : ''; ?>">Traveling</div>
            <div class="progress-step <?php echo ($van['status'] == 'arrived') ? 'active' : ''; ?>">Arrived</div>
            <div class="progress-step <?php echo ($van['status'] == 'parked') ? 'active' : ''; ?>">Parked</div>
        </div>
    </div>
    <div class="right-side">
        <form method="post" action="">
            <div class="form-section">
                <label>Plate Number</label>
                <div class="plate-number-display"><?php echo htmlspecialchars($van['plate_number']); ?></div>
            </div>
            <div class="form-section">
                <label>No. of Available Seats</label>
                <div class="counter">
                    <button type="button" onclick="decreaseSeats()">-</button>
                    <span id="seatCount"><?php echo $initialSeats; ?></span>
                    <button type="button" onclick="increaseSeats()">+</button>
                </div>
                <input type="hidden" name="seats" id="seatsInput" value="<?php echo $initialSeats; ?>">
            </div>
            <div class="form-section">
                <label>Status</label>
                <select name="status">
                    <option value="waiting" <?php if ($van['status'] == 'waiting') echo 'selected'; ?>>Waiting</option>
                    <option value="traveling" <?php if ($van['status'] == 'traveling') echo 'selected'; ?>>Traveling</option>
                    <option value="arrived" <?php if ($van['status'] == 'arrived') echo 'selected'; ?>>Arrived</option>
                    <option value="parked" <?php if ($van['status'] == 'parked') echo 'selected'; ?>>Parked</option>
                </select>
            </div>
            <button type="submit" class="update-btn">Update</button>
        </form>
    </div>
</div>
<div id="logoutModal">
  <div class="modal-content">
    <p style="font-size:18px; font-weight:none; margin-bottom:25px;">Are you sure you want to log out?</p>
    <div style="display:flex; justify-content:center; gap:15px;">
      <button onclick="closeLogoutModal()" style="background:#d3d3d3; padding:10px 20px; border:none; border-radius:5px; font-weight:none;">No</button>
      <button onclick="confirmLogout()" style="background:#218739; color:white; padding:10px 20px; border:none; border-radius:5px; font-weight:none;">Yes</button>
    </div>
  </div>
</div>
<script>
function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}
function showLogoutModal() {
    document.getElementById('logoutModal').style.display = 'block';
}
function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
}
function confirmLogout() {
    window.location.href = "driver_logout.php";
}
function increaseSeats() {
    let seatCount = document.getElementById('seatCount');
    let seatsInput = document.getElementById('seatsInput');
    let current = parseInt(seatCount.innerText);
    if (current < 18) {
        seatCount.innerText = current + 1;
        seatsInput.value = seatCount.innerText;
    }
}
function decreaseSeats() {
    let seatCount = document.getElementById('seatCount');
    let seatsInput = document.getElementById('seatsInput');
    let current = parseInt(seatCount.innerText);
    if (current > 0) {
        seatCount.innerText = current - 1;
        seatsInput.value = seatCount.innerText;
    }
}
window.onclick = function(event) {
    const modal = document.getElementById('logoutModal');
    if (event.target === modal) {
        modal.style.display = "none";
    }
};
</script>
</body>
</html>
