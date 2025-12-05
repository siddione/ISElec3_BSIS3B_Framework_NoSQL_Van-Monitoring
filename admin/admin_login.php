<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'vandb';
$username = 'root'; // Change this if your DB username is different
$password = '';     // Add your DB password if needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Login process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputEmail = trim($_POST['email']);
    $inputPassword = trim($_POST['password']);

    try {
        // Querying the database using email
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = :email");
        $stmt->bindParam(':email', $inputEmail);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && sha1($inputPassword===$admin['password'])) {
            // Password is correct
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['name'];

            header("Location: adminhomepage.php");
            exit();
        } else {
            echo "<script>alert('Invalid email or password.'); window.location.href='adminlogin.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
