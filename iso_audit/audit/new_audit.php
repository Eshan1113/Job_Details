<?php
session_start();
require_once '../db_conn.php'; // Adjust the path to your database connection file

// Fetch DTJobNumber from the `jayantha_1500_table`
$query = "SELECT DTJobNumber FROM jayantha_1500_table";
$stmt = $pdo->query($query);
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch distinct TypeOfWork from the `type_of_work` table
$query = "SELECT work_type FROM type_of_work"; // Get all work types from the type_of_work table
$stmt = $pdo->query($query);
$type_of_work = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Searchable Dropdown</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>

<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Searchable Dropdown Form</h2>

        <form action="process_audit.php" method="POST">
            <!-- Date Audited -->
            <div class="mb-4">
                <label for="date_audited" class="block text-sm font-semibold text-gray-700">Date Audited</label>
                <input type="date" name="date_audited" id="date_audited" value="<?php echo date('Y-m-d'); ?>"
                    class="mt-1 p-2 w-full border rounded-md" required>
            </div>

            <!-- Job Status -->
            <div class="mb-4">
                <label for="job_status" class="block text-sm font-semibold text-gray-700">Inspection Status</label>
                <select name="job_status" id="job_status" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Complete">Complete</option>
                </select>
            </div>

            <!-- Job Status (New/Repair) -->
            <div class="mb-4">
                <label for="job_status" class="block text-sm font-semibold text-gray-700">Job Status</label>
                <select name="job_status" id="job_status" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="New">New</option>
                    <option value="Repair">Repair</option>
                </select>
            </div>

            <!-- Searchable DTJobNumber Dropdown -->
            <div class="mb-4">
                <label for="DTJobNumber" class="block text-sm font-semibold text-gray-700">DTJobNumber</label>
                <select name="DTJobNumber" id="DTJobNumber" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="" disabled selected>Select a DTJobNumber</option>
                    <?php foreach ($jobs as $job): ?>
                        <option value="<?php echo htmlspecialchars($job['DTJobNumber']); ?>">
                            <?php echo htmlspecialchars($job['DTJobNumber']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Dynamic TypeOfWork Dropdown -->
            <div class="mb-4">
                <label for="TypeOfWork" class="block text-sm font-semibold text-gray-700">Type Of Work</label>
                <select name="TypeOfWork" id="TypeOfWork" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="" disabled selected>Select a Type Of Work</option>
                    <?php foreach ($type_of_work as $work): ?>
                        <option value="<?php echo htmlspecialchars($work['work_type']); ?>">
                            <?php echo htmlspecialchars($work['work_type']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Yes/No Fields -->
            <?php
            $fields = [
                "job_order_issued_by_fm",
                "master_job_files_avail",
                "spec_sheets_and_all_fabr_drawings",
                "complete_set_of_qa_forms",
                "tank_joining_report",
                "manhole_test_report",
                "tank_test_report",
                "valve_body_test_report",
                "valve_test_report",
                "letter_to_chassis_manufacturer",
                "fire_extinguisher_report",
                "axel_alignment_test_report",
                "pressure_test_report",
                "aeration_test_report",
                "Calibration_Chart",
                "final_check_list_inspection_report",
                "labour_hours_sheet",
                "all_inspection_reports_signed",
                "critical_doc_signed",
                "delivery_details_attach",
                "customer_feedback_atta",
                "service_at_cost",
                "all_reports_signed",
                "extra_works_attached",
                "ncr_raised"
            ];
            foreach ($fields as $field) {
                echo "
                    <div class='mb-4'>
                        <label class='block text-sm font-semibold text-gray-700'>" . ucfirst(str_replace('_', ' ', $field)) . "</label>
                        <label><input type='radio' name='$field' value='Yes' required> Yes</label>
                        <label><input type='radio' name='$field' value='No'> No</label>
                    </div>
                ";
            }
            ?>

            <!-- Physical Production % -->
            <div class="mb-4">
                <label for="physical_pro_percentage" class="block text-sm font-semibold text-gray-700">Physical Production %</label>
                <input type="number" name="physical_pro_percentage" id="physical_pro_percentage" min="0" max="100" step="0.1" class="mt-1 p-2 w-full border rounded-md" placeholder="Enter percentage (0-100)" required>
            </div>

            <!-- QA Production % -->
            <div class="mb-4">
                <label for="qa_pro_percentage" class="block text-sm font-semibold text-gray-700">QA Production %</label>
                <input type="number" name="qa_pro_percentage" id="qa_pro_percentage" min="0" max="100" step="0.1" class="mt-1 p-2 w-full border rounded-md" placeholder="Enter percentage (0-100)" required>
            </div>

            <!-- Specific Fields -->
            <div class="mb-4">
                <label for="specify_if_no" class="block text-sm font-semibold text-gray-700">If No, Specify</label>
                <input type="text" name="specify_if_no" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Extra Works Attached -->
            <div class="mb-4">
                <label for="extra_works_attached" class="block text-sm font-semibold text-gray-700">Extra Works Attached</label>
                <label><input type="radio" name="extra_works_attached" value="Yes" required> Yes</label>
                <label><input type="radio" name="extra_works_attached" value="No"> No</label>
            </div>

            <!-- Overall Satisfaction -->
            <div class="mb-4">
                <label for="overall_satisfaction" class="block text-sm font-semibold text-gray-700">Overall Satisfaction</label>
                <select name="overall_satisfaction" id="overall_satisfaction" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="V.good">V.good</option>
                    <option value="Good">Good</option>
                    <option value="Fair">Fair</option>
                    <option value="V.bad">V.bad</option>
                </select>
            </div>

            <!-- If NCR is raised, specify -->
            <div class="mb-4">
                <label for="ncr_specify" class="block text-sm font-semibold text-gray-700">If NCR Raised, Specify</label>
                <input type="text" name="ncr_specify" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Attachment -->
            <div class="mb-4">
                <label for="attachment" class="block text-sm font-semibold text-gray-700">Attachment</label>
                <input type="file" name="attachment" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <!-- Auditor Comments -->
            <div class="mb-4">
                <label for="auditor_comments" class="block text-sm font-semibold text-gray-700">Auditor Comments</label>
                <textarea name="auditor_comments" class="mt-1 p-2 w-full border rounded-md" rows="4"></textarea>
            </div>

            <!-- Auditor Name -->
            <div class="mb-4">
                <label for="auditor_name" class="block text-sm font-semibold text-gray-700">Auditor Name</label>
                <input type="text" name="auditor_name" id="auditor_name" class="mt-1 p-2 w-full border rounded-md" required>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 text-center">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Submit
                </button>
            </div>
        </form>
    </div>

    <!-- Initialize Select2 -->
    <script>
        $(document).ready(function () {
            // Enable Select2 for the dropdowns
            $('#DTJobNumber, #TypeOfWork, #job_status').select2({
                placeholder: 'Select an option',
                allowClear: true
            });
        });
    </script>
</body>

</html>
