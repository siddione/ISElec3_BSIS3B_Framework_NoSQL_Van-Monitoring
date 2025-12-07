<?php 
// waiting.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Waiting for Approval</title>
  <style>
    body {
      font-family: 'Calibri', 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
      text-align: center;
      padding: 80px;
    }

    /* Animate the "Registration Successful" heading */
    h1 {
      font-size: 48px;
      color: #00b050;
      animation: fadeSlideIn 1s ease-out;
    }

    @keyframes fadeSlideIn {
      0% {
        opacity: 0;
        transform: translateY(-20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .message {
      font-size: 28px;
      color: #333;
      margin-top: 40px;
      line-height: 1.5;
    }

    .car-container {
      margin-top: 60px;
      display: flex;
      justify-content: center;
    }

    .car {
      width: 150px;
      animation: move 2s infinite linear;
    }

    @keyframes move {
      0% { transform: translateX(0); }
      50% { transform: translateX(40px); }
      100% { transform: translateX(0); }
    }

    .loading-text {
      margin-top: 30px;
      font-size: 24px;
      color: #666;
      font-style: italic;
    }

    /* Add breathing animation to the login link */
    .login-link {
      display: inline-block;
      margin-top: 30px;
      font-size: 20px;
      color: #00b050;
      text-decoration: none;
      font-weight: bold;
      padding: 12px 24px;
      border-radius: 25px;
      border: 2px solid #00b050;
      transition: background 0.3s ease;
      animation: breathing 2.5s infinite;
    }

    @keyframes breathing {
      0% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.05); opacity: 0.9; }
      100% { transform: scale(1); opacity: 1; }
    }

    .login-link:hover {
      background-color: #00b050;
      color: white;
      text-decoration: none;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
      body {
        padding: 40px 20px;
      }

      h1 {
        font-size: 36px;
      }

      .message {
        font-size: 22px;
      }

      .car {
        width: 100px;
      }

      .loading-text {
        font-size: 18px;
      }

      .login-link {
        font-size: 18px;
      }
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 28px;
      }

      .message {
        font-size: 18px;
      }

      .car {
        width: 80px;
      }

      .loading-text {
        font-size: 16px;
      }

      .login-link {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>

  <h1>Registration Successful!</h1>

  <div class="message">
    <p>Your account is currently under review by our admin team.</p>
  </div>

  <div class="car-container">
    <img src="car.png" alt="Loading Car" class="car">
  </div>

  <div class="loading-text">Please wait for admin approval...</div>

  <a href="login.php" class="login-link">Try to Login Now</a>

</body>
</html>
