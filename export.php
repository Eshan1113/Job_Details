<?php
include('db_conn.php');

// Fetch all data for displaying to the user
$sql = "SELECT * FROM jayantha_1500_table";
try {
    $stmt = $pdo->query($sql);
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching data: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Columns for Export</title>
    <link href="css/tailwind.min.css" rel="stylesheet">
<link href="css/all.min.css" rel="stylesheet">
<link href="font/css/all.min.css" rel="stylesheet">
 <link href="css/select2.min.css" rel="stylesheet" />
<script src="css/jquery-3.6.0.min.js"></script>
<script src="css/select2.min.js"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Select Columns for Export</h1>
        <div class="container mx-auto p-6">
        <button id="backButton" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
            Back
        </button>
    </div>
        <form action="download_excel.php" method="POST">
            <!-- Column Selection -->
            <h2 class="text-lg font-semibold mb-4">Select Columns to Export:</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <label><input type="checkbox" name="columns[]" value="Year" checked> Year</label>
                <label><input type="checkbox" name="columns[]" value="Month" checked> Month</label>
                <label><input type="checkbox" name="columns[]" value="DTJobNumber" checked> DT Job Number</label>
                <label><input type="checkbox" name="columns[]" value="HOJobNumber" checked> HO Job Number</label>
                <label><input type="checkbox" name="columns[]" value="Client" checked> Client</label>
                <label><input type="checkbox" name="columns[]" value="DateOpened" checked> Date Opened</label>
                <label><input type="checkbox" name="columns[]" value="DescriptionOfWork" checked> Description of Work</label>
                <label><input type="checkbox" name="columns[]" value="Target_Date" checked> Target Date</label>
                <label><input type="checkbox" name="columns[]" value="CompletionDate" checked> Completion Date</label>
                <label><input type="checkbox" name="columns[]" value="DeliveredDate" checked> Delivered Date</label>
                <label><input type="checkbox" name="columns[]" value="FileClosed" checked> File Closed</label>
                <label><input type="checkbox" name="columns[]" value="LabourHours" checked> Labour Hours</label>
                <label><input type="checkbox" name="columns[]" value="MaterialCost" checked> Material Cost</label>
                <label><input type="checkbox" name="columns[]" value="TypeOfWork" checked> Type of Work</label>
                <label><input type="checkbox" name="columns[]" value="Remarks" checked> Remarks</label>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Download Selected Columns</button>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function(){
          $('#backButton').on('click', function() {
                window.history.back();
            })
        });
    </script>
</body>

</html>
