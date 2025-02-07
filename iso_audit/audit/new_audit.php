<?php
include_once "../include/header.php"; // Start the session to store session data

// Initialize an array to capture errors
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // --- Basic Validations ---
    if (empty($_POST['date_audited'])) {
        $errors[] = "Date Audited is required.";
    }
    if (empty($_POST['inspection_status'])) {
        $errors[] = "Inspection Status is required.";
    }
    if (empty($_POST['job_status'])) {
        $errors[] = "Job Status is required.";
    }
    if (empty($_POST['TypeOfWork'])) {
        $errors[] = "Type of Work is required.";
    }
    if (empty($_POST['DTJobNumber'])) {
        $errors[] = "DT Job Number is required.";
    }

    // Only proceed if no validation errors
    if (count($errors) === 0) {
        // Store session variables safely
        $_SESSION['date_audited']       = $_POST['date_audited'];
        $_SESSION['inspection_status']  = $_POST['inspection_status'];
        $_SESSION['job_status']         = $_POST['job_status'];
        $_SESSION['TypeOfWork']         = $_POST['TypeOfWork'];
        $_SESSION['DTJobNumber']        = $_POST['DTJobNumber'];

        // Prepare for redirection
        $inspectionStatus   = $_SESSION['inspection_status'];
        $selectedTypeOfWork = $_SESSION['TypeOfWork'];

        // Define redirection map based on inspection status and TypeOfWork
        $redirectionMap = [
            'completed' => [
                'BTF-N'  => 'Completed/N-BTF.php',
                'BTF-R'  => 'Completed/R-BTF.php',
                'BTW-N'  => 'Completed/N-BTW.php',
                'BTW-R'  => 'Completed/R-BTW.php',
                'CBT-N'  => 'Completed/N-CBT.php',
                'CBT-R'  => 'Completed/R-CBT.php',
                'FBT-N'  => 'Completed/N-FBT.php',
                'FBT-R'  => 'Completed/R-FBT.php',
                'FBC-N'  => 'Completed/N-FBC.php',
                'FBC-R'  => 'Completed/R-FBC.php',
                'GFW-G'  => 'Completed/GFW-G.php',
                'GFW-P'  => 'Completed/GFW-P.php',
                'SILO-N' => 'Completed/N-SILO.php',
                'SILO-R' => 'Completed/R-SILO.php',
                'STA-N'  => 'Completed/N-STA.php',
                'STU-N'  => 'Completed/N-STU.php',
                'BTO-N'  => 'Completed/N-BTO.php',
                'BTO-R'  => 'Completed/R-BTO.php',
            ],
            'ongoing' => [
                'BTF-N'  => 'Ongoing/N-BTF.php',
                'BTF-R'  => 'Ongoing/R-BTF.php',
                'BTW-N'  => 'Ongoing/N-BTW.php',
                'BTW-R'  => 'Ongoing/R-BTW.php',
                'CBT-N'  => 'Ongoing/N-CBT.php',
                'CBT-R'  => 'Ongoing/R-CBT.php',
                'FBT-N'  => 'Ongoing/N-FBT.php',
                'FBT-R'  => 'Ongoing/R-FBT.php',
                'FBC-N'  => 'Ongoing/N-FBC.php',
                'FBC-R'  => 'Ongoing/R-FBC.php',
                'GFW-G'  => 'Ongoing/GFW-G.php',
                'GFW-P'  => 'Ongoing/GFW-P.php',
                'SILO-N' => 'Ongoing/N-SILO.php',
                'SILO-R' => 'Ongoing/R-SILO.php',
                'STA-N'  => 'Ongoing/N-STA.php',
                'STU-N'  => 'Ongoing/N-STU.php',
                'BTO-N'  => 'Ongoing/N-BTO.php',
                'BTO-R'  => 'Ongoing/R-BTO.php',
            ]
        ];

        // Check if we have a matching redirection
        if (isset($redirectionMap[$inspectionStatus][$selectedTypeOfWork])) {
            // Redirect to the correct page based on the selection
            header('Location: ' . $redirectionMap[$inspectionStatus][$selectedTypeOfWork]);
            exit;
        } else {
            echo "Invalid TypeOfWork or Inspection Status selection!";
        }
    }
}

