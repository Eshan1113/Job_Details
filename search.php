<?php
include('db_conn.php');

// Retrieve POST parameters
$mainSearch = isset($_POST['mainSearch']) ? trim($_POST['mainSearch']) : '';
$client = isset($_POST['client']) ? trim($_POST['client']) : '';
$jobNumber = isset($_POST['jobNumber']) ? trim($_POST['jobNumber']) : '';
$year = isset($_POST['year']) ? trim($_POST['year']) : '';
$typeOfWork = isset($_POST['typeOfWork']) ? trim($_POST['typeOfWork']) : '';
$fromDate = isset($_POST['fromDate']) ? trim($_POST['fromDate']) : '';
$toDate = isset($_POST['toDate']) ? trim($_POST['toDate']) : '';
$page = isset($_POST['page']) && is_numeric($_POST['page']) ? (int)$_POST['page'] : 1;

$limit = 10;
$start = ($page - 1) * $limit;

// Build the base SQL query
$sql = "SELECT * FROM jayantha_1500_table WHERE 1=1";
$params = [];

// Add main search condition
if (!empty($mainSearch)) {
    $sql .= " AND (Client LIKE :mainSearch 
                OR DTJobNumber LIKE :mainSearch 
                OR Year LIKE :mainSearch 
                OR TypeOfWork LIKE :mainSearch 
                OR DescriptionOfWork LIKE :mainSearch 
                OR Remarks LIKE :mainSearch)";
    $params[':mainSearch'] = '%' . $mainSearch . '%';
}

// Add conditions based on individual search inputs
if (!empty($client)) {
    $sql .= " AND Client LIKE :client";
    $params[':client'] = '%' . $client . '%';
}
if (!empty($jobNumber)) {
    $sql .= " AND DTJobNumber LIKE :jobNumber";
    $params[':jobNumber'] = '%' . $jobNumber . '%';
}
if (!empty($year)) {
    $sql .= " AND Year = :year";
    $params[':year'] = $year;
}
if (!empty($typeOfWork)) {
    $sql .= " AND TypeOfWork = :typeOfWork";
    $params[':typeOfWork'] = $typeOfWork;
}
if (!empty($fromDate) && !empty($toDate)) {
    $sql .= " AND DateOpened BETWEEN :fromDate AND :toDate";
    $params[':fromDate'] = $fromDate;
    $params[':toDate'] = $toDate;
}

// Add pagination
$sql .= " LIMIT :start, :limit";
$params[':start'] = $start;
$params[':limit'] = $limit;

try {
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    foreach ($params as $key => &$value) {
        if ($key === ':start' || $key === ':limit') {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($key, $value);
        }
    }

    $stmt->execute();
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle error appropriately
    echo json_encode(['tableData' => '', 'pagination' => '']);
    exit();
}

// Total records for pagination
$totalQuery = "SELECT COUNT(*) FROM jayantha_1500_table WHERE 1=1";
$totalParams = [];

// Add main search condition to total query
if (!empty($mainSearch)) {
    $totalQuery .= " AND (Client LIKE :mainSearch 
                      OR DTJobNumber LIKE :mainSearch 
                      OR Year LIKE :mainSearch 
                      OR TypeOfWork LIKE :mainSearch 
                      OR DescriptionOfWork LIKE :mainSearch 
                      OR Remarks LIKE :mainSearch)";
    $totalParams[':mainSearch'] = '%' . $mainSearch . '%';
}

// Add conditions based on individual search inputs
if (!empty($client)) {
    $totalQuery .= " AND Client LIKE :client";
    $totalParams[':client'] = '%' . $client . '%';
}
if (!empty($jobNumber)) {
    $totalQuery .= " AND DTJobNumber LIKE :jobNumber";
    $totalParams[':jobNumber'] = '%' . $jobNumber . '%';
}
if (!empty($year)) {
    $totalQuery .= " AND Year = :year";
    $totalParams[':year'] = $year;
}
if (!empty($typeOfWork)) {
    $totalQuery .= " AND TypeOfWork = :typeOfWork";
    $totalParams[':typeOfWork'] = $typeOfWork;
}
if (!empty($fromDate) && !empty($toDate)) {
    $totalQuery .= " AND DateOpened BETWEEN :fromDate AND :toDate";
    $totalParams[':fromDate'] = $fromDate;
    $totalParams[':toDate'] = $toDate;
}

try {
    $totalStmt = $pdo->prepare($totalQuery);

    // Bind parameters
    foreach ($totalParams as $key => &$value) {
        $totalStmt->bindValue($key, $value);
    }

    $totalStmt->execute();
    $totalRecords = $totalStmt->fetchColumn();
    $totalPages = ceil($totalRecords / $limit);
} catch (PDOException $e) {
    // Handle error appropriately
    $totalRecords = 0;
    $totalPages = 1;
}

// Prepare table rows
$tableData = '';
foreach ($jobs as $job) {
    $tableData .= "<tr>
        <td>" . htmlspecialchars($job['sr_no']) . "</td>
        <td>" . htmlspecialchars($job['Year']) . "</td>
        <td>" . htmlspecialchars($job['Month']) . "</td>
        <td>" . htmlspecialchars($job['DTJobNumber']) . "</td>
        <td>" . htmlspecialchars($job['HOJobNumber']) . "</td>
        <td>" . htmlspecialchars($job['Client']) . "</td>
        <td>" . htmlspecialchars($job['DateOpened']) . "</td>
        <td>" . htmlspecialchars($job['DescriptionOfWork']) . "</td>
        <td>" . htmlspecialchars($job['TARGET_DATE']) . "</td>
        <td>" . htmlspecialchars($job['CompletionDate']) . "</td>
        <td>" . htmlspecialchars($job['DeliveredDate']) . "</td>
        <td>" . htmlspecialchars($job['FileClosed']) . "</td>
        <td>" . htmlspecialchars($job['LabourHours']) . "</td>
        <td>" . htmlspecialchars($job['MaterialCost']) . "</td>
        <td>" . htmlspecialchars($job['TypeOfWork']) . "</td>
        <td>" . htmlspecialchars($job['Remarks']) . "</td>
    </tr>";
}

// Prepare pagination links (Previous and Next only)
$pagination = '';

// Previous link
if ($page > 1) {
    $pagination .= '<a href="#" class="pagination-link mr-2" data-page="' . ($page - 1) . '">Previous</a>';
}

// Next link
if ($page < $totalPages) {
    $pagination .= '<a href="#" class="pagination-link ml-2" data-page="' . ($page + 1) . '">Next</a>';
}

// Return JSON response
echo json_encode(['tableData' => $tableData, 'pagination' => $pagination]);
?>
