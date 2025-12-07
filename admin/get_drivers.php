<?php
include 'dbconnection.php';

$query = $conn->prepare("
  SELECT d.driver_id, d.name, d.username, d.email, d.contact_number, 
         d.license_number, d.is_approved, v.plate_number
  FROM drivers d
  JOIN vans v ON d.driver_id = v.driver_id
  WHERE d.is_approved='pending'
");
$query->execute();
$drivers = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($drivers);
?>
