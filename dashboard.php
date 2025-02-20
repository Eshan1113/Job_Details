<?php 
session_start();

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
include('db_conn.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch clients from the client_list table
try {
    $stmt = $pdo->prepare("SELECT client FROM client_list ORDER BY client ASC");
    $stmt->execute();
    $clients = $stmt->fetchAll();
} catch (PDOException $e) {
    // Handle query errors
    $clients = [];
    $client_error = 'Error fetching clients: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <!-- Include necessary scripts and styles -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<?php include('header.php'); ?>
<body>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Add Job Details</h2>

        <!-- Success or Error Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="p-4 mb-4 <?php echo ($_SESSION['message_type'] == 'success') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                <?php 
                    echo htmlspecialchars($_SESSION['message']); 
                    unset($_SESSION['message'], $_SESSION['message_type']); 
                ?>
            </div>
        <?php endif; ?>

        <!-- Display client fetch error if any -->
        <?php if (isset($client_error)): ?>
            <div class="p-4 mb-4 bg-red-100 text-red-800">
                <?php echo htmlspecialchars($client_error); ?>
            </div>
        <?php endif; ?>

        <form action="submit_job.php" method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="Year" class="block text-sm font-semibold text-gray-700">Year</label>
                    <input type="number" name="Year" id="Year" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
                <div>
                    <label for="Month" class="block text-sm font-semibold text-gray-700">Month</label>
                    <select name="Month" id="Month" class="mt-1 p-2 w-full border rounded-md" required>
                        <option value="" disabled selected>Select a month</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <label for="DTJobNumber" class="block text-sm font-semibold text-gray-700">DT Job Number</label>
                <input type="text" name="DTJobNumber" id="DTJobNumber" class="mt-1 p-2 w-full border rounded-md" required>
            </div>
            <div class="mt-4">
                <label for="HOJobNumber" class="block text-sm font-semibold text-gray-700">HO Job Number</label>
                <input type="text" name="HOJobNumber" id="HOJobNumber" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="Client" class="block text-sm font-semibold text-gray-700">Client</label>
                <select name="Client" id="Client" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="" disabled selected>Select a client</option>
                    <?php
                        if (!empty($clients)) {
                            foreach ($clients as $client) {
                                // Adjust 'client_name' if your column is named differently
                                $clientName = htmlspecialchars($client['client']);
                                echo "<option value=\"{$clientName}\">{$clientName}</option>";
                            }
                        } else {
                            echo '<option value="" disabled>No clients available</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="mt-4">
                <label for="DateOpened" class="block text-sm font-semibold text-gray-700">Date Opened</label>
                <input type="date" name="DateOpened" id="DateOpened" class="mt-1 p-2 w-full border rounded-md" required>
            </div>
            <div class="mt-4">
                <label for="DescriptionOfWork" class="block text-sm font-semibold text-gray-700">Description of Work</label>
                <textarea name="DescriptionOfWork" id="DescriptionOfWork" rows="4" class="mt-1 p-2 w-full border rounded-md" required></textarea>
            </div>
            <div class="mt-4">
                <label for="TargetDate" class="block text-sm font-semibold text-gray-700">Target Date</label>
                <input type="date" name="TARGET_DATE" id="TARGET_DATE" class="mt-1 p-2 w-full border rounded-md" required>
            </div>
            <div class="mt-4">
                <label for="CompletionDate" class="block text-sm font-semibold text-gray-700">Completion Date</label>
                <input type="date" name="CompletionDate" id="CompletionDate" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="DeliveredDate" class="block text-sm font-semibold text-gray-700">Delivered Date</label>
                <input type="date" name="DeliveredDate" id="DeliveredDate" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="FileClosed" class="block text-sm font-semibold text-gray-700">File Closed</label>
                <select name="FileClosed" id="FileClosed" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </div>
            <div class="mt-4">
                <label for="LabourHours" class="block text-sm font-semibold text-gray-700">Labour Hours</label>
                <input type="number" step="0.01" name="LabourHours" id="LabourHours" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="MaterialCost" class="block text-sm font-semibold text-gray-700">Material Cost</label>
                <input type="number" step="0.01" name="MaterialCost" id="MaterialCost" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="TypeOfWork" class="block text-sm font-semibold text-gray-700">Type of Work</label>
                <input type="text" name="TypeOfWork" id="TypeOfWork" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="Remarks" class="block text-sm font-semibold text-gray-700">Remarks</label>
                <textarea name="Remarks" id="Remarks" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
