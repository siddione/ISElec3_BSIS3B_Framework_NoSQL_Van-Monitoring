<?php
session_start();
require 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch driver based on username
    $stmt = $pdo->prepare("SELECT * FROM drivers WHERE username = ?");
    $stmt->execute([$username]);
    $driver = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($driver && password_verify($password, $driver['password'])) {
        // Set session variables
        $_SESSION['driver_id'] = $driver['driver_id'];
        $_SESSION['is_approved'] = $driver['is_approved'];

        // Redirect based on approval status
        if ($driver['is_approved'] === 'approved') {
            header("Location: driver_home.php");
        } elseif ($driver['is_approved'] === 'pending') {
            header("Location: waiting.php");
        } elseif ($driver['is_approved'] === 'rejected') {
            header("Location: rejected.php");
        }
        exit;
    } else {
        // Redirect back to login.php with error flag
        header("Location: login.php?error=1");
        exit;
    }
}
?>
