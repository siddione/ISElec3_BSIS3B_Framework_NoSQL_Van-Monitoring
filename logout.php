<?php
session_start();

// Destroy session to log out the user
session_unset();
session_destroy();

// Redirect to login page after logging out
header("Location: login.php");
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Logout - UV Express</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Calibri', 'Segoe UI', sans-serif;
      background: #f5f5f5;
      margin: 0;
    }

    .navbar {
      background-color: #00b050;
      padding: 25px 15px;
      text-align: center;
      color: white;
    }

    .navbar-title {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      gap: 15px;
    }

    .navbar-title img {
      height: 70px;
    }

    .navbar-title h2 {
      font-size: 38px;
      margin: 0;
    }

    h3 {
      margin: 5px 0 0;
      font-weight: 400;
      font-size: 20px;
    }

    .wide-spacing {
      letter-spacing: 15px;
    }

    .main-title {
      text-align: center;
      margin-top: 40px;
      font-size: 30px;
    }

    .logout-container {
      max-width: 600px;
      margin: 30px auto;
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .logout-container img {
      height: 80px;
      margin-bottom: 10px;
    }

    .logout-container button {
      width: 100%;
      padding: 12px;
      background-color: #00b050;
      border: none;
      color: white;
      font-size: 18px;
      border-radius: 6px;
      cursor: pointer;
    }

    .logout-container button:hover {
      background-color: #009442;
    }

    @media (max-width: 700px) {
      .logout-container {
        margin: 20px;
        padding: 25px;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="navbar-title">
      <img src="car.png" alt="Car Icon" />
      <h2>UV EXPRESS</h2>
    </div>
    <h3 class="wide-spacing">Polangui - Legazpi</h3>
  </div>

  <!-- Title -->
  <h2 class="main-title">Logging Out...</h2>

  <!-- Logout Confirmation -->
  <div class="logout-container">
    <img src="logovan.png" alt="UV Express Logo" />
    <p>You have been successfully logged out. Redirecting you to the login page...</p>
    <button onclick="window.location.href='login.php'">Go to Login Page</button>
  </div>

</body>
</html>
