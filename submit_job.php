<?php
session_start();
include('db_conn.php');

// Retrieve and sanitize form inputs
$year = $_POST['Year'] ?? '';
$month = $_POST['Month'] ?? '';
$dtJobNumber = $_POST['DTJobNumber'] ?? '';
$hoJobNumber = $_POST['HOJobNumber'] ?? '';
$client = $_POST['Client'] ?? '';
$dateOpened = $_POST['DateOpened'] ?? '';
$descriptionOfWork = $_POST['DescriptionOfWork'] ?? '';
$TARGET_DATE = $_POST['TARGET_DATE'] ?? '';
$completionDate = $_POST['CompletionDate'] ?? '';
$deliveredDate = $_POST['DeliveredDate'] ?? '';
$fileClosed = $_POST['FileClosed'] ?? '0';
$labourHours = $_POST['LabourHours'] ?? '0.00';
$materialCost = $_POST['MaterialCost'] ?? '0.00';
$typeOfWork = $_POST['TypeOfWork'] ?? '';
$remarks = $_POST['Remarks'] ?? '';

// Basic validation (you can expand this as needed)
if (empty($year) || empty($month) || empty($dtJobNumber) || empty($client) || empty($dateOpened) || empty($descriptionOfWork) || empty($TARGET_DATE) || empty($TARGET_DATE)) {
    $_SESSION['message'] = 'Please fill in all required fields.';
    $_SESSION['message_type'] = 'error';
    header("Location: dashboard.php");
    exit();
}

try {
    // Insert the job details into the database
    $stmt = $pdo->prepare("
        INSERT INTO jayantha_1500_table (
            Year, 
            Month, 
            DTJobNumber, 
            HOJobNumber, 
            Client, 
            DateOpened, 
            DescriptionOfWork, 
            TARGET_DATE, 
            CompletionDate, 
            DeliveredDate, 
            FileClosed, 
            LabourHours, 
            MaterialCost, 
            TypeOfWork, 
            Remarks
        ) VALUES (
            :year, 
            :month, 
            :dtJobNumber, 
            :hoJobNumber, 
            :client, 
            :dateOpened, 
            :descriptionOfWork, 
            :TARGET_DATE, 
            :completionDate, 
            :deliveredDate, 
            :fileClosed, 
            :labourHours, 
            :materialCost, 
            :typeOfWork, 
            :remarks
        )
    ");

    $stmt->execute([
        ':year' => $year,
        ':month' => $month,
        ':dtJobNumber' => $dtJobNumber,
        ':hoJobNumber' => $hoJobNumber,
        ':client' => $client,
        ':dateOpened' => $dateOpened,
        ':descriptionOfWork' => $descriptionOfWork,
        ':TARGET_DATE' => $TARGET_DATE,
        ':completionDate' => $completionDate,
        ':deliveredDate' => $deliveredDate,
        ':fileClosed' => $fileClosed,
        ':labourHours' => $labourHours,
        ':materialCost' => $materialCost,
        ':typeOfWork' => $typeOfWork,
        ':remarks' => $remarks
    ]);

    $_SESSION['message'] = 'Job details added successfully!';
    $_SESSION['message_type'] = 'success';
} catch (PDOException $e) {
    // Handle insertion errors
    $_SESSION['message'] = 'Error adding job details: ' . $e->getMessage();
    $_SESSION['message_type'] = 'error';
}

header("Location: dashboard.php");
exit();
?>
