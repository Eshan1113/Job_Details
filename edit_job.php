<?php
session_start();
header('Content-Type: application/json');
include('db_conn.php');

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// List of expected fields
$expected_fields = [
    'sr_no', 'Year', 'Month', 'DTJobNumber', 'HOJobNumber', 'Client',
    'DateOpened', 'DescriptionOfWork', 'TARGET_DATE', 'CompletionDate',
    'DeliveredDate', 'FileClosed', 'LabourHours', 'MaterialCost',
    'TypeOfWork', 'Remarks'
];

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if all expected fields are present
$all_fields_present = true;
foreach($expected_fields as $field){
    if(!isset($_POST[$field])){
        $all_fields_present = false;
        $response['message'] = "Missing field: $field";
        break;
    }
}

if($all_fields_present){
    // Sanitize and assign variables
    $sr_no            = (int)$_POST['sr_no'];
    $Year             = sanitize($_POST['Year']);
    $Month            = sanitize($_POST['Month']);
    $DTJobNumber      = sanitize($_POST['DTJobNumber']);
    $HOJobNumber      = sanitize($_POST['HOJobNumber']);
    $Client           = sanitize($_POST['Client']);
    $DateOpened       = sanitize($_POST['DateOpened']);
    $DescriptionOfWork = sanitize($_POST['DescriptionOfWork']);
    $TARGET_DATE      = sanitize($_POST['TARGET_DATE']);
    $CompletionDate   = sanitize($_POST['CompletionDate']);
    $DeliveredDate    = sanitize($_POST['DeliveredDate']);
    $FileClosed       = sanitize($_POST['FileClosed']);
    $LabourHours      = sanitize($_POST['LabourHours']);
    $MaterialCost     = sanitize($_POST['MaterialCost']);
    $TypeOfWork       = sanitize($_POST['TypeOfWork']);
    $Remarks          = sanitize($_POST['Remarks']);
    
    // Additional validation can be added here
    // For example, ensure Year is a valid integer, dates are in correct format, etc.
    
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
        $stmt->bindParam(':Year', $Year, PDO::PARAM_INT);
        $stmt->bindParam(':Month', $Month, PDO::PARAM_STR);
        $stmt->bindParam(':DTJobNumber', $DTJobNumber, PDO::PARAM_STR);
        $stmt->bindParam(':HOJobNumber', $HOJobNumber, PDO::PARAM_STR);
        $stmt->bindParam(':Client', $Client, PDO::PARAM_STR);
        $stmt->bindParam(':DateOpened', $DateOpened, PDO::PARAM_STR);
        $stmt->bindParam(':DescriptionOfWork', $DescriptionOfWork, PDO::PARAM_STR);
        $stmt->bindParam(':TARGET_DATE', $TARGET_DATE, PDO::PARAM_STR);
        $stmt->bindParam(':CompletionDate', $CompletionDate, PDO::PARAM_STR);
        $stmt->bindParam(':DeliveredDate', $DeliveredDate, PDO::PARAM_STR);
        $stmt->bindParam(':FileClosed', $FileClosed, PDO::PARAM_STR);
        $stmt->bindParam(':LabourHours', $LabourHours, PDO::PARAM_STR);
        $stmt->bindParam(':MaterialCost', $MaterialCost, PDO::PARAM_STR);
        $stmt->bindParam(':TypeOfWork', $TypeOfWork, PDO::PARAM_STR);
        $stmt->bindParam(':Remarks', $Remarks, PDO::PARAM_STR);
        $stmt->bindParam(':sr_no', $sr_no, PDO::PARAM_INT);
        
        if($stmt->execute()){
            $response['success'] = true;
            $response['message'] = "Record updated successfully.";
        } else {
            $errorInfo = $stmt->errorInfo();
            $response['message'] = "Failed to update the record. SQL Error: " . $errorInfo[2];
        }
    } catch (PDOException $e) {
        // Handle exception
        $response['message'] = "Database Error: " . $e->getMessage();
    }
} else {
    $response['message'] = "Required fields are missing.";
}

echo json_encode($response);
exit();
?>
