<?php
require_once '../db_conn.php';

// Retrieve filter values from POST request
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
$inspectionStatusFilter = isset($_POST['inspectionStatus']) ? $_POST['inspectionStatus'] : '';
$jobStatusFilter = isset($_POST['jobStatus']) ? $_POST['jobStatus'] : '';
$typeOfWorkFilter = isset($_POST['typeOfWork']) ? $_POST['typeOfWork'] : '';
$dateAuditFilter = isset($_POST['dateAudit']) ? $_POST['dateAudit'] : '';

// Retrieve selected columns from POST request
$selectedColumns = isset($_POST['columns']) ? $_POST['columns'] : [];

// Create a base SQL query with conditions based on the search filters
$sql = "SELECT * FROM iso_audit_details WHERE 1=1";

// Apply search filters (same filters as in your table query)
if ($searchTerm) {
    $sql .= " AND (DTJobNumber LIKE '%$searchTerm%' OR TypeOfWork LIKE '%$searchTerm%' OR inspection_status LIKE '%$searchTerm%' OR jobs_status LIKE '%$searchTerm%')";
}

if ($inspectionStatusFilter) {
    $sql .= " AND inspection_status LIKE '%$inspectionStatusFilter%'";
}

if ($jobStatusFilter) {
    $sql .= " AND jobs_status LIKE '%$jobStatusFilter%'";
}

if ($typeOfWorkFilter) {
    $sql .= " AND TypeOfWork LIKE '%$typeOfWorkFilter%'";
}

if ($dateAuditFilter) {
    $sql .= " AND date_audited LIKE '%$dateAuditFilter%'";
}

// Execute the query
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query($sql);

$records = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}

$conn->close();

// Generate Excel file
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="iso_audit_details.xls"');

echo "<table border='1'>";
echo "<tr>";
foreach ($selectedColumns as $column) {
    echo "<th>" . ucfirst(str_replace('_', ' ', $column)) . "</th>";
}
echo "</tr>";

foreach ($records as $row) {
    echo "<tr>";
    foreach ($selectedColumns as $column) {
        echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

?>
