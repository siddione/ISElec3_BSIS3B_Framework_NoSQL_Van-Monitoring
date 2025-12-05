<?php  
session_start();
session_regenerate_id(true);

if (!isset($_SESSION['driver_id']) || $_SESSION['is_approved'] !== 'approved') {
    header("Location: driver_login.php");
    exit;
}

include 'dbconnection.php';

$driver_id = $_SESSION['driver_id'];

try {
    $stmt = $pdo->prepare("
        SELECT d.name, d.license_number, d.profile_picture, v.plate_number
        FROM drivers d
        LEFT JOIN vans v ON d.driver_id = v.driver_id
        WHERE d.driver_id = :driver_id
    ");
    $stmt->bindParam(':driver_id', $driver_id, PDO::PARAM_INT);
    $stmt->execute();

    $driver = $stmt->fetch(PDO::FETCH_ASSOC) ?: [
        'name' => 'Unknown',
        'license_number' => 'Unknown',
        'plate_number' => 'Unknown',
        'profile_picture' => ''
    ];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

$profilePictureFile = (!empty($driver['profile_picture']) && file_exists('uploads/' . $driver['profile_picture']))
    ? 'uploads/' . htmlspecialchars($driver['profile_picture'])
    : 'uploads/driver.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Driver Homepage - UV Express</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
    }

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

    .menu a, .menu div {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      text-decoration: none;
      color: #333;
      border-bottom: 1px solid #ddd;
      font-weight: 500;
    }

    .menu a:hover, .menu div:hover {
      background-color: #00b050;
      color: white;
    }

    .menu img {
      width: 30px;
      margin-right: 12px;
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
      margin: 0;
      font-weight: 700;
    }

    .navbar-subtitle {
      margin-top: 5px;
      font-weight: 500;
      font-size: 20px;
      color: black;
      letter-spacing: 15px;
      text-align: center;
      word-break: break-word;
      white-space: normal;
    }

    @media (max-width: 768px) {
      .navbar-title-row img {
        height: 40px;
      }

      .navbar-title-row h2 {
        font-size: 28px;
        font - weight: 400;
      }

      .navbar-subtitle {
        font-size: 14px;
        letter-spacing: 10px;
        margin-top: 6px;
      }
    }

    .main-content {
      margin-top: 180px;
    }

    .van-container {
      height: 100%;
      background: linear-gradient(to right, #e0f7fa, #ffffff);
      border-radius: 15px;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .van {
      height: 120px;
      animation: idleVan 2s ease-in-out infinite alternate;
    }

    @media (min-width: 769px) {
      .van {
        height: 400px;
      }
    }

    @keyframes idleVan {
      0% { transform: translateX(0); }
      100% { transform: translateX(10px); }
    }

    .van-text {
      position: absolute;
      bottom: 10px;
      width: 100%;
      text-align: center;
      color: #2e7d32;
      font-weight: bold;
      font-size: 20px;
    }

    .profile-pic {
      width: 170px;
      height: 170px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      margin-bottom: 20px;
    }

    .btn-custom {
      background: linear-gradient(135deg, #00b050, #00703c);
      color: white;
      font-size: 18px;
      font-weight: 600;
      padding: 12px 30px;
      border-radius: 12px;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background: linear-gradient(135deg, #009245, #005c2a);
      transform: scale(1.05);
    }

    .modal-footer button {
      width: 100px;
      font-weight: 500;
    }

    .card-header {
      font-weight: 600;
      font-size: 20px;
    }

    @media (max-width: 768px) {
      .profile-pic {
        width: 130px;
        height: 130px;
      }
    }
    @media (max-width: 768px) {
  .menu-icon {
    margin-left: 10px !important; 
  }
}

  </style>
</head>
<body>

<div class="top-banner">
  <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>

  <div class="navbar-title">
    <div class="navbar-title-row">
      <img src="car.png" alt="Car Icon" />
      <h2>UV EXPRESS</h2>
    </div>
    <div class="navbar-subtitle">POLANGUI - LEGAZPI</div>
  </div>
</div>

<div id="menu" class="menu">
  <div onclick="showHomeModal()"><img src="home.png" alt="Home">Home</div>
  <a href="myprofile.php"><img src="profile.png" alt="Profile">My Profile</a>
  <a href="about.php"><img src="us.png" alt="About">About Us</a>
  <div onclick="showLogoutModal()"><img src="out.png" alt="Logout">Logout</div>
</div>

<div class="container main-content">
  <div class="row g-4">
    <div class="col-lg-6 d-flex">
      <div class="card w-100 shadow">
        <div class="card-header bg-success text-white text-center fw-semibold">
          Van is getting ready...
        </div>
        <div class="card-body d-flex justify-content-center align-items-center p-4">
          <div class="van-container w-100">
            <img src="van.png" class="van" alt="Van">
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6 d-flex">
      <div class="card w-100 shadow d-flex flex-column align-items-center justify-content-center p-4">
        <img src="<?php echo $profilePictureFile; ?>" class="profile-pic" alt="Profile Picture">
        <h3 class="text-success fw-bold mb-2">Welcome, <?php echo htmlspecialchars($driver['name']); ?>!</h3>
        <p class="text-muted mb-3 fs-5">Ready for today's trip?</p>

        <div class="bg-light rounded p-3 w-100 mb-4">
          <p class="mb-2"><strong>Driver Name:</strong> <?php echo htmlspecialchars($driver['name']); ?></p>
          <p class="mb-2"><strong>Plate Number:</strong> <?php echo htmlspecialchars($driver['plate_number']); ?></p>
          <p class="mb-0"><strong>License Number:</strong> <?php echo htmlspecialchars($driver['license_number']); ?></p>
        </div>

        <a href="driver_van.php" class="btn btn-custom">Update My Van</a>
      </div>
    </div>
  </div>
</div>

<!-- Logout Modal -->
<div id="logoutModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center p-4" style="border-radius: 16px;">
      <div class="modal-body">
        <p class="fw-none fs-5 mb-0">Are you sure you want to logout?</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
          <button type="button" class="btn btn-secondary px-4" onclick="closeLogoutModal()">No</button>
          <button type="button" class="btn btn-success px-4" onclick="confirmLogout()">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Home Modal -->
<div id="homeModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center p-4" style="border-radius: 16px;">
      <div class="modal-body">
        <p class="fw-none fs-5 mb-0">This will log you out. Do you want to continue?</p>
        <div class="d-flex justify-content-center gap-3 mt-4">
          <button type="button" class="btn btn-secondary px-4" onclick="closeHomeModal()">No</button>
          <button type="button" class="btn btn-success px-4" onclick="confirmHome()">Yes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function toggleMenu() {
  const menu = document.getElementById("menu");
  menu.style.display = menu.style.display === "block" ? "none" : "block";
}

function showLogoutModal() {
  new bootstrap.Modal(document.getElementById('logoutModal')).show();
}

function closeLogoutModal() {
  bootstrap.Modal.getInstance(document.getElementById('logoutModal')).hide();
}

function confirmLogout() {
  window.location.href = "login.php";
}

function showHomeModal() {
  new bootstrap.Modal(document.getElementById('homeModal')).show();
}

function closeHomeModal() {
  bootstrap.Modal.getInstance(document.getElementById('homeModal')).hide();
}

function confirmHome() {
  window.location.href = "index.php";
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
