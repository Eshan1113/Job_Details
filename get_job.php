<?php
session_start();
include('db_conn.php');

// Initialize response array
$response = [
    'success' => false,
    'data' => [],
    'message' => ''
];

// Retrieve and sanitize POST parameter
$sr_no = isset($_POST['sr_no']) ? (int)$_POST['sr_no'] : 0;

if ($sr_no <= 0) {
    $response['message'] = 'Invalid SR No.';
    echo json_encode($response);
    exit();
}

try {
    $query = "SELECT sr_no, Year, Month, DTJobNumber, HOJobNumber, Client, DateOpened, DescriptionOfWork, TARGET_DATE, CompletionDate, DeliveredDate, FileClosed, LabourHours, MaterialCost, TypeOfWork, Remarks 
              FROM jayantha_1500_table 
              WHERE sr_no = :sr_no LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':sr_no', $sr_no, PDO::PARAM_INT);
    $stmt->execute();
    $job = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($job) {
        // FileClosed is already "Yes" or "No"
        // No mapping needed

        $response['success'] = true;
        $response['data'] = $job;
    } else {
        $response['message'] = 'Job not found.';
    }
} catch (PDOException $e) {
    $response['message'] = "Database Error: " . $e->getMessage();
}

echo json_encode($response);
exit();
?>
