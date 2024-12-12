<?php
include('db_conn.php');

$client = isset($_POST['client']) ? $_POST['client'] : '';
$jobNumber = isset($_POST['jobNumber']) ? $_POST['jobNumber'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
$toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : 1;

$limit = 10;
$start = ($page - 1) * $limit;

$sql = "SELECT * FROM jayantha_1500_table WHERE 1=1";

if (!empty($client)) {
    $sql .= " AND Client LIKE :client";
}
if (!empty($jobNumber)) {
    $sql .= " AND DTJobNumber LIKE :jobNumber";
}
if (!empty($year)) {
    $sql .= " AND Year = :year";
}
if (!empty($fromDate) && !empty($toDate)) {
    $sql .= " AND DateOpened BETWEEN :fromDate AND :toDate";
}

$sql .= " LIMIT :start, :limit";

$stmt = $pdo->prepare($sql);

if (!empty($client)) {
    $stmt->bindValue(':client', '%' . $client . '%');
}
if (!empty($jobNumber)) {
    $stmt->bindValue(':jobNumber', '%' . $jobNumber . '%');
}
if (!empty($year)) {
    $stmt->bindValue(':year', $year);
}
if (!empty($fromDate) && !empty($toDate)) {
    $stmt->bindValue(':fromDate', $fromDate);
    $stmt->bindValue(':toDate', $toDate);
}

$stmt->bindValue(':start', $start, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();

$jobs = $stmt->fetchAll();

// Total records for pagination
$totalQuery = "SELECT COUNT(*) FROM jayantha_1500_table WHERE 1=1";

if (!empty($client)) {
    $totalQuery .= " AND Client LIKE :client";
}
if (!empty($jobNumber)) {
    $totalQuery .= " AND DTJobNumber LIKE :jobNumber";
}
if (!empty($year)) {
    $totalQuery .= " AND Year = :year";
}
if (!empty($fromDate) && !empty($toDate)) {
    $totalQuery .= " AND DateOpened BETWEEN :fromDate AND :toDate";
}

$totalStmt = $pdo->prepare($totalQuery);

if (!empty($client)) {
    $totalStmt->bindValue(':client', '%' . $client . '%');
}
if (!empty($jobNumber)) {
    $totalStmt->bindValue(':jobNumber', '%' . $jobNumber . '%');
}
if (!empty($year)) {
    $totalStmt->bindValue(':year', $year);
}
if (!empty($fromDate) && !empty($toDate)) {
    $totalStmt->bindValue(':fromDate', $fromDate);
    $totalStmt->bindValue(':toDate', $toDate);
}

$totalStmt->execute();
$totalRecords = $totalStmt->fetchColumn();
$totalPages = ceil($totalRecords / $limit);

// Prepare table rows
$tableData = '';
foreach ($jobs as $job) {
    $tableData .= "<tr>
        <td>{$job['sr_no']}</td>
        <td>{$job['Year']}</td>
        <td>{$job['Month']}</td>
        <td>{$job['DTJobNumber']}</td>
        <td>{$job['HOJobNumber']}</td>
        <td>{$job['Client']}</td>
        <td>{$job['DateOpened']}</td>
        <td>{$job['DescriptionOfWork']}</td>
        <td>{$job['TARGET_DATE']}</td>
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
if ($page > 1) {
    $pagination .= '<a href="#" class="pagination-link" data-page="' . ($page - 1) . '">Previous</a>';
}
if ($page < $totalPages) {
    $pagination .= '<a href="#" class="pagination-link ml-2" data-page="' . ($page + 1) . '">Next</a>';
}

echo json_encode(['tableData' => $tableData, 'pagination' => $pagination]);
?>