<?php
session_start();
include 'dbconnection.php';

if (!isset($_SESSION['driver_id'])) {
    header('Location: driver_login.php');
    exit();
}

$driver_id = $_SESSION['driver_id'];

try {
    $stmt = $pdo->prepare("
        SELECT drivers.*, vans.plate_number 
        FROM drivers 
        LEFT JOIN vans ON drivers.driver_id = vans.driver_id 
        WHERE drivers.driver_id = ?
    ");
    $stmt->execute([$driver_id]);
    $driver = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$driver) {
        echo "Driver not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM vans WHERE driver_id = ?");
        $stmt->execute([$driver_id]);

        $stmt = $pdo->prepare("DELETE FROM drivers WHERE driver_id = ?");
        $stmt->execute([$driver_id]);

        session_destroy();
        header('Location:login.php');
        exit;
    } catch (PDOException $e) {
        echo "Error deleting account: " . $e->getMessage();
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Driver Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Poppins font style (from About page) -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>

  <style>
    body {
      font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      background-color: #f9f9f9;
    }
    .main-header {
      background: linear-gradient(to bottom,rgb(5, 148, 69), #00c060);
      padding: 3rem 1rem 5rem;
      text-align: center;
      position: relative;
      height: 50vh;
      min-height: 350px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
    }
    .main-header h1 {
      font-size: 3rem;
      font-weight: bold;
      color: white;
      margin-top: 1.5rem;
    }
    .main-header small {
      display: block;
      font-size: 1.5rem;
      letter-spacing: 25px;
      color: black;
      font-weight: none;
      margin-top: 0.5rem;
    }
    .profile-wrapper {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      padding: 2rem;
      gap: 2rem;
      margin-top: -12rem;
      position: relative;
      z-index: 1;
    }
    .card-profile {
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      flex: 0 0 300px;
    }
    .card-profile img {
      width: 170px;
      height: 170px;
      border-radius: 50%;
      margin-bottom: 1rem;
      border: 5px solid black;
      object-fit: cover;
    }
    .card-profile h2 {
      font-size: 1.5rem;
      color:rgb(0, 2, 1);
      font-weight: bold;
    }
    .card-profile p {
      margin-bottom: 0.1rem;
      color: #555;
    }
    .card-info {
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      flex: 1 1 500px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem 2rem;
    }
    .card-info label {
      font-weight: 600;
      color: #333;
    }
    .card-info input {
      background-color: #f1f1f1;
      border: 1px solid #ccc;
      border-radius: 0.5rem;
      padding: 0.5rem;
      width: 100%;
    }
    .edit-button-wrapper {
      grid-column: span 2;
      text-align: right;
    }
    .edit-button-wrapper a {
      background-color: #00b050;
      color: white;
      border: none;
      border-radius: 25px;
      padding: 0.5rem 1.5rem;
      font-weight: bold;
      text-decoration: none;
    }
    .dropdown-menu {
      display: none;
      position: absolute;
      top: 100px;
      left: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      overflow: hidden;
      width: 220px;
      z-index: 200; 
    }
   .dropdown-item {
  display: flex;
  align-items: center;
  padding: 5px 10px; /* reduced from 10px 20px */
  text-decoration: none;
  color: #333;
  border-bottom: 1px solid #eee;
  gap: 3px; /* fixed invalid negative gap */
}

    .dropdown-item:last-child {
      border-bottom: none;
    }
    .dropdown-item img {
      width: 30px;
      margin-right: 12px;
    }
    .dropdown-item:hover,
    .dropdown-item:focus {
    background-color: #00b050;
    color: white;
  }
    @media (max-width: 576px) {
  .main-header h1 {
    font-size: 2rem;
    letter-spacing: 2px;
    margin-top: 1rem;
  }
  .main-header h1 img {
    height: 50px;
    margin-right: -1rem;
  }
  .main-header small {
    font-size: 1rem;
    letter-spacing: 15px;
 
  }
}

  @media (max-width: 576px) {
  .dropdown-menu {
    margin-left: 10px !important;
  }
}

  </style>
</head>
<body>
  <header class="main-header">
    <div class="d-flex justify-content-start p-3 w-100 position-absolute top-0 start-0">
  <div class="dropdown">
    <button class="btn border-0 bg-transparent shadow-none fs-3 text-black ms-2 ms-sm-3 ms-md-5"
        type="button" id="menuButton" data-bs-toggle="dropdown" aria-expanded="false">
      &#9776;
    </button>

    <ul class="dropdown-menu shadow" aria-labelledby="menuButton">
      <li><a class="dropdown-item d-flex align-items-center gap-2" href="driver_home.php"><img src="home.png" width="24"> Home</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item d-flex align-items-center gap-2" href="driver_van.php"><img src="van1.png" width="24"> My Van</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item d-flex align-items-center gap-2" href="about.php"><img src="us.png" width="24"> About Us</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><img src="out.png" width="24"> Logout</a></li>
    </ul>
  </div>
</div>

    <h1><img src="car.png" style="height: 70px; margin-right: -2rem;"> UV EXPRESS</h1>
    <small>POLANGUI - LEGAZPI</small>
  </header>

  <div class="profile-wrapper">
    <div class="card-profile">
      <?php if (!empty($driver['profile_picture'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($driver['profile_picture']); ?>" alt="Driver Image">
      <?php else: ?>
        <img src="driver.png" alt="Driver Image">
      <?php endif; ?>
      <h2><?php echo htmlspecialchars($driver['name']); ?></h2>
      <p><?php echo htmlspecialchars($driver['email']); ?></p>
      <a href="#" class="text-decoration-underline text-danger small" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Account</a>
    </div>

    <div class="card-info">
      <div><label>Name</label><input type="text" value="<?php echo htmlspecialchars($driver['name']); ?>" readonly></div>
      <div><label>Contact Number</label><input type="text" value="<?php echo htmlspecialchars($driver['contact_number']); ?>" readonly></div>
      <div><label>Username</label><input type="text" value="<?php echo htmlspecialchars($driver['username']); ?>" readonly></div>
      <div><label>License Number</label><input type="text" value="<?php echo htmlspecialchars($driver['license_number']); ?>" readonly></div>
      <div><label>Email</label><input type="text" value="<?php echo htmlspecialchars($driver['email']); ?>" readonly></div>
      <div><label>Plate Number</label><input type="text" value="<?php echo htmlspecialchars($driver['plate_number']); ?>" readonly></div>
      <div><label>Password</label><input type="password" value="********" readonly></div>
      <div class="edit-button-wrapper">
        <a href="edit_profile.php">Edit Details</a>
      </div>
    </div>
  </div>

  <!-- Delete Account Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center p-4">
        <p class="fw-none fs-5 mb-4">Delete your account permanently?</p>
        <div class="d-flex justify-content-center gap-3">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <form method="POST" action="">
            <input type="hidden" name="delete_account" value="1">
            <button type="submit" class="btn btn-danger">Yes</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Logout Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center p-4">
        <p class="fw-none fs-5 mb-4">Are you sure you want to logout?</p>
        <div class="d-flex justify-content-center gap-3">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <a href="logout.php" class="btn btn-success">Yes</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
