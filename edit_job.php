<?php
// edit_job.php
session_start();
include('db_conn.php');

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// Retrieve and sanitize POST parameters
$sr_no = isset($_POST['sr_no']) ? (int)$_POST['sr_no'] : 0;
$year = isset($_POST['Year']) ? trim($_POST['Year']) : '';
$month = isset($_POST['Month']) ? trim($_POST['Month']) : '';
$dtJobNumber = isset($_POST['DTJobNumber']) ? trim($_POST['DTJobNumber']) : '';
$hoJobNumber = isset($_POST['HOJobNumber']) ? trim($_POST['HOJobNumber']) : '';
$client = isset($_POST['Client']) ? trim($_POST['Client']) : '';
$dateOpened = isset($_POST['DateOpened']) ? trim($_POST['DateOpened']) : '';
$descriptionOfWork = isset($_POST['DescriptionOfWork']) ? trim($_POST['DescriptionOfWork']) : '';
$targetDate = isset($_POST['TARGET_DATE']) ? trim($_POST['TARGET_DATE']) : '';
$completionDate = isset($_POST['CompletionDate']) ? trim($_POST['CompletionDate']) : '';
$deliveredDate = isset($_POST['DeliveredDate']) ? trim($_POST['DeliveredDate']) : '';
$fileClosed = isset($_POST['FileClosed']) ? trim($_POST['FileClosed']) : 'No'; // Default to 'No' if not set
$labourHours = isset($_POST['LabourHours']) ? trim($_POST['LabourHours']) : '';
$materialCost = isset($_POST['MaterialCost']) ? trim($_POST['MaterialCost']) : '';
$typeOfWork = isset($_POST['TypeOfWork']) ? trim($_POST['TypeOfWork']) : '';
$remarks = isset($_POST['Remarks']) ? trim($_POST['Remarks']) : '';

// Basic validation
$requiredFields = ['sr_no', 'Year', 'Month', 'DTJobNumber', 'Client', 'DateOpened', 'DescriptionOfWork', 'TARGET_DATE'];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $response['message'] = 'Please fill in all required fields.';
        echo json_encode($response);
        exit();
    }
}

// Ensure FileClosed is either 'Yes' or 'No'
$fileClosed = (strtolower($fileClosed) === 'yes') ? 'Yes' : 'No';

try {
    $updateQuery = "UPDATE jayantha_1500_table SET 
                    Year = :year,
                    Month = :month,
                    DTJobNumber = :dtJobNumber,
                    HOJobNumber = :hoJobNumber,
                    Client = :client,
                    DateOpened = :dateOpened,
                    DescriptionOfWork = :descriptionOfWork,
                    TARGET_DATE = :targetDate,
                    CompletionDate = :completionDate,
                    DeliveredDate = :deliveredDate,
                    FileClosed = :fileClosed,
                    LabourHours = :labourHours,
                    MaterialCost = :materialCost,
                    TypeOfWork = :typeOfWork,
                    Remarks = :remarks
                    WHERE sr_no = :sr_no";

    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt->bindParam(':month', $month, PDO::PARAM_STR);
    $stmt->bindParam(':dtJobNumber', $dtJobNumber, PDO::PARAM_STR);
    $stmt->bindParam(':hoJobNumber', $hoJobNumber, PDO::PARAM_STR);
    $stmt->bindParam(':client', $client, PDO::PARAM_STR);
    $stmt->bindParam(':dateOpened', $dateOpened, PDO::PARAM_STR);
    $stmt->bindParam(':descriptionOfWork', $descriptionOfWork, PDO::PARAM_STR);
    $stmt->bindParam(':targetDate', $targetDate, PDO::PARAM_STR);
    $stmt->bindParam(':completionDate', $completionDate, PDO::PARAM_STR);
    $stmt->bindParam(':deliveredDate', $deliveredDate, PDO::PARAM_STR);
    $stmt->bindParam(':fileClosed', $fileClosed, PDO::PARAM_STR);
    $stmt->bindParam(':labourHours', $labourHours, PDO::PARAM_STR);
    $stmt->bindParam(':materialCost', $materialCost, PDO::PARAM_STR);
    $stmt->bindParam(':typeOfWork', $typeOfWork, PDO::PARAM_STR);
    $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);
    $stmt->bindParam(':sr_no', $sr_no, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Job details updated successfully.';
    } else {
        $response['message'] = 'Failed to update job details.';
    }
} catch (PDOException $e) {
    $response['message'] = "Database Error: " . $e->getMessage();
}

echo json_encode($response);
exit();
?>
