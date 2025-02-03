<?php
include_once "../include/header.php"; // Start the session to store session data

// If form is submitted, store session variables
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['date_audited'] = $_POST['date_audited'];
    $_SESSION['inspection_status'] = $_POST['inspection_status'];
    $_SESSION['job_status'] = $_POST['job_status'];
    $_SESSION['DTJobNumber'] = $_POST['DTJobNumber'];
    $_SESSION['TypeOfWork'] = $_POST['TypeOfWork'];

    // Get the inspection status and type of work
    $inspectionStatus = $_SESSION['inspection_status'];
    $selectedTypeOfWork = $_SESSION['TypeOfWork'];

    // Define redirection map based on inspection status and TypeOfWork
    $redirectionMap = [
        'completed' => [
            'N-BTF' => 'Completed/N-BTF.php',
            'R-BTF' => 'Completed/R-BTF.php',
            'N-BTW' => 'Completed/N-BTW.php',
            'R-BTW' => 'Completed/R-BTW.php',
            'N-CBT' => 'Completed/N-CBT.php',
            'R-CBT' => 'Completed/R-CBT.php',
            'N-FBT' => 'Completed/N-FBT.php',
            'R-FBT' => 'Completed/R-FBT.php',
            'N-FBC' => 'Completed/N-FBC.php',
            'R-FBC' => 'Completed/R-FBC.php',
            'GFW-G' => 'Completed/GFW-G.php',
            'GFW-P' => 'Completed/GFW-P.php',
            'N-SILO' => 'Completed/N-SILO.php',
            'R-SILO' => 'Completed/R-SILO.php',
            'N-STA' => 'Completed/N-STA.php',
            'N-STU' => 'Completed/N-STU.php',
            'N-BTO' => 'Completed/N-BTO.php',
            'R-BTO' => 'Completed/R-BTO.php',
        ],
        'ongoing' => [
            'N-BTF' => 'Ongoing/N-BTF.php',
            'R-BTF' => 'Ongoing/R-BTF.php',
            'N-BTW' => 'Ongoing/N-BTW.php',
            'R-BTW' => 'Ongoing/R-BTW.php',
            'N-CBT' => 'Ongoing/N-CBT.php',
            'R-CBT' => 'Ongoing/R-CBT.php',
            'N-FBT' => 'Ongoing/N-FBT.php',
            'R-FBT' => 'Ongoing/R-FBT.php',
            'N-FBC' => 'Ongoing/N-FBC.php',
            'R-FBC' => 'Ongoing/R-FBC.php',
            'GFW-G' => 'Ongoing/GFW-G.php',
            'GFW-P' => 'Ongoing/GFW-P.php',
            'N-SILO' => 'Ongoing/N-SILO.php',
            'R-SILO' => 'Ongoing/R-SILO.php',
            'N-STA' => 'Ongoing/N-STA.php',
            'N-STU' => 'Ongoing/N-STU.php',
            'N-BTO' => 'Ongoing/N-BTO.php',
            'R-BTO' => 'Ongoing/R-BTO.php',
        ]
    ];

    if (isset($redirectionMap[$inspectionStatus][$selectedTypeOfWork])) {
        // Redirect to the correct page based on the selection
        header('Location: ' . $redirectionMap[$inspectionStatus][$selectedTypeOfWork]);
        exit;
    } else {
        echo "Invalid TypeOfWork or Inspection Status selection!";
    }
}

// Database connection (adjust the path if necessary)
require_once '../db_conn.php';

// Fetch job numbers and work types from the database
$query = "SELECT DTJobNumber FROM jayantha_1500_table";
$stmt = $pdo->query($query);
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT work_type FROM type_of_work"; 
$stmt = $pdo->query($query);
$type_of_work = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Previous PHP code remains unchanged -->

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
<br>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-xl">
        <h1 class="text-3xl font-bold mb-8 text-blue-600 border-b-2 border-blue-200 pb-4">ISO Audit Form</h1>
        
        <!-- Bilingual Note -->
        <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <p class="text-sm text-blue-800 mb-2">
                <span class="font-bold">සටහන:</span> සියලුම විස්තර සම්පූර්ණයෙන් පුරවා ඉවර වූ පසු අදාල රැකියා වර්ගය තෝරා ඉදිරියට යන්න. තෝරාගත් රැකියා වර්ගයට අනුරූප විශ්ලේෂණ පෝරමය ස්වයංක්රීයව පෙන්වනු ලැබේ.
            </p>
            <p class="text-sm text-blue-800">
                <span class="font-bold">Note:</span> After completing all details, select the relevant job type and proceed. The appropriate audit form for the selected job type will be automatically displayed.
            </p>
        </div>

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
                    <select name="inspection_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <!-- Job Status -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Job Status</label>
                    <select name="job_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="New">New</option>
                        <option value="Repair">Repair</option>
                    </select>
                </div>

                <!-- DTJobNumber -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">DT Job Number</label>
                    <select name="DTJobNumber" class="dt-select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="" disabled selected>Search job number...</option>
                        <?php foreach ($jobs as $job): ?>
                            <option value="<?= htmlspecialchars($job['DTJobNumber']) ?>">
                                <?= htmlspecialchars($job['DTJobNumber']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TypeOfWork -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Type of Work</label>
                    <select name="TypeOfWork" class="type-select2 mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="" disabled selected>Select work type...</option>
                        <?php foreach ($type_of_work as $work): ?>
                            <option value="<?= htmlspecialchars($work['work_type']) ?>">
                                <?= htmlspecialchars($work['work_type']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
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
    $(document).ready(function() {
        $('.dt-select2').select2({
            placeholder: 'Search job number...',
            allowClear: true,
            minimumResultsForSearch: 2
        });

        $('.type-select2').select2({
            placeholder: 'Select work type...',
            allowClear: true
        });
    });
    </script>
</body>
</html>