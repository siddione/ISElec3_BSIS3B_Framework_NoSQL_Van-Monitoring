<?php
// driver_form.php
session_start();
require 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Collect and sanitize form data
        $name = trim($_POST['name']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $contact_number = trim($_POST['contact_number']);
        $license_number = trim($_POST['license_number']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $plate_number = trim($_POST['plate_number']);
        $is_approved = 'pending'; // New driver starts as pending

        // FIRST: Check if username, email, or license_number already exist
        $stmt = $pdo->prepare("SELECT * FROM drivers WHERE username = ? OR email = ? OR license_number = ?");
        $stmt->execute([$username, $email, $license_number]);
        $existingDriver = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingDriver) {
            // Decide what is duplicated
            if ($existingDriver['username'] === $username) {
                $_SESSION['message'] = 'The username is already taken. Please choose another one.';
            } elseif ($existingDriver['email'] === $email) {
                $_SESSION['message'] = 'The email address is already used. Please use a different email.';
            } elseif ($existingDriver['license_number'] === $license_number) {
                $_SESSION['message'] = 'The license number is already registered.';
            } else {
                $_SESSION['message'] = 'Duplicate entry detected.';
            }

            $_SESSION['message_type'] = 'error';
            header('Location: driver_register.php');
            exit();
        }

        // SECOND: Insert into 'drivers' table
        $stmt = $pdo->prepare("INSERT INTO drivers (name, username, email, contact_number, license_number, password, is_approved) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $username, $email, $contact_number, $license_number, $password, $is_approved]);

        // Get the new driver's ID
        $driver_id = $pdo->lastInsertId();

        // THIRD: Insert van with plate number and link to driver
        $stmt2 = $pdo->prepare("INSERT INTO vans (plate_number, driver_id) VALUES (?, ?)");
        $stmt2->execute([$plate_number, $driver_id]);

        // Set success message
        $_SESSION['message'] = 'Registration successful! Your account is under review.';
        $_SESSION['message_type'] = 'success';

        // Redirect to waiting page
        header('Location: waiting.php');
        exit();
        
    } catch (PDOException $e) {
        // If any other database error happens
        $_SESSION['message'] = 'Something went wrong during registration. Please try again.';
        $_SESSION['message_type'] = 'error';
        header('Location: driver_register.php');
        exit();
    }
}
?>
