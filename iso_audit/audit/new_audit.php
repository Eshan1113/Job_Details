<?php
session_start();
require_once '../db_conn.php'; // Adjust the path to your database connection file

// Fetch DTJobNumber from the `jayantha_1500_table`
$query = "SELECT DTJobNumber FROM jayantha_1500_table";
$stmt = $pdo->query($query);
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <input type="date" name="date_audited" id="date_audited" 
                       value="<?php echo date('Y-m-d'); ?>" 
                       class="mt-1 p-2 w-full border rounded-md" required>
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

            <!-- Job Status -->
            <div class="mb-4">
                <label for="job_status" class="block text-sm font-semibold text-gray-700">Job Status</label>
                <select name="job_status" id="job_status" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Complete">Complete</option>
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

    <!-- Initialize Select2 -->
    <script>
        $(document).ready(function () {
            // Enable Select2 for the dropdown
            $('#DTJobNumber').select2({
                placeholder: 'Select a DTJobNumber',
                allowClear: true
            });
        });
    </script>
</body>

</html>
