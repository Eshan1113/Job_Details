<?php
session_start();
include('db_conn.php');

$page = $_POST['page'] ?? 1;
$perPage = 10; // Number of results per page
$start = ($page - 1) * $perPage;

$client = $_POST['client'] ?? '';
$jobNumber = $_POST['jobNumber'] ?? '';
$year = $_POST['year'] ?? '';
$fromDate = $_POST['fromDate'] ?? '';
$toDate = $_POST['toDate'] ?? '';

$whereClauses = [];
$params = [];

if ($client) {
    $whereClauses[] = "Client LIKE :client";
    $params[':client'] = "%$client%";
}
if ($jobNumber) {
    $whereClauses[] = "DTJobNumber LIKE :jobNumber";
    $params[':jobNumber'] = "%$jobNumber%";
}
if ($year) {
    $whereClauses[] = "Year = :year";
    $params[':year'] = $year;
}
if ($fromDate && $toDate) {
    $whereClauses[] = "DateOpened BETWEEN :fromDate AND :toDate";
    $params[':fromDate'] = $fromDate;
    $params[':toDate'] = $toDate;
} elseif ($fromDate) {
    $whereClauses[] = "DateOpened >= :fromDate";
    $params[':fromDate'] = $fromDate;
} elseif ($toDate) {
    $whereClauses[] = "DateOpened <= :toDate";
    $params[':toDate'] = $toDate;
}

$whereSql = '';
if (count($whereClauses) > 0) {
    $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
}

$sql = "SELECT * FROM jayantha_1500_table $whereSql LIMIT :start, :perPage";
$stmt = $pdo->prepare($sql);
$params[':start'] = $start;
$params[':perPage'] = $perPage;

$stmt->execute($params);

$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get total results count for pagination
$sqlCount = "SELECT COUNT(*) FROM jayantha_1500_table $whereSql";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->execute($params);
$totalResults = $stmtCount->fetchColumn();
$totalPages = ceil($totalResults / $perPage);

// Prepare table data
$tableData = '';
foreach ($jobs as $job) {
    $tableData .= "<tr>
        <td>{$job['OrderID']}</td>
        <td>{$job['Year']}</td>
        <td>{$job['Month']}</td>
        <td>{$job['DTJobNumber']}</td>
        <td>{$job['HOJobNumber']}</td>
        <td>{$job['Client']}</td>
        <td>{$job['DateOpened']}</td>
        <td>{$job['DescriptionOfWork']}</td>
        <td>{$job['TargetDate']}</td>
        <td>{$job['CompletionDate']}</td>
        <td>{$job['DeliveredDate']}</td>
        <td>{$job['FileClosed']}</td>
        <td>{$job['LabourHours']}</td>
        <td>{$job['MaterialCost']}</td>
        <td>{$job['TypeOfWork']}</td>
        <td>{$job['Remarks']}</td>
    </tr>";
}

// Prepare pagination links
$pagination = '';
for ($i = 1; $i <= $totalPages; $i++) {
    $pagination .= "<a href='#' class='pagination-link" . ($i == $page ? " active" : "") . "' data-page='$i'>$i</a>";
}

echo json_encode([
    'tableData' => $tableData,
    'pagination' => $pagination
]);
?>
