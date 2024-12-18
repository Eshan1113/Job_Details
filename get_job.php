<?php
session_start();
header('Content-Type: application/json');
include('db_conn.php');

// Initialize response array
$response = [
    'success' => false,
    'data' => null,
    'message' => ''
];

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if sr_no is set and is numeric
if(isset($_POST['sr_no']) && is_numeric($_POST['sr_no'])){
    $sr_no = (int)$_POST['sr_no'];
    
    try {
        $query = "SELECT sr_no, Year, Month, DTJobNumber, HOJobNumber, Client, DateOpened, DescriptionOfWork, TARGET_DATE, CompletionDate, DeliveredDate, FileClosed, LabourHours, MaterialCost, TypeOfWork, Remarks 
                  FROM jayantha_1500_table 
                  WHERE sr_no = :sr_no 
                  LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':sr_no', $sr_no, PDO::PARAM_INT);
        $stmt->execute();
        $job = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($job){
            // Sanitize data before sending
            foreach($job as $key => $value){
                $job[$key] = sanitize($value);
            }
            $response['success'] = true;
            $response['data'] = $job;
        } else {
            $response['message'] = "No record found with sr_no: $sr_no";
        }
    } catch (PDOException $e) {
        // Handle error appropriately
        $response['message'] = "Database Error: " . $e->getMessage();
    }
} else {
    $response['message'] = "Invalid or missing sr_no.";
}

echo json_encode($response);
exit();
?>
