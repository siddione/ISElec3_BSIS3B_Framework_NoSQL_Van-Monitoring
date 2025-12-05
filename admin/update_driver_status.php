<?php
include 'dbconnection.php';

$id = $_POST['id'];
$status = $_POST['status'];

$stmt = $conn->prepare("UPDATE drivers SET is_approved = :status WHERE driver_id = :id");
$stmt->execute([':status' => $status, ':id' => $id]);

echo json_encode(["success" => true]);
?>
