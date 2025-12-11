<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Driver Login - UV Express</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Poppins';
      background: #f5f5f5;
      overflow-x: hidden;
      padding-top: 0px;
    }

    .top-banner {
      background-color: #00b050;
      width: 100%;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 10;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
    }

    .menu-icon {
      font-size: 28px;
      cursor: pointer;
      color: black;
    }

    .menu {
      display: none;
      position: absolute;
      top: 100px;
      left: 30px;
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      overflow: hidden;
      z-index: 1000;
      width: 250px;
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
      width: 80px;
      height: 50px;
      object-fit: contain;
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
      position: relative;
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
    }

    .navbar-subtitle {
      margin-top: 5px;
      font-weight: 400;
      color: black;
      font-size: 20px;
      letter-spacing: 10px;
      text-align: center;
      word-break: break-word;
      white-space: normal;
    }

    .main-title {
      text-align: center;
      margin-top: 160px;
      font-size: 30px;
    }

    .login-container {
      max-width: 600px;
      margin: 30px auto;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .login-container img {
      height: 100px;
      margin-bottom: 10px;
    }

    .login-container label {
      display: block;
      text-align: left;
      margin-bottom: 8px;
      font-weight: 500;
      color: #333;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    .login-container button {
      width: 100%;
      padding: 12px;
      background-color: #00b050;
      border: none;
      color: white;
      font-size: 18px;
      border-radius: 6px;
      cursor: pointer;
    }

    .login-container button:hover {
      background-color: #009442;
    }

    .register-link {
      margin-top: 15px;
      font-size: 16px;
      color: black;
    }

    .register-link a {
      text-decoration: underline;
      color: #000;

    }

    .register-link a:hover {
      text-decoration: bold;
    }

    .error-message {
      color: red;
      margin-bottom: 15px;
      font-size: 16px;
      font-weight: none;
    }

    .show-password {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
      font-size: 14px;
    }

    /* Responsive Adjustments */
    @media (max-width: 700px) {
      .navbar-title-row {
        flex-direction: column;
        gap: 5px;
      }

      .navbar-title-row img {
        height: 40px;
      }

      .navbar-title-row h2 {
        font-size: 24px;
      }

      .navbar-subtitle {
        font-size: 14px;
        letter-spacing: 4px;
        margin-top: 2px;
      }

      .main-title {
        font-size: 22px;
        margin-top: 130px;
      }

      .login-container {
        margin: 15px;
        padding: 20px;
      }

      .login-container img {
        height: 80px;
      }

      .login-container input {
        font-size: 15px;
      }

      .login-container button {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

<!-- Green Navbar -->
<div class="top-banner">
  <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>

  <div id="menu" class="menu">
    <a href="index.php"><img src="home.png" alt="Home Icon"> Home</a>
    <a href="driver_register.php"><img src="reg.png" alt="Register Icon"> Register</a>
    <a href="monitor.php"><img src="mon.png" alt="Monitor Icon"> Monitor Now</a>
    <a href="about.php"><img src="us.png" alt="About Us Icon"> About Us</a>
  </div>

  <div class="navbar-title">
    <div class="navbar-title-row">
      <img src="car.png" alt="Car Icon" />
      <h2>UV EXPRESS</h2>
    </div>
    <div class="navbar-subtitle">POLANGUI - LEGAZPI</div>
  </div>
</div>

<!-- Main Title -->
<h2 class="main-title">Driver Login</h2>

<!-- Login Form -->
<div class="login-container">
  <img src="logovan.png" alt="UV Express Logo" />

  <?php
    if (isset($_GET['error']) && $_GET['error'] == 1) {
      echo '<div class="error-message">Incorrect username or password. Please try again.</div>';
    }
  ?>

  <form method="POST" action="driver_login.php">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <div class="show-password">
      <input type="checkbox" id="showPassword" onclick="togglePassword()"> Show Password
    </div>

    <button type="submit">Login</button>
  </form>

  <div class="register-link">
    Don't have an account? <a href="driver_register.php">Register here</a>
  </div>
</div>

<script>
  function toggleMenu() {
    var menu = document.getElementById('menu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
  }

  function togglePassword() {
    var passwordField = document.getElementById('password');
    passwordField.type = passwordField.type === "password" ? "text" : "password";
  }
</script>

</body>
</html>
