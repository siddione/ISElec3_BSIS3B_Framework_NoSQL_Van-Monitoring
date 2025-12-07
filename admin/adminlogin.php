
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login - UV Express</title>


  <style>
* {
  box-sizing: border-box;
}

    body {
      font-family: 'Poppins';
      background: #f5f5f5;
      margin: 0;
    }

    .navbar {
      background-color: #00b050;
      padding: 10px 15px;
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
      color: black;
      font-size: 20px;
      font-weight: 400;
    }

    .wide-spacing {
      font-weight: none;
      letter-spacing: 15px;
    }

    .main-title {
      text-align: center;
      margin-top: 40px;
      font-size: 30px;
    }

    .login-container {
      max-width: 400px;
      margin: 30px auto;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .login-container img {
      height: 80px;
      margin-bottom: 15px;
    }

    .login-container h4 {
      margin-bottom: 20px;
      font-size: 18px;
      color: #333;
      font-weight: 400;
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

    @media (max-width: 500px) {
      .navbar-title img {
        height: 55px;
      }

      .navbar-title h2 {
        font-size: 30px;
      }

      h3 {
        font-size: 18px;
        font-weight: none;
      }

      .main-title {
        font-size: 26px;
      }

      .login-container {
        padding: 25px 20px;
      }

      .login-container img {
        height: 60px;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar section -->
  <div class="navbar">
    <div class="navbar-title">
      <img src="car.png" alt="Car Icon" />
      <h2>UV EXPRESS</h2>
    </div>
    <h3 class="wide-spacing ">POLANGUI - LEGAZPI</h3>
  </div>

  <!-- Login form title -->
  <h2 class="main-title">Admin Login</h2>

  <!-- Login form container -->
  <div class="login-container">
    <img src="logovan.png" alt="UV Express Logo" />
    <h4>Sign in to access the admin panel</h4>
    <form action="admin_login.php" method="POST">
      <label for="email">Email</label>
      <input type="text" id="email" name="email" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />

      <button type="submit">Login</button>
    </form>
  </div>

</body>
</html>
