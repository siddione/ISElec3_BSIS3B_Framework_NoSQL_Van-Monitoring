<?php
$host = "localhost";
$user = "root";
$pass = ""; // Update with your DB password if any
$dbname = "vandb";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Query for approved drivers
$sql = "SELECT d.name, d.username, d.email, d.contact_number, d.license_number, v.plate_number 
        FROM drivers d
        JOIN vans v ON d.driver_id = v.driver_id
        WHERE d.is_approved = 'approved'";

$result = $conn->query($sql);

$drivers = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $drivers[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($drivers);
?>
