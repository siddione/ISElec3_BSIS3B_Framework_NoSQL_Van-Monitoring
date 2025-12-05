<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Panel - Driver Approvals</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f0f0f0;
      margin: 0;
      padding: 0;
      position: relative;
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
      line-height: 1.2;
      margin-left: 30px;
    }

    .navbar-title h2 {
      font-size: 30px;
      margin: 0;
      font-weight: bold;
      color: white;
      letter-spacing: 1px;
    }

    .navbar-title p {
      font-size: 15px;
      letter-spacing: 5px;
      color: black;
      margin: 0;
      margin-left: 30px;
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
      margin: 20px 0 10px;
      font-size: 35px;
      font-weight: 600;
      color: #333;
    }

    .table-container {
      width: 100%;
      overflow-x: auto;
      position: relative;
      background-color: transparent;
      z-index: 1;
    }

    table {
      width: 60%;
      min-width: 900px;
      margin: 10px auto 40px;
      border-collapse: collapse;
      background: transparent;
      font-size: 14px;
      z-index: 1;
      position: relative;
    }

    th, td {
      padding: 8px 15px;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background-color: #00b050;
      color: white;
    }

    .btn {
      padding: 10px 20px;
      min-width: 100px;
      display: inline-block;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      color: white;
      font-size: 14px;
      margin: 5px;
      box-sizing: border-box;
      text-align: center;
      font-weight:none;
    }

    .approve {
      background-color: #28a745;
    }

    .reject {
      background-color: #dc3545;
    }

    .action-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .logo-footer {
      display: none;
    }

    @media (max-width: 768px) {
      .main-title {
        font-size: 28px;
      }

      .table-container {
        padding: 0 10px;
      }
    }

    @media (max-width: 480px) {
      .main-title {
        font-size: 25px;
      }

      .burger {
        font-size: 22px;
      }
    }

    /* Logout Modal Styling */
    #logoutModal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 3000;
      justify-content: center;
      align-items: center;
    }

    #logoutModal .modal-content {
      background-color: white;
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      max-width: 300px;
      width: 90%;
    }

    #logoutModal .modal-content p {
      font-weight: 500;
      margin-bottom: 20px;
      font-size: 16px;
    }

    #logoutModal .modal-buttons {
      display: flex;
      justify-content: space-between;
    }

    #logoutModal .modal-buttons button {
      flex: 1;
      margin: 0 5px;
      padding: 10px 0;
      font-weight: 600;
      border: none;
      border-radius: 5px;
      color: white;
      cursor: pointer;
    }

    #logoutModal .modal-buttons .yes {
      background-color:rgba(32, 145, 28, 0.8);
    }
  
    #logoutModal .modal-buttons .no {
      background-color: #6c757d;
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
      <a href="adminpanel2.php"><img src="approve.png" alt="Approved Icon"> Approved Drivers</a>
      <a href="about.php"><img src="us.png" alt="About Icon"> About Us</a>
      <a href="#" onclick="openLogoutModal()"><img src="out.png" alt="Logout Icon"> Logout</a>
    </div>

    <button class="burger" onclick="toggleBurgerMenu()">☰</button>

    <div id="burgerMenu" class="burger-menu">
      <a href="adminhomepage.php"><img src="home.png" alt="Home Icon"> Home</a>
      <a href="adminpanel2.php"><img src="approve.png" alt="Approved Icon"> Approved Drivers</a>
      <a href="about.php"><img src="us.png" alt="About Icon"> About Us</a>
      <a href="#" onclick="openLogoutModal()"><img src="out.png" alt="Logout Icon"> Logout</a>
    </div>
  </div>

  <!-- Logout Modal -->
  <div id="logoutModal">
    <div class="modal-content">
      <p>Are you sure you want to logout?</p>
      <div class="modal-buttons">
        <button class="yes" onclick="confirmLogout()">Yes</button>
        <button class="no" onclick="closeLogoutModal()">No</button>
      </div>
    </div>
  </div>

  <!-- Main Title -->
  <h2 class="main-title">Admin Panel - Driver Approvals</h2>

  <!-- Driver Table -->
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Contact Number</th>
          <th>License Number</th>
          <th>Plate Number</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="driverTable">
        <!-- Driver rows will be populated here -->
      </tbody>
    </table>
  </div>

  <!-- Script -->
  <script>
    fetch("get_drivers.php")
      .then(res => res.json())
      .then(drivers => {
        const driverTable = document.getElementById("driverTable");

        drivers.forEach(driver => {
          const row = document.createElement("tr");
          row.id = `row-${driver.driver_id}`;

          row.innerHTML = `
            <td>${driver.name}</td>
            <td>${driver.username}</td>
            <td>${driver.email}</td>
            <td>${driver.contact_number}</td>
            <td>${driver.license_number}</td>
            <td>${driver.plate_number}</td>
            <td id="status-${driver.driver_id}">${driver.is_approved}</td>
            <td class="action-buttons">
              <button class="btn approve" onclick="updateStatus(${driver.driver_id}, 'approved')">Approve</button>
              <button class="btn reject" onclick="updateStatus(${driver.driver_id}, 'rejected')">Reject</button>
            </td>`;

          driverTable.appendChild(row);
        });
      });

    function updateStatus(id, newStatus) {
      fetch("update_driver_status.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}&status=${newStatus}`
      })
      .then(res => res.json())
      .then(() => {
        const row = document.getElementById(`row-${id}`);
        if (row) row.remove();
        alert(`Driver ID ${id} has been ${newStatus}.`);
      });
    }

    function toggleBurgerMenu() {
      const menu = document.getElementById('burgerMenu');
      menu.classList.toggle('show');
    }

    document.addEventListener('click', function (event) {
      const menu = document.getElementById('burgerMenu');
      const burger = document.querySelector('.burger');
      if (!menu.contains(event.target) && !burger.contains(event.target)) {
        menu.classList.remove('show');
      }
    });

    function openLogoutModal() {
      document.getElementById("logoutModal").style.display = "flex";
    }

    function closeLogoutModal() {
      document.getElementById("logoutModal").style.display = "none";
    }

    function confirmLogout() {
      window.location.href = "adminlogin.php";
    }
  </script>

</body>
</html>
