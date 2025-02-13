<?php
require '../vendor/autoload.php'; // Include PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['columns'])) {
    // Get selected columns from the form
    $selectedColumns = $_POST['columns'];

    // Include database connection
    include_once '../db_conn.php';

    // Build SQL query based on selected columns
    $columns = implode(', ', $selectedColumns);
    $sql = "SELECT $columns FROM iso_audit_details WHERE 1=1"; // Always start with WHERE 1=1 to make appending conditions easier

    // Apply filters based on GET parameters from view.php
    if (isset($_GET['search']) && $_GET['search'] !== '') {
        $searchTerm = $_GET['search'];
        $sql .= " AND (DTJobNumber LIKE '%$searchTerm%' OR TypeOfWork LIKE '%$searchTerm%' OR inspection_status LIKE '%$searchTerm%' OR jobs_status LIKE '%$searchTerm%')";
    }

    if (isset($_GET['inspectionStatus']) && $_GET['inspectionStatus'] !== '') {
        $inspectionStatusFilter = $_GET['inspectionStatus'];
        $sql .= " AND inspection_status LIKE '%$inspectionStatusFilter%'";
    }

    if (isset($_GET['jobStatus']) && $_GET['jobStatus'] !== '') {
        $jobStatusFilter = $_GET['jobStatus'];
        $sql .= " AND jobs_status LIKE '%$jobStatusFilter%'";
    }

    if (isset($_GET['typeOfWork']) && $_GET['typeOfWork'] !== '') {
        $typeOfWorkFilter = $_GET['typeOfWork'];
        $sql .= " AND TypeOfWork LIKE '%$typeOfWorkFilter%'";
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

    // Create a new spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers
    $columnIndex = 1;
    foreach ($selectedColumns as $column) {
        // Set headers for the columns
        $columnLetter = PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
        $sheet->setCellValue("{$columnLetter}1", ucfirst(str_replace('_', ' ', $column)));
        $columnIndex++;
    }

    // Write data to the spreadsheet
    $rowIndex = 2;
    foreach ($records as $record) {
        $columnIndex = 1;
        foreach ($selectedColumns as $column) {
            $columnLetter = PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
            $sheet->setCellValue("{$columnLetter}{$rowIndex}", $record[$column]);
            $columnIndex++;
        }
        $rowIndex++;
    }

    // Generate the Excel file and send it to the browser
    $writer = new Xlsx($spreadsheet);
    $filename = 'iso_audit_details_filtered.xlsx'; // Add 'filtered' to indicate that it's a filtered export

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}
?>
