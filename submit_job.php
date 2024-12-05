<?php
session_start();

// Include the database connection file
include('db_conn.php');

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture the form data
    $year = $_POST['Year'];
    $month = $_POST['Month'];
    $dtJobNumber = $_POST['DTJobNumber'];
    $hoJobNumber = $_POST['HOJobNumber'];
    $client = $_POST['Client'];
    $dateOpened = $_POST['DateOpened'];
    $descriptionOfWork = $_POST['Description_Of_Work'];
    $targetDate = $_POST['TargetDate'];
    $completionDate = $_POST['CompletionDate'] ?? null; // Use null if not provided
    $deliveredDate = $_POST['DeliveredDate'] ?? null; // Use null if not provided
    $fileClosed = $_POST['FileClosed'];
    $labourHours = $_POST['LabourHours'] ?? null; // Use null if not provided
    $materialCost = $_POST['MaterialCost'] ?? null; // Use null if not provided
    $typeOfWork = $_POST['TypeOfWork'] ?? null; // Use null if not provided
    $remarks = $_POST['Remarks'] ?? null; // Use null if not provided

    try {
        // Prepare the SQL query
        $sql = "INSERT INTO jobdetails (Year, Month, DTJobNumber, HOJobNumber, Client, DateOpened, Description_Of_Work, TargetDate, CompletionDate, DeliveredDate, FileClosed, LabourHours, MaterialCost, TypeOfWork, Remarks)
                VALUES (:year, :month, :dtJobNumber, :hoJobNumber, :client, :dateOpened, :descriptionOfWork, :targetDate, :completionDate, :deliveredDate, :fileClosed, :labourHours, :materialCost, :typeOfWork, :remarks)";

        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Bind the parameters
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
        $stmt->bindParam(':dtJobNumber', $dtJobNumber);
        $stmt->bindParam(':hoJobNumber', $hoJobNumber);
        $stmt->bindParam(':client', $client);
        $stmt->bindParam(':dateOpened', $dateOpened);
        $stmt->bindParam(':descriptionOfWork', $descriptionOfWork);
        $stmt->bindParam(':targetDate', $targetDate);
        $stmt->bindParam(':completionDate', $completionDate);
        $stmt->bindParam(':deliveredDate', $deliveredDate);
        $stmt->bindParam(':fileClosed', $fileClosed);
        $stmt->bindParam(':labourHours', $labourHours);
        $stmt->bindParam(':materialCost', $materialCost);
        $stmt->bindParam(':typeOfWork', $typeOfWork);
        $stmt->bindParam(':remarks', $remarks);

        // Execute the statement
        $stmt->execute();

        // Success message
        $_SESSION['message'] = "Job details added successfully!";
        $_SESSION['message_type'] = 'success';
    } catch (PDOException $e) {
        // Error handling
        $_SESSION['message'] = "Error: " . $e->getMessage();
        $_SESSION['message_type'] = 'error';
    }

    // Redirect back to the form or show a success message
    header('Location: index.php');
    exit();
}
?>
