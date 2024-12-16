<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('db_conn.php');

// Fetch distinct TypeOfWork for the dropdown
try {
    $typeQuery = "SELECT DISTINCT TypeOfWork FROM jayantha_1500_table ORDER BY TypeOfWork ASC";
    $typeStmt = $pdo->prepare($typeQuery);
    $typeStmt->execute();
    $typesOfWork = $typeStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Handle error appropriately
    $typesOfWork = [];
}

// Fetch distinct Years for the dropdown
try {
    $yearQuery = "SELECT DISTINCT Year FROM jayantha_1500_table ORDER BY Year ASC";
    $yearStmt = $pdo->prepare($yearQuery);
    $yearStmt->execute();
    $years = $yearStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Handle error appropriately
    $years = [];
}

// Fetch distinct DT Job Numbers for the dropdown
try {
    $jobNumberQuery = "SELECT DISTINCT DTJobNumber FROM jayantha_1500_table ORDER BY DTJobNumber ASC";
    $jobNumberStmt = $pdo->prepare($jobNumberQuery);
    $jobNumberStmt->execute();
    $dtJobNumbers = $jobNumberStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Handle error appropriately
    $dtJobNumbers = [];
}

// Fetch distinct Clients for the dropdown
try {
    $clientQuery = "SELECT DISTINCT Client FROM jayantha_1500_table ORDER BY Client ASC";
    $clientStmt = $pdo->prepare($clientQuery);
    $clientStmt->execute();
    $clients = $clientStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Handle error appropriately
    $clients = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- (Head Content remains the same) -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Details</title>
    <link href="css/tailwind.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link href="font/css/all.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet" />
    <script src="css/jquery-3.6.0.min.js"></script>
    <script src="css/select2.min.js"></script>
    <style>
        /* Existing CSS styles */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .pagination-link {
            padding: 8px 16px;
            margin: 0 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
        }
        .pagination-link:hover {
            background-color: #007bff;
            color: white;
        }
        .pagination-link.active {
            background-color: #007bff;
            color: white;
            pointer-events: none;
        }
        /* Export button styles */
        .export-button {
            padding: 8px 16px;
            margin: 0 4px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        .export-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Job Details</h2>

    <!-- Main Search Bar -->
    <div class="mb-6 flex flex-wrap gap-4">
        <input type="text" id="mainSearch" placeholder="Search..." class="p-2 border rounded w-full md:w-1/2">
    </div>

    <!-- Search Filters and Export Button -->
    <div class="mb-6 flex flex-wrap gap-4">
        <!-- Client Dropdown -->
        <select id="clientSearch" class="p-2 border rounded">
            <option value="">All Clients</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?php echo htmlspecialchars($client); ?>"><?php echo htmlspecialchars($client); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- DT Job Number Dropdown -->
        <select id="jobNumberSearch" class="p-2 border rounded">
            <option value="">All DT Job Numbers</option>
            <?php foreach ($dtJobNumbers as $jobNumber): ?>
                <option value="<?php echo htmlspecialchars($jobNumber); ?>"><?php echo htmlspecialchars($jobNumber); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Year Dropdown -->
        <select id="yearSearch" class="p-2 border rounded">
            <option value="">All Years</option>
            <?php foreach ($years as $year): ?>
                <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Type of Work Dropdown -->
        <select id="typeOfWorkSearch" class="p-2 border rounded">
            <option value="">All Types of Work</option>
            <?php foreach ($typesOfWork as $type): ?>
                <option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option>
            <?php endforeach; ?>
        </select>

        From<input type="date" id="fromDate" placeholder="From Date" class="p-2 border rounded">
        To<input type="date" id="toDate" placeholder="To Date" class="p-2 border rounded">

        <!-- Export Button -->
        <button id="exportButton" class="export-button">Export to Excel</button>
    </div>

    <!-- Table wrapper -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse bg-gray-100 rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left">Order ID</th>
                    <th class="px-6 py-3 text-left">Year</th>
                    <th class="px-6 py-3 text-left">Month</th>
                    <th class="px-6 py-3 text-left">DT Job Number</th>
                    <th class="px-6 py-3 text-left">HO Job Number</th>
                    <th class="px-6 py-3 text-left">Client</th>
                    <th class="px-6 py-3 text-left">Date Opened</th>
                    <th class="px-6 py-3 text-left">Description of Work</th>
                    <th class="px-6 py-3 text-left">Target Date</th>
                    <th class="px-6 py-3 text-left">Completion Date</th>
                    <th class="px-6 py-3 text-left">Delivered Date</th>
                    <th class="px-6 py-3 text-left">File Closed</th>
                    <th class="px-6 py-3 text-left">Labour Hours</th>
                    <th class="px-6 py-3 text-left">Material Cost</th>
                    <th class="px-6 py-3 text-left">Type of Work</th>
                    <th class="px-6 py-3 text-left">Remarks</th>
                </tr>
            </thead>
            <tbody id="jobTable">
                <!-- Data will be dynamically loaded via AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div id="pagination" class="flex justify-center mt-4">
        <!-- Pagination links will be dynamically loaded -->
    </div>
</div>

<script>
$(document).ready(function() {
    function loadJobs(page = 1) {
        var mainSearch = $('#mainSearch').val();
        var client = $('#clientSearch').val();
        var jobNumber = $('#jobNumberSearch').val();
        var year = $('#yearSearch').val();
        var typeOfWork = $('#typeOfWorkSearch').val();
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

        $.ajax({
            url: 'search.php',
            type: 'POST',
            data: {
                mainSearch: mainSearch,
                client: client,
                jobNumber: jobNumber,
                year: year,
                typeOfWork: typeOfWork,
                fromDate: fromDate,
                toDate: toDate,
                page: page
            },
            success: function(response) {
                $('#jobTable').html(response.tableData);
                $('#pagination').html(response.pagination);
            },
            dataType: 'json'
        });
    }

    // Load jobs on page load
    loadJobs();

    // Trigger search on input change or dropdown selection
    $('#mainSearch, #clientSearch, #jobNumberSearch, #yearSearch, #typeOfWorkSearch, #fromDate, #toDate').on('input change', function() {
        loadJobs();
    });

    // Handle pagination click
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadJobs(page);
    });

    // Handle Export Button Click
    $('#exportButton').on('click', function() {
        var mainSearch = $('#mainSearch').val();
        var client = $('#clientSearch').val();
        var jobNumber = $('#jobNumberSearch').val();
        var year = $('#yearSearch').val();
        var typeOfWork = $('#typeOfWorkSearch').val();
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

        // Create a form dynamically to submit the data
        var form = $('<form action="export.php" method="POST"></form>');
        form.append('<input type="hidden" name="mainSearch" value="' + mainSearch + '">');
        form.append('<input type="hidden" name="client" value="' + client + '">');
        form.append('<input type="hidden" name="jobNumber" value="' + jobNumber + '">');
        form.append('<input type="hidden" name="year" value="' + year + '">');
        form.append('<input type="hidden" name="typeOfWork" value="' + typeOfWork + '">');
        form.append('<input type="hidden" name="fromDate" value="' + fromDate + '">');
        form.append('<input type="hidden" name="toDate" value="' + toDate + '">');
        $('body').append(form);
        form.submit();
    });
});
</script>
</body>
</html>
