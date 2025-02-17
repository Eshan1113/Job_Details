<?php
include_once 'include/header.php';
require_once '../db_conn.php';

// Get the search input from the user, if any
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$inspectionStatusFilter = isset($_GET['inspectionStatus']) ? $_GET['inspectionStatus'] : '';
$jobStatusFilter = isset($_GET['jobStatus']) ? $_GET['jobStatus'] : '';
$typeOfWorkFilter = isset($_GET['typeOfWork']) ? $_GET['typeOfWork'] : '';

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

$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_array()[0];
$total_pages = ceil($total_rows / $limit);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISO Audit Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Function for real-time search across all columns
        function searchTable() {
            const searchInput = document.getElementById('searchInput');
            const filter = searchInput.value.toLowerCase();
            window.location.href = "?search=" + filter + "&inspectionStatus=" + document.getElementById('inspectionStatus').value + "&jobStatus=" + document.getElementById('jobStatus').value + "&typeOfWork=" + document.getElementById('typeOfWork').value;
        }

        function filterByInspectionStatus() {
            searchTable();
        }

        function filterByJobStatus() {
            searchTable();
        }

        function filterByTypeOfWork() {
            searchTable();
        }

        // Show the export modal
        document.getElementById('exportBtn').addEventListener('click', function () {
            document.getElementById('exportModal').classList.remove('hidden');
        });

        // Close the modal
        function closeModal() {
            document.getElementById('exportModal').classList.add('hidden');
        }
    </script>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-5">
        <h1 class="text-3xl font-bold text-center mb-4">ISO Audit Details</h1>

        <!-- Search Bar and Filters -->
        <div class="mb-4 flex justify-between items-center">
            <input type="text" id="searchInput" onkeyup="searchTable()"
                class="px-4 py-2 border border-gray-300 rounded-md w-1/4"
                placeholder="Search by Job Number, Type, Status..." value="<?= htmlspecialchars($searchTerm) ?>" />

            <input type="text" id="typeOfWork" onkeyup="filterByTypeOfWork()"
                class="px-4 py-2 border border-gray-300 rounded-md w-1/4" placeholder="Search by Type of Work"
                value="<?= htmlspecialchars($typeOfWorkFilter) ?>" />

            <select id="inspectionStatus" class="px-4 py-2 border border-gray-300 rounded-md w-1/4"
                onchange="filterByInspectionStatus()">
                <option value="">Select Inspection Status</option>
                <option value="completed" <?= ($inspectionStatusFilter == 'completed') ? 'selected' : '' ?>>Completed
                </option>
                <option value="ongoing" <?= ($inspectionStatusFilter == 'ongoing') ? 'selected' : '' ?>>Ongoing</option>
            </select>

            <select id="jobStatus" class="px-4 py-2 border border-gray-300 rounded-md w-1/4"
                onchange="filterByJobStatus()">
                <option value="">Select Job Status</option>
                <option value="new" <?= ($jobStatusFilter == 'new') ? 'selected' : '' ?>>New</option>
                <option value="repair" <?= ($jobStatusFilter == 'repair') ? 'selected' : '' ?>>Repair</option>
            </select>
        </div>

        <!-- Export to Excel Button -->
        <button id="exportBtn" class="px-4 py-2 bg-green-500 text-white rounded-md mt-4">Export to Excel</button>
        <br>
        <!-- Modal for column selection -->
        <!-- Modal for column selection -->
        <div id="exportModal"
            class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-1/3 grid gap-4 max-h-[80vh] overflow-y-auto">
                <h2 class="text-2xl mb-4">Select Columns to Export</h2>
                <form id="exportForm" method="POST" action="export.php" class="grid gap-4">
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="date_audited" checked> Date Audit
                        </label>
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="DTJobNumber" checked> Job Number
                        </label>
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="TypeOfWork" checked> Type of Work
                        </label>
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="overall_satisfaction" checked> Overall
                            Satisfaction
                        </label>
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="inspection_status" checked> Inspection Status
                        </label>
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="jobs_status" checked> Job Status
                        </label>
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="auditor_name" checked> Auditor Name
                        </label>
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="job_order_issued_by_fm" checked> Job Order
                            Issued by FM
                        </label>
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="master_job_files_avail" checked> Master Job
                            Files Available
                        </label>
                    </div>
                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="spec_sheets_and_all_fabr_drawings" checked>
                            Spec Sheets and All Drawings
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="complete_set_of_qa_forms" checked> QA Forms
                            Complete
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="physical_pro_percent" checked> Physical Pro
                            Percent
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="qa_pro_percent" checked> QA Pro Percent
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="tank_joining_report" checked> Tank Joining
                            Report
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="manhole_test_report" checked> Manhole Test
                            Report
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="tank_test_report" checked> Tank Test Report
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="valve_body_test_report" checked> Valve Body
                            Test Report
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="valve_test_report" checked> Valve Test Report
                        </label>
                    </div>


                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="letter_to_chassis_manufacturer" checked>
                            Letter to Chassis Manufacturer
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="fire_extinguisher_report" checked> Fire
                            Extinguisher Report
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="axel_alignment_test_report" checked> Axel
                            Alignment Test Report
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="pressure_test_report" checked> Pressure Test
                            Report
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="aeration_test_report" checked> Aeration Test
                            Report
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="calibration_chart" checked> Calibration Chart
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="final_check_list_inspection_report" checked>
                            Final Check List Inspection Report
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="labour_hours_sheet" checked> Labour Hours
                            Sheet
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="all_inspection_reports_signed" checked> All
                            Inspection Reports Signed
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="critical_doc_signed" checked> Critical Docs
                            Signed
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="delivery_details_attach" checked> Delivery
                            Details Attached
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="customer_feedback_attach" checked> Customer
                            Feedback Attached
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="service_at_cost" checked> Service at Cost
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="all_reports_signed" checked> All Reports
                            Signed
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="ncr_raised" checked> NCR Raised
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="ncr_specify" checked> NCR Specify
                        </label>
                    </div>


                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="auditor_comments" checked> Auditor Comments
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="extra_works_attached" checked> Extra Works
                            Attached
                        </label>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="columns[]" value="if_no_specify" checked> If No, Specify
                        </label>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Download</button>
                </form>
                <button onclick="closeModal()" class="px-4 py-2 bg-red-500 text-white rounded-md mt-4">Close</button>
            </div>
        </div>
        <br> <!-- Table with Scroll -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-6 text-left">Date Audit</th>
                        <th class="py-3 px-6 text-left">Job Number</th>
                        <th class="py-3 px-6 text-left">Type of Work</th>
                        <th class="py-3 px-6 text-left">Inspection Status</th>
                        <th class="py-3 px-6 text-left">Job Status</th>
                        <th class="py-3 px-6 text-left">Auditor</th>
                        <th class="py-3 px-6 text-left">Job Order Issued by FM</th>
                        <th class="py-3 px-6 text-left">Master Job Files Available</th>
                        <th class="py-3 px-6 text-left">Spec Sheets and All Drawings</th>
                        <th class="py-3 px-6 text-left">QA Forms Complete</th>
                        <th class="py-3 px-6 text-left">Physical Pro Percent</th>
                        <th class="py-3 px-6 text-left">QA Pro Percent</th>
                        <th class="py-3 px-6 text-left">Tank Joining Report</th>
                        <th class="py-3 px-6 text-left">Manhole Test Report</th>
                        <th class="py-3 px-6 text-left">Tank Test Report</th>
                        <th class="py-3 px-6 text-left">Valve Body Test Report</th>
                        <th class="py-3 px-6 text-left">Valve Test Report</th>
                        <th class="py-3 px-6 text-left">Letter to Chassis Manufacturer</th>
                        <th class="py-3 px-6 text-left">Fire Extinguisher Report</th>
                        <th class="py-3 px-6 text-left">Axel Alignment Test Report</th>
                        <th class="py-3 px-6 text-left">Pressure Test Report</th>
                        <th class="py-3 px-6 text-left">Aeration Test Report</th>
                        <th class="py-3 px-6 text-left">Calibration Chart</th>
                        <th class="py-3 px-6 text-left">Final Check List Inspection Report</th>
                        <th class="py-3 px-6 text-left">Labour Hours Sheet</th>
                        <th class="py-3 px-6 text-left">All Inspection Reports Signed</th>
                        <th class="py-3 px-6 text-left">Critical Docs Signed</th>
                        <th class="py-3 px-6 text-left">Delivery Details Attached</th>
                        <th class="py-3 px-6 text-left">Customer Feedback Attached</th>
                        <th class="py-3 px-6 text-left">Service at Cost</th>
                        <th class="py-3 px-6 text-left">All Reports Signed</th>
                        <th class="py-3 px-6 text-left">NCR Raised</th>
                        <th class="py-3 px-6 text-left">NCR Specify</th>
                        <th class="py-3 px-6 text-left">Attachment</th>
                        <th class="py-3 px-6 text-left">Auditor Comments</th>
                        <th class="py-3 px-6 text-left">Extra Works Attached</th>
                        <th class="py-3 px-6 text-left">If No, Specify</th>
                        <th class="py-3 px-6 text-left">Overall Satisfaction</th>
                    </tr>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $row): ?>
                        <tr>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['date_audited']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['DTJobNumber']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['TypeOfWork']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['inspection_status']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['jobs_status']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['auditor_name']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['job_order_issued_by_fm']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['master_job_files_avail']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['spec_sheets_and_all_fabr_drawings']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['complete_set_of_qa_forms']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['physical_pro_percent']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['qa_pro_percent']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['tank_joining_report']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['manhole_test_report']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['tank_test_report']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['valve_body_test_report']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['valve_test_report']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['letter_to_chassis_manufacturer']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['fire_extinguisher_report']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['axel_alignment_test_report']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['pressure_test_report']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['aeration_test_report']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['calibration_chart']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['final_check_list_inspection_report']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['labour_hours_sheet']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['all_inspection_reports_signed']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['critical_doc_signed']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['delivery_details_attach']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['customer_feedback_attach']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['service_at_cost']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['all_reports_signed']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['ncr_raised']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['ncr_specify']) ?></td>
                            <td class="py-2 px-6">

                                <?php if (!empty($row['attachment'])): ?>
                                    <a href="file_download.php?file=<?= urlencode($row['attachment']) ?>"
                                        class="text-blue-500 hover:underline" download>Download Attachment</a>
                                <?php else: ?>
                                    No Attachment
                                <?php endif; ?>
                            </td>

                            <td class="py-2 px-6"><?= htmlspecialchars($row['auditor_comments']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['extra_works_attached']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['if_no_specify']) ?></td>
                            <td class="py-2 px-6"><?= htmlspecialchars($row['overall_satisfaction']) ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Display total matching records -->
        <div class="mt-4 text-center">
            <p class="text-gray-600">Total matching records: <?= $total_rows ?></p>
        </div>

        <!-- Pagination -->
        <div class="mt-4 text-center">
            <ul class="inline-flex items-center">
                <?php if ($page > 1): ?>
                    <li><a href="?page=<?= $page - 1 ?>&search=<?= urlencode($searchTerm) ?>&inspectionStatus=<?= urlencode($inspectionStatusFilter) ?>&jobStatus=<?= urlencode($jobStatusFilter) ?>&typeOfWork=<?= urlencode($typeOfWorkFilter) ?>"
                            class="px-4 py-2 bg-blue-500 text-white rounded-l">Prev</a></li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li><a href="?page=<?= $i ?>&search=<?= urlencode($searchTerm) ?>&inspectionStatus=<?= urlencode($inspectionStatusFilter) ?>&jobStatus=<?= urlencode($jobStatusFilter) ?>&typeOfWork=<?= urlencode($typeOfWorkFilter) ?>"
                            class="px-4 py-2 border"><?= $i ?></a></li>
                <?php endfor; ?>
                <?php if ($page < $total_pages): ?>
                    <li><a href="?page=<?= $page + 1 ?>&search=<?= urlencode($searchTerm) ?>&inspectionStatus=<?= urlencode($inspectionStatusFilter) ?>&jobStatus=<?= urlencode($jobStatusFilter) ?>&typeOfWork=<?= urlencode($typeOfWorkFilter) ?>"
                            class="px-4 py-2 bg-blue-500 text-white rounded-r">Next</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <script>
        // Show the export modal when the button is clicked
        document.getElementById('exportBtn').addEventListener('click', function () {
            document.getElementById('exportModal').classList.remove('hidden');
        });

        // Close the modal
        function closeModal() {
            document.getElementById('exportModal').classList.add('hidden');
        }



    </script>

</body>

</html>