// Database connection (adjust the path if necessary)
require_once '../db_conn.php';

// Fetch job numbers and work types from the database
$query = "SELECT work_type FROM type_of_work";
$stmt = $pdo->query($query);
$type_of_work = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISO Audit Form</title>

    <link href="../../css/tailwind.min.css" rel="stylesheet">
    <link href="../../css/all.min.css" rel="stylesheet">
    <link href="../../css/select2.min.css" rel="stylesheet" />

    <script src="../../css/jquery-3.6.0.min.js"></script>
    <script src="../../css/select2.min.js"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-xl">
        <h1 class="text-3xl font-bold mb-8 text-blue-600 border-b-2 border-blue-200 pb-4">ISO Audit Form</h1>

        <!-- Display any validation errors (if exist) -->
        <?php if (!empty($errors)): ?>
            <div class="mb-4 p-4 bg-red-50 rounded-lg border border-red-200">
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-600 font-semibold">
                        <i class="fa fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="new_audit.php" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Date Audited -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Date Audited</label>
                    <input type="date" name="date_audited" value="<?= date('Y-m-d') ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Inspection Status -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Inspection Status</label>
                    <select name="inspection_status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="" disabled selected>Select status...</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <!-- TypeOfWork -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Type of Work</label>
                    <select name="TypeOfWork"
                            class="type-select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="" disabled selected>Select work type...</option>
                        <?php foreach ($type_of_work as $work): ?>
                            <option value="<?= htmlspecialchars($work['work_type']) ?>">
                                <?= htmlspecialchars($work['work_type']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- DTJobNumber -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">DT Job Number</label>
                <select name="DTJobNumber" class="dt-select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="" disabled selected>Select job number...</option>
                    <!-- Job numbers will be dynamically populated here via AJAX -->
                </select>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 mt-8">
                <button type="button" onclick="window.history.back();"
                        class="px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Back
                </button>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Continue to Audit Form
                </button>
            </div>
        </form>
    </div>

    <script>
       $(document).ready(function () {
    // Initialize select2 for job number dropdown
    $('.dt-select2').select2({
        placeholder: 'Select job number...',
        allowClear: true,
        minimumResultsForSearch: 2
    });

    // Initialize select2 for work type dropdown
    $('.type-select2').select2({
        placeholder: 'Select work type...',
        allowClear: true
    });

    // Listen for changes in the Type of Work
    $('select[name="TypeOfWork"]').on('change', function () {
        var selectedTypeOfWork = $(this).val();

        // Fetch and update job numbers based on selected TypeOfWork
        $.ajax({
            url: 'get_job_number.php',
            method: 'POST',
            data: { TypeOfWork: selectedTypeOfWork },
            success: function (response) {
                var jobs = JSON.parse(response); // Parse the JSON response
                var jobSelect = $('select[name="DTJobNumber"]');
                jobSelect.empty(); // Clear existing job numbers
                jobSelect.append('<option value="" disabled selected>Select job number...</option>'); // Add default option

                // Add relevant job numbers to the dropdown
                if (jobs.length > 0) {
                    jobs.forEach(function(job) {
                        jobSelect.append('<option value="' + job.DTJobNumber + '">' + job.DTJobNumber + '</option>');
                    });
                } else {
                    jobSelect.append('<option value="" disabled>No job numbers available</option>');
                }

                // Reinitialize select2
                jobSelect.trigger('change');
            },
            error: function () {
                alert('Error loading job numbers.');
            }
        });
    });
});

    </script>
</body>

</html>
