<?php
// Assuming you're using PHP to retrieve data from the database

// Create a connection to your database
require_once '../db_conn.php';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all records from the iso_audit_details table
$sql = "SELECT * FROM iso_audit_details";
$result = $conn->query($sql);

$records = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}

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
        function searchTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            
            rows.forEach(row => {
                let cells = row.getElementsByTagName('td');
                let match = false;
                
                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].innerText.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
                
                if (match) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterByJobType() {
            const jobType = document.getElementById('jobType').value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            
            rows.forEach(row => {
                const jobTypeCell = row.cells[2].innerText.toLowerCase();
                if (jobTypeCell.indexOf(jobType) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterByStatus() {
            const status = document.getElementById('inspectionStatus').value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            
            rows.forEach(row => {
                const statusCell = row.cells[3].innerText.toLowerCase();
                if (statusCell.indexOf(status) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function filterByJobStatus() {
            const jobStatus = document.getElementById('jobStatus').value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            
            rows.forEach(row => {
                const jobStatusCell = row.cells[4].innerText.toLowerCase();
                if (jobStatusCell.indexOf(jobStatus) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-5">
        <h1 class="text-3xl font-bold text-center mb-4">ISO Audit Details</h1>

        <!-- Search Bar and Filters -->
        <div class="mb-4 flex justify-between items-center">
            <input
                type="text"
                id="searchInput"
                onkeyup="searchTable()"
                class="px-4 py-2 border border-gray-300 rounded-md w-1/4"
                placeholder="Search by Job Number, Type, Status..."
            />
            
            <select id="jobType" class="px-4 py-2 border border-gray-300 rounded-md w-1/4" onchange="filterByJobType()">
                <option value="">Select Job Type</option>
                <option value="new">New</option>
                <option value="repair">Repair</option>
            </select>

            <select id="inspectionStatus" class="px-4 py-2 border border-gray-300 rounded-md w-1/4" onchange="filterByStatus()">
                <option value="">Select Inspection Status</option>
                <option value="completed">Completed</option>
                <option value="ongoing">Ongoing</option>
            </select>

            <select id="jobStatus" class="px-4 py-2 border border-gray-300 rounded-md w-1/4" onchange="filterByJobStatus()">
                <option value="">Select Job Status</option>
                <option value="new">New</option>
                <option value="repair">Repair</option>
            </select>
        </div>

        <!-- Table -->
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
                        <td class="py-2 px-6"><?= htmlspecialchars($row['attachment']) ?></td>
                        <td class="py-2 px-6"><?= htmlspecialchars($row['auditor_comments']) ?></td>
                        <td class="py-2 px-6"><?= htmlspecialchars($row['extra_works_attached']) ?></td>
                        <td class="py-2 px-6"><?= htmlspecialchars($row['if_no_specify']) ?></td>
                        <td class="py-2 px-6"><?= htmlspecialchars($row['overall_satisfaction']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
