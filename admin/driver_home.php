<?php
// driver_home.php
session_start();

// Optional: Make sure only approved drivers can access this
if (!isset($_SESSION['driver_id']) || $_SESSION['is_approved'] !== 'approved') {
    header("Location: driver_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Driver Homepage</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #e0ffe0;
      text-align: center;
      padding: 50px;
    }
    h1 {
      color: #00b050;
      font-size: 40px;
    }
    p {
      font-size: 22px;
    }
    .btn {
      padding: 12px 25px;
      font-size: 18px;
      border: none;
      border-radius: 6px;
      background-color: #00b050;
      color: white;
      cursor: pointer;
      margin-top: 20px;
    }
  </style>
</head>
<body>

  <h1>Welcome to UV Express System</h1>
  <p>Your registration has been approved. You can now update your van status and seats in real time.</p>

  <a href="logout.php"><button class="btn">Logout</button></a>

</body>
</html>
