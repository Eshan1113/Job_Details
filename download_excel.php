<?php
include('db_conn.php');

// Check if columns are selected
if (empty($_POST['columns'])) {
    echo "No columns selected.";
    exit;
}

// Sanitize and prepare selected columns
$selectedColumns = array_map(function ($col) {
    return preg_replace('/[^a-zA-Z0-9_]/', '', $col); // Ensure valid column names
}, $_POST['columns']);
$columnsList = implode(", ", $selectedColumns);

// Prepare SQL query with selected columns
$sql = "SELECT $columnsList FROM jayantha_1500_table";
try {
    $stmt = $pdo->query($sql);
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching data: " . $e->getMessage();
    exit;
}

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=selected_columns.xls");

// Generate Excel file
echo "<table border='1'>";
echo "<tr>";

// Add column headers
foreach ($selectedColumns as $column) {
    echo "<th>" . htmlspecialchars($column) . "</th>";
}
echo "</tr>";

// Add data rows
foreach ($jobs as $job) {
    echo "<tr>";
    foreach ($selectedColumns as $column) {
        echo "<td>" . htmlspecialchars($job[$column]) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
 