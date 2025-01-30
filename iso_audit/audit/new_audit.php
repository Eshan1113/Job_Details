<?php
session_start();  // Start the session to store session data

// If form is submitted, store session variables
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['date_audited'] = $_POST['date_audited'];
    $_SESSION['job_status'] = $_POST['job_status'];
    $_SESSION['DTJobNumber'] = $_POST['DTJobNumber'];
    $_SESSION['TypeOfWork'] = $_POST['TypeOfWork'];

    // Redirect to N-BTF.php after storing data in session
    header('Location: Forms/N-BTF.php');  // Redirect after storing data in session
    exit;
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-md shadow-md">
        <h1 class="text-2xl font-semibold mb-6 text-gray-700">Job Order Form</h1>
        <form action="new_audit.php" method="POST">
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

            <!-- Submit Button -->
            <div class="mt-6 text-center">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Submit
                </button>
            </div>
        </form>
    </div>
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
