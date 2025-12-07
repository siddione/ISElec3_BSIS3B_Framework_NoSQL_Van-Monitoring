<?php
session_start();


// Fetch the driver from the database
$username = $_POST['username'];
$password = $_POST['password'];

// Assuming a PDO connection to your database
$stmt = $pdo->prepare("SELECT * FROM drivers WHERE username = :username");
$stmt->execute([':username' => $username]);
$driver = $stmt->fetch(PDO::FETCH_ASSOC);

if ($driver) {
    // Verify the password
    if (password_verify($password, $driver['password'])) {
        // Check if approved
        if ($driver['is_approved'] !== 'approved') {
            echo "<script>
                    alert('Your registration is still under review.');
                    window.location.href = 'waiting.php';
                  </script>";
            exit;
        }

        // Store session details
        $_SESSION['driver_id'] = $driver['driver_id'];
        $_SESSION['is_approved'] = $driver['is_approved'];

        // Redirect to homepage
        header("Location: driver_home.php");
        exit;

    } else {
        echo "<script>alert('Invalid credentials.'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('User not found.'); window.location.href='login.php';</script>";
}
?>
