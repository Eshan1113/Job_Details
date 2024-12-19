<?php
// export.php

ini_set('display_errors', 0); // Suppress error display
ini_set('log_errors', 1);     // Enable error logging
ini_set('error_log', 'php-error.log'); // Update with your actual path

session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    http_response_code(401); // Unauthorized
    echo "Unauthorized access. Please log in.";
    exit();
}

include('db_conn.php'); // Database connection

// Retrieve and sanitize POST parameters
$columns = $_POST['columns'] ?? [];
$columns = array_map('trim', $columns);

// Validate selected columns
$allowedColumns = ['Year', 'Month', 'DTJobNumber', 'HOJobNumber', 'Client', 'DateOpened', 'DescriptionOfWork', 'TARGET_DATE', 'CompletionDate', 'DeliveredDate', 'FileClosed', 'LabourHours', 'MaterialCost', 'TypeOfWork', 'Remarks'];
$selectedColumns = array_intersect($columns, $allowedColumns);

if (empty($selectedColumns)) {
    http_response_code(400); // Bad Request
    echo "No valid columns selected for export.";
    exit();
}

// Retrieve and sanitize filter parameters
$mainSearch = trim($_POST['mainSearch'] ?? '');
$client = trim($_POST['client'] ?? '');
$jobNumber = trim($_POST['jobNumber'] ?? '');
$year = trim($_POST['year'] ?? '');
$typeOfWork = trim($_POST['typeOfWork'] ?? '');
$fromDate = trim($_POST['fromDate'] ?? '');
$toDate = trim($_POST['toDate'] ?? '');

$where = [];
$params = [];

// Apply filters
if (!empty($mainSearch)) {
    $where[] = "(Year LIKE :mainSearch OR 
                Month LIKE :mainSearch OR 
                DTJobNumber LIKE :mainSearch OR 
                HOJobNumber LIKE :mainSearch OR 
                Client LIKE :mainSearch OR 
                DescriptionOfWork LIKE :mainSearch OR 
                TypeOfWork LIKE :mainSearch OR 
                Remarks LIKE :mainSearch)";
    $params[':mainSearch'] = '%' . $mainSearch . '%';
}

if (!empty($client)) {
    $where[] = "Client = :client";
    $params[':client'] = $client;
}

if (!empty($jobNumber)) {
    $where[] = "DTJobNumber = :jobNumber";
    $params[':jobNumber'] = $jobNumber;
}

if (!empty($year)) {
    $where[] = "Year = :year";
    $params[':year'] = $year;
}

if (!empty($typeOfWork)) {
    $where[] = "TypeOfWork = :typeOfWork";
    $params[':typeOfWork'] = $typeOfWork;
}

if (!empty($fromDate)) {
    $where[] = "DateOpened >= :fromDate";
    $params[':fromDate'] = $fromDate;
}

if (!empty($toDate)) {
    $where[] = "DateOpened <= :toDate";
    $params[':toDate'] = $toDate;
}

// Build the WHERE clause
$whereClause = '';
if (!empty($where)) {
    $whereClause = 'WHERE ' . implode(' AND ', $where);
}

// Prepare the SQL query with selected columns and filters
$columnsSql = implode(", ", $selectedColumns);
$dataQuery = "SELECT $columnsSql FROM jayantha_1500_table $whereClause ORDER BY Year ASC, MONTH(STR_TO_DATE(Month, '%M')) ASC";

try {
    $dataStmt = $pdo->prepare($dataQuery);

    // Bind parameters
    foreach ($params as $key => &$val) {
        $dataStmt->bindParam($key, $val);
    }

    $dataStmt->execute();
    $jobs = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo "Database Error: " . $e->getMessage();
    exit();
}

// Set headers to prompt download of CSV file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=job_details_' . date('Y-m-d') . '.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, $selectedColumns);

// Output each row
foreach ($jobs as $job) {
    $row = [];
    foreach ($selectedColumns as $col) {
        $value = $job[$col] ?? 'N/A';
        // Specific formatting
        if ($col == 'FileClosed') {
            $value = ($value == '1') ? 'Yes' : 'No';
        }
        $row[] = $value;
    }
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
