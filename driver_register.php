<?php 
session_start();
?>
<!DOCTYPE html> 
<html lang="en">
<head>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Driver Registration - UV Express</title>
  <style>
    * {
      box-sizing: border-box;
      padding: 0;
      margin: 0;
    }
    body {
      font-family: 'Poppins';
      background: #ffffff;
      overflow-x: hidden;
      padding-top: 40px;
    }
    .top-banner {
      background-color: #00b050;
      height: 70px;
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
      margin-left: 0px;
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
      font-size: 20px;
      letter-spacing: 15px;
    }
    .decorations, .decorations-2, .decorations-3, .decorations-4 {
      position: absolute;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      z-index: 0;
    }
    .decorations { top: 250px; left: 40px; background-color: orange; }
    .decorations-2 { top: 500px; left: 70px; background-color: #00b050; }
    .decorations-3 { bottom: 100px; right: 60px; background-color: #ff3366; }
    .decorations-4 { top: 70%; right: 25%; background-color: #0099ff; }
    .container {
      max-width: 1300px;
      margin: 0 auto;
      padding: 10px 20px;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      align-items: center;
      position: relative;
      z-index: 2;
    }
    .left {
      flex: 1;
      min-width: 300px;
      text-align: center;
      padding: 20px;
      z-index: 3;
      transform: translateX(-10px);
      margin-top: -80px;
    }
    .left img {
      width: 100%;
      max-width: 250px;
      height: auto;
      margin-bottom: 0px;
    }
    .left h1 {
      color: #00b050;
      font-size: 80px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .left h2 {
      font-size: 30px;
      font-weight: 600;
      letter-spacing: 10px;
      margin-bottom: 20px;
      color: black;
    }
    .left p {
      margin-top: 30px;
      font-size: 28px;
      color: #00b050;
      font-weight: bold;
    }
    .form-container {
      flex: 1;
      min-width: 350px;
      background: white;
      padding: 35px 30px;
      border-radius: 30px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.2);
      margin-top: 60px;
      text-align: center;
      z-index: 3;
    }
    .form-container form {
      display: flex;
      flex-direction: column;
    }
    .form-container input[type="text"],
    .form-container input[type="email"],
    .form-container input[type="tel"],
    .form-container input[type="password"] {
      padding: 15px;
      margin-bottom: 18px;
      border: none;
      border-radius: 30px;
      background-color: #f0f2f5;
      font-size: 16px;
      outline: none;
      text-indent: 10px;
    }
    .form-container button {
      padding: 15px;
      margin-top: 10px;
      background: #00b050;
      color: white;
      font-size: 18px;
      font-weight: bold;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .form-container button:hover {
      background: #009442;
    }
    .login-link {
      text-align: center;
      margin-top: 20px;
      font-size: 16px;
      color: #333;
    }
    .login-link a {
      color:rgb(13, 13, 13);
      font-weight: none;
      text-decoration: underline;
    }
    .login-link a:hover {
      text-decoration: underline;
    }
    @media (max-width: 900px) {
      .container {
        flex-direction: column;
      }
      .left h1 { font-size: 60px; }
      .left h2 { font-size: 24px; }
      .left p { font-size: 22px; }
    }
    @media (max-width: 768px) {
      .top-banner { height: 100px; }
      .left h1 { font-size: 50px; }
      .left h2 { font-size: 20px; letter-spacing: 5px; }
      .left p { font-size: 18px; }
      .form-container { padding: 30px 20px; }
      .decorations,
      .decorations-2,
      .decorations-3,
      .decorations-4 {
        width: 20px;
        height: 20px;
      }
    }
    @media (max-width: 500px) {
      .left h1 { font-size: 40px; }
      .form-container input,
      .form-container button {
        font-size: 15px;
        padding: 12px;
      }
      .login-link { font-size: 14px; }
    }
  </style>
</head>

<body>

  <div class="top-banner">
    <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
    <div id="menu" class="menu">
      <a href="index.php"><img src="home.png" alt="Home Icon"> Home</a>
      <a href="login.php"><img src="log.png" alt="Login Icon"> Login</a>
      <a href="monitor.php"><img src="mon.png" alt="Monitor Icon"> Monitor Now</a>
      <a href="about.php"><img src="us.png" alt="About Us Icon"> About Us</a>
    </div>
  </div>

  <div class="decorations"></div>
  <div class="decorations-2"></div>
  <div class="decorations-3"></div>
  <div class="decorations-4"></div>

  <?php if (isset($_SESSION['message'])): ?>
    <div style="max-width: 600px; margin: 20px auto; padding: 15px; border-radius: 10px;
                <?php echo ($_SESSION['message_type'] == 'success') ? 'background: #d4edda; color: #155724;' : 'background: #f8d7da; color: #721c24;'; ?> 
                text-align: center; font-size: 18px; font-weight: bold;">
      <?php 
        echo $_SESSION['message']; 
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
      ?>
    </div>
  <?php endif; ?>

  <div class="container">
    <div class="left">
      <img src="car.png" alt="Car Icon" />
      <h1>UV EXPRESS</h1>
      <h2>POLANGUI - LEGAZPI</h2>
      <p>REAL-TIME RIDES,<br>REAL-TIME PEACE OF MIND!</p>
    </div>

    <div class="form-container">
      <p style="font-size: 12px; color: #555; margin-bottom: 15px;">
  <strong><em>Note:</em></strong> <em>This registration is for drivers who want to apply to be part of the <strong>UV SERVICE EXPRESS POLANGUI - LEGAZPI</strong> route.</em>
</p>


      <form method="POST" action="driver_form.php">
        <input type="text" id="name" name="name" placeholder="Name" required>
        <input type="text" id="username" name="username" placeholder="User Name" required>
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="tel" id="contact_number" name="contact_number" placeholder="Contact No">
        <input type="text" id="license_number" name="license_number" placeholder="License Number" required>
        <input type="text" id="plate_number" name="plate_number" placeholder="Plate Number" required>
        <input type="password" id="password" name="password" placeholder="Set Password" required>

        <div style="text-align: left; margin-top: -10px; margin-bottom: 10px;">
          <input type="checkbox" id="showPassword" onclick="togglePassword()" style="margin-right:5px;">
          <label for="showPassword" style="font-size: 14px; color: #333;">Show Password</label>
        </div>

        <button type="submit">Register</button>
      </form>

      <div class="login-link">
        Already have an account? <a href="login.php">Log in here</a>
      </div>
    </div>
  </div>

  <script>
    function toggleMenu() {
      var menu = document.getElementById('menu');
      menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    function togglePassword() {
      var passwordInput = document.getElementById("password");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    }
  </script>

</body>
</html>
