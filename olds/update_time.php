<?php
// update_time.php

include 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $van_id = $_POST['van_id'];
    $new_status = $_POST['status'];

    try {
        // Start building the update query
        $query = "UPDATE vans SET status = :status";

        // Add departure_time if status is traveling
        if ($new_status == 'traveling') {
            $query .= ", departure_time = NOW()";
        }

        // Add arrival_time if status is arrived
        if ($new_status == 'arrived') {
            $query .= ", arrival_time = NOW()";
        }

        $query .= " WHERE van_id = :van_id";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':status' => $new_status,
            ':van_id' => $van_id
        ]);

        echo json_encode(['success' => true, 'message' => 'Status and time updated successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
