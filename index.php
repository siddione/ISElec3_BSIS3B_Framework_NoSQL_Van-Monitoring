<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Visitor Page - UV Express</title>
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
    }

    .top-banner {
      background-color: #00b050;
      height: 85px;
      width: 100%;
      display: flex;
      align-items: center;
      position: relative;
      z-index: 10;
    }

    .menu-icon {
      font-size: 28px;
      cursor: pointer;
      margin-left: 50px;
      color: black;
     
    }

    .menu {
      display: none;
      position: absolute;
      top: 100px;
      left: 20px;
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

    .container {
      max-width: 1200px;
      margin: 38px auto 10px; /* moved up */
      padding: 45px;
      background: transparent;
      border-radius: 20px;
      box-shadow: 0 0 30px rgba(0, 176, 80, 0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: -5px;
      
    }

    .left {
      flex: 1;
      text-align: center;
    }

    .left img {
      width: 220px;
      margin-bottom: 0px;
      
    }

    .left h1 {
      color: #00b050;
      font-size: 90px;
      font-weight: none;
      margin-bottom: 5px;
    }

    .left h2 {
      font-size: 36px;
      font-weight: bold;
      letter-spacing: 8px;
      margin-bottom: 20px;
      color: black;
    }

    .left p {
      margin-top: 30px;
      font-size: 32px;
      color: #00b050;
      font-weight: bold;
      line-height: 1.4;
    }

    .right {
      flex: 1;
      text-align: center;
    }

    .right img {
      width: 100%;
      max-width: 550px;
      border-radius: 20px;
      box-shadow: none;
    }

    .monitor-button-container {
      display: flex;
      justify-content: center;
      margin-top: 50px; /* moved down */
      margin-bottom: 10px;
    }

    .btn {
      background: linear-gradient(45deg, #00b050, #00823d);
      color: white;
      padding: 14px 30px;
      border: none;
      border-radius: 50px;
      font-size: 20px;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
      animation: pulse 2s infinite, breathing 2.5s infinite;
      display: inline-block;
    }

    .btn:hover {
      transform: scale(1.05);
      box-shadow: 0 0 30px rgba(0, 176, 80, 0.8), 0 0 60px rgba(0, 176, 80, 0.6);
    }

    @keyframes pulse {
      0% {
        box-shadow: 0 0 15px rgba(0, 176, 80, 0.5), 0 0 30px rgba(0, 176, 80, 0.3);
      }
      50% {
        box-shadow: 0 0 30px rgba(0, 176, 80, 0.8), 0 0 60px rgba(0, 176, 80, 0.5);
      }
      100% {
        box-shadow: 0 0 15px rgba(0, 176, 80, 0.5), 0 0 30px rgba(0, 176, 80, 0.3);
      }
    }

    @keyframes breathing {
      0% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.08);
      }
      100% {
        transform: scale(1);
      }
    }

    footer {
      font-size: 16px;
      color: #7f8c8d;
      text-align: center;
      padding-bottom: 40px;
    }

    footer a {
      color: #00b050;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 900px) {
      .container {
        flex-direction: column;
        padding: 20px;
      }
      .left h1 { font-size: 60px; }
      .left h2 { font-size: 28px; }
      .left p { font-size: 24px; }
      .left img { width: 160px; }
    }

    @media (max-width: 500px) {
      .left img { width: 140px; }
      .right img { max-width: 100%; }
      .btn { font-size: 18px; padding: 10px 20px; }
    }
  </style>
</head>
<body>

  <div class="top-banner">
    <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
    <div id="menu" class="menu">
      <a href="driver_register.php">
        <img src="reg.png" alt="Register Icon"> Register
      </a>
      <a href="login.php">
        <img src="log.png" alt="Log In Icon"> Login
      </a>
      <a href="about.php">
        <img src="us.png" alt="About Us Icon"> About Us
      </a>
    </div>
  </div>

  <div class="container">
    <div class="left">
      <img src="car.png" alt="Car Icon" />
      <h1>UV EXPRESS</h1>
      <h2>POLANGUI - LEGAZPI</h2>
      <p>REAL-TIME RIDES,<br>REAL-TIME PEACE OF MIND!</p>
    </div>
    <div class="right">
      <img src="map.png" alt="Map Illustration" />
    </div>
  </div>

  <div class="monitor-button-container">
    <a href="monitor.php" class="btn">Monitor Now</a>
  </div>

  <footer>
    &copy; 2025 UV Express. Visit us at <a href="https://www.uvexpress.com">www.uvexpress.com</a>
  </footer>

  <script>
    function toggleMenu() {
      var menu = document.getElementById('menu');
      menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }
  </script>

</body>
</html>
