<?php
// get_job.php

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access. Please log in.']);
    exit();
}

include('db_conn.php'); // Database connection

// Retrieve and sanitize POST parameters
$sr_no = trim($_POST['sr_no'] ?? '');

if (empty($sr_no)) {
    echo json_encode(['success' => false, 'message' => 'No job ID provided.']);
    exit();
}

// Fetch job details
try {
    $query = "SELECT * FROM jayantha_1500_table WHERE sr_no = :sr_no LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':sr_no', $sr_no, PDO::PARAM_INT);
    $stmt->execute();
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($job) {
        // Ensure DeliveredDate is in YYYY-MM-DD format
        if (!empty($job['DeliveredDate'])) {
            $job['DeliveredDate'] = date('Y-m-d', strtotime($job['DeliveredDate']));
        } else {
            $job['DeliveredDate'] = '';
        }
        echo json_encode(['success' => true, 'data' => $job]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Job not found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
}
?>
