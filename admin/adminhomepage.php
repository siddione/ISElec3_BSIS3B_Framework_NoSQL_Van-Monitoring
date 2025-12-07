<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Panel - UV Express</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      background-color: white;
      overflow-x: hidden;
    }

    .uv-header {
      background-color: #00b14f;
      color: white;
      padding: 20px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
    }

    .uv-title {
      text-align: center;
    }

    .uv-title h1 {
      font-size: 30px;
      font-weight: bold;
      margin: 0;
    }

    .uv-title p {
      font-size: 15px;
      letter-spacing: 5px;
      color: black;
      margin: 0;
    }

    .navbar-links {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .navbar-btn {
      color: black;
      font-size: 14px;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .navbar-btn:hover {
      color: rgba(0, 255, 106, 0.84);
    }

    .burger-icon {
      display: none;
      color: black;
      font-size: 24px;
      cursor: pointer;
    }

    .dropdown-menu-custom {
      display: none;
      position: absolute;
      right: 20px;
      top: 70px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      z-index: 1000;
      min-width: 200px;
      padding: 10px 0;
      flex-direction: column;
    }

    .dropdown-menu-custom a {
     display: flex;
      align-items: center;
      padding: 10px;
      justify-content: flex-start; 
      color: #333;
      text-decoration: none;
      border-bottom: 1px solid #eee;
      font-weight: 500;
      gap: 10px;
    }

    .dropdown-menu-custom a img {
       height: 30px;
      width: 30px;
      flex-shrink: 0;
      object-fit: contain;
    }

    .dropdown-menu-custom a:hover {
      background-color: #00b14f;
      color: white;
    }

    .dropdown-menu-custom hr {
      margin: 0;
      border: none;
      border-top: 1px solid #ddd;
    }

    .main-content {
      flex: 1;
      display: flex;
      padding: 40px;
      gap: 30px;
      margin: 20px;
    }

    .left, .right {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
      padding: 30px;
      border-radius: 20px;
      background: white;
      box-shadow: 0 0 15px rgba(0, 177, 79, 0.3);
      overflow: hidden;
      transition: 0.3s;
    }

    .left:hover, .right:hover {
      box-shadow: 0 0 25px rgba(0, 177, 79, 0.5);
    }

    .left img {
      width: 350px;
      margin-bottom: 8px;
    }

    .left h1 {
      font-size: 60px;
      font-weight:bold;
      color: #00b14f;
      margin-bottom: -0px;
    }

    .left h2 {
      font-size: 36px;
      letter-spacing: 4px;
      color: #333;
      margin-top: 12px;
      margin-bottom: 20px;
    }

    .left p {
      font-size: 24px;
      font-weight: bold;
      color: #00b14f;
      text-align: center;
    }

    .right img {
      height: 150px;
      margin-bottom: 20px;
    }

    .card-panel {
      width: 100%;
      max-width: 350px;
      text-align: center;
    }

    .admin-btn {
      width: 100%;
      background-color: #00b14f;
      border: none;
      color: white;
      font-size: 16px;
      padding: 14px;
      border-radius: 30px;
      margin: 10px 0;
      transition: 0.3s;
      text-decoration: none;
      display: block;
    }

    .admin-btn:hover {
      background-color: #019243;
      transform: scale(1.03);
    }

    .dot, .circle {
      position: absolute;
      border-radius: 50%;
      z-index: 0;
      transition: 0.3s ease;
    }

    .dot1 { width: 30px; height: 30px; background: orange; top: 8%; left: 5%; }
    .dot2 { width: 40px; height: 40px; background: pink; bottom: 12%; left: 12%; }
    .dot3 { width: 35px; height: 35px; background: lightblue; bottom: 8%; right: 8%; }

    .yellow { width: 30px; height: 30px; background: orange; top: 20%; right: 12%; }
    .green  { width: 40px; height: 40px; background: #00b14f; bottom: 18%; left: 18%; }
    .pink   { width: 35px; height: 35px; background: #ff2e63; top: 30%; left: 30%; }

    @media (max-width: 768px) {
      .navbar-links {
        display: none;
      }

      .burger-icon {
        display: block;
      }

      .main-content {
        flex-direction: column;
        padding: 20px;
      }

      .left h2 {
        text-align: center;
      }

      .dot1, .dot2, .dot3,
      .yellow, .green, .pink {
        width: 15px !important;
        height: 15px !important;
      }
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <header class="uv-header">
    <div class="uv-title">
      <h1>UV EXPRESS ADMIN</h1>
      <p>POLANGUI - LEGAZPI</p>
    </div>
    <div class="navbar-links">
      <a href="about.php" class="navbar-btn">
        <img src="us.png" alt="About Us" height="20"> About Us
      </a>
      <a href="#" class="navbar-btn logout-link">
        <img src="out.png" alt="Logout" height="20"> Logout
      </a>
    </div>
    <div class="burger-icon" onclick="toggleDropdown()">&#9776;</div>
    <div class="dropdown-menu-custom" id="dropdownMenu">
      <a href="about.php"><img src="us.png" alt="About Icon"> About Us</a>
      <hr>
      <a href="#" class="logout-link"><img src="out.png" alt="Logout Icon"> Logout</a>
    </div>
  </header>

  <!-- Main Content -->
  <main class="main-content">
    <div class="left">
      <div class="dot dot1"></div>
      <div class="dot dot2"></div>
      <div class="dot dot3"></div>
      <img src="map.png" alt="Car Image">
      <h1>UV EXPRESS</h1>
      <h2>POLANGUI - LEGAZPI</h2>
      <p>REAL-TIME RIDES,<br>REAL-TIME PEACE OF MIND!</p>
    </div>

    <div class="right">
      <div class="circle yellow"></div>
      <div class="circle green"></div>
      <div class="circle pink"></div>
      <div class="card-panel">
        <img src="logovan.png" alt="Van Logo">
        <a href="adminpanel.php" class="admin-btn">Review Drivers</a>
        <a href="adminpanel2.php" class="admin-btn">Approved Drivers</a>
      </div>
    </div>
  </main>

  <!-- Logout Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center p-4">
        <div class="modal-body">
          <p class="fs-5 fw-none mb-4">Are you sure you want to logout?</p>
          <div class="d-flex justify-content-center gap-3">
            <a href="logout.php" class="btn btn-success px-4 py-2 w-100 fw-none" style="max-width: 120px;">Yes</a>
            <button type="button" class="btn btn-secondary px-4 py-2 w-100 fw-none" style="max-width: 120px;" data-bs-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById('dropdownMenu');
      dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    window.onclick = function(e) {
      const menu = document.getElementById('dropdownMenu');
      const burger = document.querySelector('.burger-icon');
      if (!menu.contains(e.target) && !burger.contains(e.target)) {
        menu.style.display = 'none';
      }
    }

    window.addEventListener('resize', function () {
      const dropdown = document.getElementById('dropdownMenu');
      if (window.innerWidth > 768) {
        dropdown.style.display = 'none';
      }
    });

    document.querySelectorAll('.logout-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        var modal = new bootstrap.Modal(document.getElementById('logoutModal'));
        modal.show();
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
