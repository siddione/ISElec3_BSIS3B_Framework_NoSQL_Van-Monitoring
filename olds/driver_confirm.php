<?php
session_start();

// Redirect if no registration data
if (!isset($_SESSION['driver_registration'])) {
    header('Location: driver_register.php');
    exit();
}

// Handle "Edit" (save changes)
if (isset($_POST['edit'])) {
    $_SESSION['driver_registration'] = [
        'name' => $_POST['name'],
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'contact_number' => $_POST['contact_number'],
        'license_number' => $_POST['license_number'],
        'plate_number' => $_POST['plate_number'],
        'password' => $_POST['password'], // raw password for now (hash in driver_form.php)
        'profile_picture' => $_SESSION['driver_registration']['profile_picture'] ?? null,
    ];

    // Reload updated data
    header('Location: driver_confirm.php');
    exit();
}

// Driver data
$data = $_SESSION['driver_registration'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Registration - UV Express</title>
    <style>
        body {
            font-family: 'Calibri', sans-serif;
            background: #f0f2f5;
            padding: 40px;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        h1 {
            text-align: center;
            color: #00b050;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 15px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            padding: 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            background: #f9f9f9;
        }
        img.profile {
            display: block;
            margin: 20px auto;
            max-width: 200px;
            border-radius: 10px;
            border: 2px solid #00b050;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .buttons button {
            width: 48%;
            padding: 15px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 30px;
            cursor: pointer;
        }
        .edit-button {
            background: #ddd;
            color: #333;
        }
        .confirm-button {
            background: #00b050;
            color: white;
        }
        .confirm-button:hover {
            background: #009442;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Confirm Your Information</h1>

    <!-- Form that submits to driver_form.php -->
    <form method="POST" action="driver_form.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($data['name']) ?>" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($data['username']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required>

        <label for="contact_number">Contact Number:</label>
        <input type="tel" id="contact_number" name="contact_number" value="<?= htmlspecialchars($data['contact_number']) ?>">

        <label for="license_number">License Number:</label>
        <input type="text" id="license_number" name="license_number" value="<?= htmlspecialchars($data['license_number']) ?>" required>

        <label for="plate_number">Plate Number:</label>
        <input type="text" id="plate_number" name="plate_number" value="<?= htmlspecialchars($data['plate_number']) ?>" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?= htmlspecialchars($data['password']) ?>" required>

        <?php if (!empty($data['profile_picture'])): ?>
            <label>Profile Picture:</label>
            <img src="<?= htmlspecialchars($data['profile_picture']) ?>" alt="Profile Picture" class="profile">
        <?php endif; ?>

        <div class="buttons">
            <button type="submit" name="edit" formaction="driver_confirm.php" class="edit-button">Save Changes</button>
            <button type="submit" name="confirm" class="confirm-button">Confirm & Submit</button>
        </div>
    </form>
</div>

</body>
</html>
