<?php
session_start();

if (!isset($_SESSION['driver_id'])) {
    header('Location: login.php');
    exit;
}

require 'dbconnection.php';

$driver_id = $_SESSION['driver_id'];
$stmt = $pdo->prepare("SELECT is_approved FROM drivers WHERE driver_id = ?");
$stmt->execute([$driver_id]);
$driver = $stmt->fetch();

if ($driver && $driver['is_approved'] === 'rejected') {
    $message = "Unfortunately, your application didn't meet our criteria at this time. We appreciate your interest and encourage you to try again.";
} else {
    header('Location: driver_home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Account Rejected - UV Express</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #e0f7e9, #c2f0d6);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .card {
      background-color: #fff;
      border-radius: 16px;
      padding: 40px 30px;
      max-width: 500px;
      width: 100%;
      box-shadow: 0 10px 25px rgba(0, 176, 80, 0.2);
      text-align: center;
      animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .emoji {
      font-size: 60px;
      margin-bottom: 20px;
      animation: bounce 1.5s infinite ease-in-out;
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    h1 {
      color: #dc3545;
      font-size: 32px;
      margin-bottom: 20px;
    }

    .message {
      font-size: 18px;
      color: #555;
      margin-bottom: 30px;
      line-height: 1.5;
    }

    .button-group {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .button {
      padding: 12px 20px;
      background-color: #00b050;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      text-decoration: none;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .button:hover {
      background-color: #009442;
      transform: translateY(-2px);
    }

    @media (max-width: 480px) {
      .card {
        padding: 30px 20px;
      }

      h1 {
        font-size: 28px;
      }

      .button {
        width: 100%;
        text-align: center;
      }
    }
  </style>
</head>
<body>

  <div class="card">
    <div class="emoji">😔</div>
    <h1>Account Rejected</h1>
    <div class="message"><?php echo $message; ?></div>
    <div class="button-group">
      <a class="button" href="index.php">Back to Home</a>
      <a class="button" href="driver_register.php">Register Again</a>
    </div>
  </div>

</body>
</html>
