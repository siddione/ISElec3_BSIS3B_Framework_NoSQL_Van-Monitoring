<?php
session_start();
?>
<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Driver Approvals - Admin Panel</title>

  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f5f5;
      margin: 0;
    }

    .navbar {
      background-color: #00b050;
      padding: 15px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: white;
      position: relative;
      flex-wrap: wrap;
    }

    .navbar-title {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 2px;
      line-height: 1.2;
    }

    .navbar-title h2 {
      font-size: 30px;
      margin: 0;
      padding-left: 30px;
      font-weight: bold;
      color: white;
      letter-spacing: 1px;
    }

    .navbar-title p {
      font-size: 15px;
      padding-left: 50px;
      letter-spacing: 5px;
      color: black;
      margin: 0;
    }

    .navbar-links {
      display: flex;
      gap: 20px;
    }

    .navbar-links a {
      color: black;
      text-decoration: none;
      font-weight: 500;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .navbar-links a img {
      height: 25px;
    }

    .navbar-links a:hover {
      color: rgba(15, 150, 56, 0.86);
    }

    .burger {
      display: none;
      cursor: pointer;
      font-size: 24px;
      background: none;
      color: black;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
    }

    .burger-menu {
      display: none;
      position: absolute;
      top: 60px;
      right: 20px;
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 10px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      z-index: 1000;
      width: 180px;
    }

    .burger-menu a {
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

    .burger-menu a:last-child {
      border-bottom: none;
    }

    .burger-menu a img {
     height: 30px;
      width: 30px;
      flex-shrink: 0;
      object-fit: contain;
    }

    .burger-menu a:hover {
      background-color: #f0f0f0;
    }

    @media (max-width: 768px) {
      .navbar-links {
        display: none;
      }

      .burger {
        display: block;
      }

      .burger-menu.show {
        display: block;
      }

      .navbar-title h2 {
        font-size: 22px;
      }

      .navbar-title p {
        font-size: 11px;
        letter-spacing: 3px;
      }
    }

    .main-title {
      text-align: center;
      margin: 30px 0;
      font-size: 35px;
      font-weight: 600;
      color: #333;
    }

    .table-container {
      width: 90%;
      max-width: 900px;
      margin: 25px auto;
      overflow-x: auto;
      background: white;
      border-radius: 8px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 350px;
    }

    th, td {
      padding: 15px 20px;
      border: 1px solid #ddd;
      text-align: center;
      font-size: 17px;
    }

    th {
      background-color: #00b050;
      color: white;
      font-size: 18px;
    }

    .logo-footer {
      text-align: center;
      padding: 40px 0 20px;
    }

    .logo-footer img {
      max-width: 100%;
      height: auto;
      opacity: 0.6;
    }

    @media (max-width: 700px) {
      .main-title {
        font-size: 26px;
      }

      th, td {
        font-size: 16px;
        padding: 12px 15px;
      }

      th {
        font-size: 17px;
      }
    }

    /* Logout Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
      background: white;
      margin: 15% auto;
      padding: 30px;
      width: 90%;
      max-width: 400px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-content h3 {
      font-size: 18px;
      color: #333;
      margin-bottom: 25px;
    }

    .modal-buttons {
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .modal-buttons button {
      padding: 10px 30px;
      font-size: 14px;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      color: white;
      transition: background 0.2s ease;
    }

    .btn-yes {
      background-color:rgba(32, 145, 28, 0.8);
    }

    .btn-yes:hover {
      background-color:rgba(32, 145, 28, 0.8);
    }

    .btn-no {
      background-color: #6c757d;
    }

    .btn-no:hover {
      background-color: #5a6268;
    }

  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="navbar-title">
      <h2>UV EXPRESS ADMIN</h2>
      <p>Polangui - Legazpi</p>
    </div>

    <div class="navbar-links">
      <a href="adminhomepage.php"><img src="home.png" alt="Home Icon"> Home</a>
      <a href="adminpanel.php"><img src="approve.png" alt="Approved Icon"> Review Drivers</a>
      <a href="about.php"><img src="us.png" alt="About Icon"> About Us</a>
      <a href="#" onclick="openLogoutModal()"><img src="out.png" alt="Logout Icon"> Logout</a>
    </div>

    <button class="burger" onclick="toggleBurgerMenu()">☰</button>

    <div id="burgerMenu" class="burger-menu">
      <a href="adminhomepage.php"><img src="home.png" alt="Home Icon"> Home</a>
      <a href="adminpanel.php"><img src="approve.png" alt="Approved Icon"> Drivers Approval</a>
      <a href="about.php"><img src="us.png" alt="About Icon"> About Us</a>
      <a href="#" onclick="openLogoutModal()"><img src="out.png" alt="Logout Icon"> Logout</a>
    </div>
  </div>

  <!-- Main Title -->
  <h2 class="main-title">Approved Drivers</h2>

  <!-- Table Section -->
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Plate Number</th>
        </tr>
      </thead>
      <tbody id="approvedDriversTable">
        <!-- Rows will be populated by JavaScript -->
      </tbody>
    </table>
  </div>

  <!-- Footer Logo -->
  <div class="logo-footer">
    <img src="logovan.png" alt="UV Express Logo">
  </div>

  <!-- Logout Modal -->
  <div id="logoutModal" class="modal">
    <div class="modal-content">
      <h3>Are you sure you want to logout?</h3>
      <div class="modal-buttons">
        <button class="btn-yes" onclick="location.href='adminlogin.php'">Yes</button>
        <button class="btn-no" onclick="closeLogoutModal()">No</button>
      </div>
    </div>
  </div>

  <!-- JS Section -->
  <script>
    fetch("get_approved_drivers.php")
      .then(res => res.json())
      .then(drivers => {
        const table = document.getElementById("approvedDriversTable");
        drivers.forEach(driver => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${driver.name}</td>
            <td>${driver.plate_number}</td>
          `;
          table.appendChild(row);
        });
      });

    function toggleBurgerMenu() {
      const menu = document.getElementById('burgerMenu');
      menu.classList.toggle('show');
    }

    function openLogoutModal() {
      document.getElementById('logoutModal').style.display = 'block';
    }

    function closeLogoutModal() {
      document.getElementById('logoutModal').style.display = 'none';
    }

    window.onclick = function(event) {
      const modal = document.getElementById('logoutModal');
      if (event.target == modal) {
        modal.style.display = 'none';
      }
    }

    document.addEventListener('click', function (event) {
      const menu = document.getElementById('burgerMenu');
      const burger = document.querySelector('.burger');
      if (!menu.contains(event.target) && !burger.contains(event.target)) {
        menu.classList.remove('show');
      }
    });
  </script>

</body>
</html>
