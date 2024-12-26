<?php
// search.php

// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('db_conn.php');

// Initialize response array
$response = [
    'success' => false,
    'groupedData' => [],
    'pagination' => '',
    'totalRecords' => 0,
    'totalLabourHours' => 0,
    'totalMaterialCost' => 0,
    'message' => ''
];

// Retrieve and sanitize POST parameters
$mainSearch = isset($_POST['mainSearch']) ? trim($_POST['mainSearch']) : '';
$client = isset($_POST['client']) ? trim($_POST['client']) : '';
$jobNumber = isset($_POST['jobNumber']) ? trim($_POST['jobNumber']) : '';
$year = isset($_POST['year']) ? trim($_POST['year']) : '';
$typeOfWork = isset($_POST['typeOfWork']) ? trim($_POST['typeOfWork']) : '';
$fromDate = isset($_POST['fromDate']) ? trim($_POST['fromDate']) : '';
$toDate = isset($_POST['toDate']) ? trim($_POST['toDate']) : '';
$page = isset($_POST['page']) && is_numeric($_POST['page']) ? (int)$_POST['page'] : 1;
$recordsPerPage = 20;
$offset = ($page - 1) * $recordsPerPage;

// Build the WHERE clause based on filters
$whereClauses = [];
$params = [];

// Main search (searches multiple fields)
if (!empty($mainSearch)) {
    $whereClauses[] = "(Year LIKE :mainSearch OR 
                        Month LIKE :mainSearch OR 
                        DTJobNumber LIKE :mainSearch OR 
                        HOJobNumber LIKE :mainSearch OR 
                        Client LIKE :mainSearch OR 
                        DescriptionOfWork LIKE :mainSearch OR 
                        TypeOfWork LIKE :mainSearch OR 
                        Remarks LIKE :mainSearch)";
    $params[':mainSearch'] = '%' . $mainSearch . '%';
}

// Client filter
if (!empty($client)) {
    $whereClauses[] = "Client = :client";
    $params[':client'] = $client;
}

// DT Job Number filter
if (!empty($jobNumber)) {
    $whereClauses[] = "DTJobNumber = :jobNumber";
    $params[':jobNumber'] = $jobNumber;
}

// Year filter
if (!empty($year)) {
    $whereClauses[] = "Year = :year";
    $params[':year'] = $year;
}

// Type of Work filter
if (!empty($typeOfWork)) {
    $whereClauses[] = "TypeOfWork = :typeOfWork";
    $params[':typeOfWork'] = $typeOfWork;
}

// Date range filter
if (!empty($fromDate)) {
    $whereClauses[] = "DateOpened >= :fromDate";
    $params[':fromDate'] = $fromDate;
}
if (!empty($toDate)) {
    $whereClauses[] = "DateOpened <= :toDate";
    $params[':toDate'] = $toDate;
}

// Combine WHERE clauses
$whereSQL = '';
if (count($whereClauses) > 0) {
    $whereSQL = 'WHERE ' . implode(' AND ', $whereClauses);
}

try {
    // Get total records and aggregated totals for pagination and display
    $countQuery = "SELECT COUNT(*) as total, 
                          SUM(LabourHours) as totalLabourHours, 
                          SUM(MaterialCost) as totalMaterialCost 
                   FROM jayantha_1500_table $whereSQL";
    $countStmt = $pdo->prepare($countQuery);
    foreach ($params as $key => &$val) {
        $countStmt->bindParam($key, $val);
    }
    $countStmt->execute();
    $countResult = $countStmt->fetch(PDO::FETCH_ASSOC);
    $totalRecords = $countResult['total'] ?? 0;
    $totalLabourHours = $countResult['totalLabourHours'] ?? 0;
    $totalMaterialCost = $countResult['totalMaterialCost'] ?? 0;
    $totalPages = ceil($totalRecords / $recordsPerPage);

    // Fetch the filtered data with pagination
    $dataQuery = "SELECT * FROM jayantha_1500_table $whereSQL ORDER BY Year ASC, 
                                  CASE 
                                      WHEN Month REGEXP '^[0-9]+$' THEN CAST(Month AS UNSIGNED)
                                      ELSE MONTH(STR_TO_DATE(Month, '%M'))
                                  END ASC, 
                                  Month ASC LIMIT :limit OFFSET :offset";
    $dataStmt = $pdo->prepare($dataQuery);
    
    // Bind the parameters
    foreach ($params as $key => &$val) {
        $dataStmt->bindParam($key, $val);
    }
    $dataStmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
    $dataStmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $dataStmt->execute();
    $jobs = $dataStmt->fetchAll();

    // Group data by Year and then by Month
    $groupedData = [];
    foreach ($jobs as $job) {
        $groupedData[$job['Year']][$job['Month']][] = $job;
    }

    // Generate pagination HTML
    $paginationHTML = '';
    if ($totalPages > 1) {
        $paginationHTML .= '<button class="pagination-link prev ' . ($page <= 1 ? 'disabled' : '') . '" data-page="' . ($page - 1) . '">Previous</button>';
        // Optionally, add page numbers here
        $paginationHTML .= '<span class="mx-2">Page ' . $page . ' of ' . $totalPages . '</span>';
        $paginationHTML .= '<button class="pagination-link next ' . ($page >= $totalPages ? 'disabled' : '') . '" data-page="' . ($page + 1) . '">Next</button>';
    }

    // Populate response
    $response['success'] = true;
    $response['groupedData'] = $groupedData;
    $response['pagination'] = $paginationHTML;
    $response['totalRecords'] = $totalRecords;
    $response['totalLabourHours'] = $totalLabourHours;
    $response['totalMaterialCost'] = $totalMaterialCost;

} catch (PDOException $e) {
    $response['message'] = "Database Error: " . $e->getMessage();
}

echo json_encode($response);
exit();
?>
