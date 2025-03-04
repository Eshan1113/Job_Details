<?php

require_once '../db_conn.php';

// Get the search input from the user, if any
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$inspectionStatusFilter = isset($_GET['inspectionStatus']) ? $_GET['inspectionStatus'] : '';
$jobStatusFilter = isset($_GET['jobStatus']) ? $_GET['jobStatus'] : '';
$typeOfWorkFilter = isset($_GET['typeOfWork']) ? $_GET['typeOfWork'] : '';
$dateAuditFilter = isset($_GET['dateAudit']) ? $_GET['dateAudit'] : '';
$ncrRaisedFilter = isset($_GET['ncrRaised']) ? $_GET['ncrRaised'] : ''; // New NCR Raised filter


// Pagination: Show 10 records per page
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Create a base SQL query with conditions based on the search filters
$sql = "SELECT * FROM iso_audit_details WHERE 1=1";

// Apply search filters
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

// Apply new filters for NCR Raised and NCR Specify
if ($ncrRaisedFilter) {
    $sql .= " AND ncr_raised LIKE '%$ncrRaisedFilter%'";
}


// Apply pagination to the SQL query
$sql .= " LIMIT $start, $limit";

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

// Get the total number of matching records for pagination
$total_sql = "SELECT COUNT(*) FROM iso_audit_details WHERE 1=1";

// Apply search filters to the total query
if ($searchTerm) {
    $total_sql .= " AND (DTJobNumber LIKE '%$searchTerm%' OR TypeOfWork LIKE '%$searchTerm%' OR inspection_status LIKE '%$searchTerm%' OR jobs_status LIKE '%$searchTerm%')";
}

if ($inspectionStatusFilter) {
    $total_sql .= " AND inspection_status LIKE '%$inspectionStatusFilter%'";
}

if ($jobStatusFilter) {
    $total_sql .= " AND jobs_status LIKE '%$jobStatusFilter%'";
}

if ($typeOfWorkFilter) {
    $total_sql .= " AND TypeOfWork LIKE '%$typeOfWorkFilter%'";
}

if ($dateAuditFilter) {
    $total_sql .= " AND date_audited LIKE '%$dateAuditFilter%'";
}

// Apply new filters for NCR Raised and NCR Specify to the total query
if ($ncrRaisedFilter) {
    $total_sql .= " AND ncr_raised LIKE '%$ncrRaisedFilter%'";
}



// Execute the query for total rows
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_array()[0];

$conn->close();

// Generate the table rows HTML dynamically
$tableRows = '';
if (count($records) > 0) {
    foreach ($records as $row) {
        $tableRows .= "<tr>
                <td class='py-2 px-6'>" . htmlspecialchars($row['date_audited']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['DTJobNumber']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['TypeOfWork']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['inspection_status']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['jobs_status']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['auditor_name']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['job_order_issued_by_fm']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['master_job_files_avail']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['spec_sheets_and_all_fabr_drawings']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['complete_set_of_qa_forms']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['physical_pro_percent']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['qa_pro_percent']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['tank_joining_report']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['manhole_test_report']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['tank_test_report']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['valve_body_test_report']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['valve_test_report']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['letter_to_chassis_manufacturer']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['fire_extinguisher_report']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['axel_alignment_test_report']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['pressure_test_report']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['aeration_test_report']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['calibration_chart']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['final_check_list_inspection_report']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['labour_hours_sheet']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['all_inspection_reports_signed']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['critical_doc_signed']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['delivery_details_attach']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['customer_feedback_attach']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['service_at_cost']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['all_reports_signed']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['ncr_raised']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['ncr_specify']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['auditor_comments']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['extra_works_attached']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['if_no_specify']) . "</td>
                <td class='py-2 px-6'>" . htmlspecialchars($row['overall_satisfaction']) . "</td>
            </tr>";
    }
} else {
    $tableRows .= "<tr><td colspan='34' class='text-center py-2'>No records found</td></tr>";
}

// Return both the table rows and total records count as a JSON object
echo json_encode([
    'tableRows' => $tableRows,
    'totalRecords' => $total_rows
]);
?>