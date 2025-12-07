<?php
session_start();
include 'dbconnection.php';

if (!isset($_SESSION['driver_id'])) {
    header('Location: driver_login.php');
    exit();
}

$driver_id = $_SESSION['driver_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM drivers WHERE driver_id = ?");
    $stmt->execute([$driver_id]);
    $driver = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$driver) {
        echo "Driver not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $profile_picture = $driver['profile_picture'];

    // Handle image upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = basename($_FILES['profile_picture']['name']);
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = mime_content_type($fileTmpPath);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (in_array($fileType, $allowedTypes) && $fileSize < 2 * 1024 * 1024) {
            $newFileName = uniqid('driver_', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $destPath = 'uploads/' . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $profile_picture = $newFileName;
            }
        } else {
            echo "<script>alert('Invalid image file. Please upload JPEG or PNG under 2MB.');</script>";
        }
    }

    try {
        if (!empty($password)) {
            if ($password !== $confirm_password) {
                echo "<script>alert('Passwords do not match!');</script>";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $update = $pdo->prepare("
                    UPDATE drivers 
                    SET email = ?, name = ?, username = ?, password = ?, profile_picture = ?
                    WHERE driver_id = ?
                ");
                $update->execute([$email, $name, $username, $hashedPassword, $profile_picture, $driver_id]);
                header('Location: myprofile.php');
                exit();
            }
        } else {
            $update = $pdo->prepare("
                UPDATE drivers 
                SET email = ?, name = ?, username = ?, profile_picture = ?
                WHERE driver_id = ?
            ");
            $update->execute([$email, $name, $username, $profile_picture, $driver_id]);
            header('Location: myprofile.php');
            exit();
        }
    } catch (PDOException $e) {
        echo "Error updating profile: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
body {
    background-color: #f5f5f5;
    font-family: 'Poppins', Arial, sans-serif;
}
.container {
    width: 90%;
    max-width: 480px;
    margin: 50px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    text-align: center;
}
h2 {
    color: #00a651;
    margin-bottom: 20px;
}
label {
    font-weight: bold;
    display: block;
    margin-top: 15px;
    text-align: left;
}
.input-group {
    position: relative;
    margin-top: 8px;
}
input[type="text"],
input[type="email"],
input[type="password"],
input[type="file"] {
    width: 92%;
    padding: 10px 38px 10px 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin: auto;
    display: block;
}
.eye-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 16px;
    color: #999;
}
.note {
    font-size: 12px;
    color: gray;
    margin-top: 5px;
    margin-left: 4%;
    text-align: left;
}
button {
    width: 92%;
    padding: 12px;
    margin: 30px 4% 0 4%;
    border: none;
    background-color: #00a651;
    color: white;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
}
button:hover {
    background-color: #007c3d;
}
.profile-image-preview {
    margin: 10px auto;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ccc;
}
</style>
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>
    <form method="POST" enctype="multipart/form-data">
    <?php
$profilePicturePath = !empty($driver['profile_picture']) && file_exists('uploads/' . $driver['profile_picture'])
    ? 'uploads/' . htmlspecialchars($driver['profile_picture'])
    : 'uploads/driver.png';
?>
<img src="<?php echo $profilePicturePath; ?>" class="profile-image-preview" alt="">

        <label>Change Profile Picture</label>
        <input type="file" name="profile_picture" accept="image/*">

        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($driver['name']); ?>" required>

        <label>Username</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($driver['username']); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($driver['email']); ?>" required>

        <label>New Password</label>
        <div class="input-group">
            <input type="password" name="password" id="password">
            <i class="fa-regular fa-eye eye-icon" id="togglePassword"></i>
        </div>
        <div class="note">Leave blank to keep current password</div>

        <label>Confirm Password</label>
        <div class="input-group">
            <input type="password" name="confirm_password" id="confirm_password">
            <i class="fa-regular fa-eye eye-icon" id="toggleConfirmPassword"></i>
        </div>

        <button type="submit">Save Changes</button>
    </form>
</div>

<script>
// Toggle Password Visibility
document.getElementById('togglePassword').addEventListener('click', function () {
    const pw = document.getElementById('password');
    pw.type = pw.type === 'password' ? 'text' : 'password';
    this.classList.toggle('fa-eye-slash');
});
document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
    const cpw = document.getElementById('confirm_password');
    cpw.type = cpw.type === 'password' ? 'text' : 'password';
    this.classList.toggle('fa-eye-slash');
});
</script>

</body>
</html>
