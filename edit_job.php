<?php
// edit_job.php

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access. Please log in.']);
    exit();
}

include('db_conn.php'); // Database connection

// Retrieve and sanitize POST parameters
$sr_no            = isset($_POST['sr_no']) ? (int)$_POST['sr_no'] : 0;
$Year             = isset($_POST['Year']) ? sanitize($_POST['Year']) : null;
$Month            = isset($_POST['Month']) ? sanitize($_POST['Month']) : null;
$DTJobNumber      = isset($_POST['DTJobNumber']) ? sanitize($_POST['DTJobNumber']) : null;
$HOJobNumber      = isset($_POST['HOJobNumber']) ? sanitize($_POST['HOJobNumber']) : null;
$Client           = isset($_POST['Client']) ? sanitize($_POST['Client']) : null;
$DateOpened       = isset($_POST['DateOpened']) ? sanitize($_POST['DateOpened']) : null;
$DescriptionOfWork = isset($_POST['DescriptionOfWork']) ? sanitize($_POST['DescriptionOfWork']) : null;
$TARGET_DATE      = isset($_POST['TARGET_DATE']) ? sanitize($_POST['TARGET_DATE']) : null;
$CompletionDate   = isset($_POST['CompletionDate']) ? sanitize($_POST['CompletionDate']) : null;
$DeliveredDate    = isset($_POST['DeliveredDate']) ? sanitize($_POST['DeliveredDate']) : null;
$FileClosed       = isset($_POST['FileClosed']) ? sanitize($_POST['FileClosed']) : null;
$LabourHours      = isset($_POST['LabourHours']) ? sanitize($_POST['LabourHours']) : null;
$MaterialCost     = isset($_POST['MaterialCost']) ? sanitize($_POST['MaterialCost']) : null;
$TypeOfWork       = isset($_POST['TypeOfWork']) ? sanitize($_POST['TypeOfWork']) : null;
$Remarks          = isset($_POST['Remarks']) ? sanitize($_POST['Remarks']) : null;

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Validate required fields
$required_fields = ['sr_no', 'Year', 'Month', 'DTJobNumber', 'Client', 'DateOpened', 'DescriptionOfWork', 'TARGET_DATE'];
foreach ($required_fields as $field) {
    if (empty($$field)) {
        echo json_encode(['success' => false, 'message' => "The field $field is required."]);
        exit();
    }
}

try {
    $updateQuery = "UPDATE jayantha_1500_table SET
        Year = :Year,
        Month = :Month,
        DTJobNumber = :DTJobNumber,
        HOJobNumber = :HOJobNumber,
        Client = :Client,
        DateOpened = :DateOpened,
        DescriptionOfWork = :DescriptionOfWork,
        TARGET_DATE = :TARGET_DATE,
        CompletionDate = :CompletionDate,
        DeliveredDate = :DeliveredDate,
        FileClosed = :FileClosed,
        LabourHours = :LabourHours,
        MaterialCost = :MaterialCost,
        TypeOfWork = :TypeOfWork,
        Remarks = :Remarks
        WHERE sr_no = :sr_no";

    $stmt = $pdo->prepare($updateQuery);

    // Bind parameters with appropriate data types
    $stmt->bindParam(':Year', $Year, PDO::PARAM_INT);
    $stmt->bindParam(':Month', $Month, PDO::PARAM_STR);
    $stmt->bindParam(':DTJobNumber', $DTJobNumber, PDO::PARAM_STR);
    $stmt->bindParam(':HOJobNumber', $HOJobNumber, PDO::PARAM_STR);
    $stmt->bindParam(':Client', $Client, PDO::PARAM_STR);
    $stmt->bindParam(':DateOpened', $DateOpened, PDO::PARAM_STR);
    $stmt->bindParam(':DescriptionOfWork', $DescriptionOfWork, PDO::PARAM_STR);
    $stmt->bindParam(':TARGET_DATE', $TARGET_DATE, PDO::PARAM_STR);

    // Handle CompletionDate: set to NULL if empty
    if (!empty($CompletionDate)) {
        $stmt->bindParam(':CompletionDate', $CompletionDate, PDO::PARAM_STR);
    } else {
        $stmt->bindValue(':CompletionDate', null, PDO::PARAM_NULL);
    }

    // Handle DeliveredDate: set to NULL if empty
    if (!empty($DeliveredDate)) {
        $stmt->bindParam(':DeliveredDate', $DeliveredDate, PDO::PARAM_STR);
    } else {
        $stmt->bindValue(':DeliveredDate', null, PDO::PARAM_NULL);
    }

    $stmt->bindParam(':FileClosed', $FileClosed, PDO::PARAM_INT);
    $stmt->bindParam(':LabourHours', $LabourHours, PDO::PARAM_STR);
    $stmt->bindParam(':MaterialCost', $MaterialCost, PDO::PARAM_STR);
    $stmt->bindParam(':TypeOfWork', $TypeOfWork, PDO::PARAM_STR);
    $stmt->bindParam(':Remarks', $Remarks, PDO::PARAM_STR);
    $stmt->bindParam(':sr_no', $sr_no, PDO::PARAM_INT);

    if($stmt->execute()){
        echo json_encode(['success' => true, 'message' => "Record updated successfully."]);
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['success' => false, 'message' => "Failed to update the record. SQL Error: " . $errorInfo[2]]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => "Database Error: " . $e->getMessage()]);
}

exit();
?>
