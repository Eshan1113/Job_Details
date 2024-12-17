<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('db_conn.php');

// Fetch distinct TypeOfWork for the dropdown
try {
    $typeQuery = "SELECT DISTINCT TypeOfWork FROM jayantha_1500_table WHERE TypeOfWork IS NOT NULL AND TypeOfWork != '' ORDER BY TypeOfWork ASC";
    $typeStmt = $pdo->prepare($typeQuery);
    $typeStmt->execute();
    $typesOfWork = $typeStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Handle error appropriately
    $typesOfWork = [];
}

// Fetch distinct Years for the dropdown
try {
    $yearQuery = "SELECT DISTINCT Year FROM jayantha_1500_table WHERE Year IS NOT NULL ORDER BY Year ASC";
    $yearStmt = $pdo->prepare($yearQuery);
    $yearStmt->execute();
    $years = $yearStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Handle error appropriately
    $years = [];
}

// Fetch distinct DT Job Numbers for the dropdown
try {
    $jobNumberQuery = "SELECT DISTINCT DTJobNumber FROM jayantha_1500_table WHERE DTJobNumber IS NOT NULL AND DTJobNumber != '' ORDER BY DTJobNumber ASC";
    $jobNumberStmt = $pdo->prepare($jobNumberQuery);
    $jobNumberStmt->execute();
    $dtJobNumbers = $jobNumberStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Handle error appropriately
    $dtJobNumbers = [];
}

// Fetch distinct Clients for the dropdown
try {
    $clientQuery = "SELECT DISTINCT Client FROM jayantha_1500_table WHERE Client IS NOT NULL AND Client != '' ORDER BY Client ASC";
    $clientStmt = $pdo->prepare($clientQuery);
    $clientStmt->execute();
    $clients = $clientStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Handle error appropriately
    $clients = [];
}
?>

<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- (Head Content remains the same) -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .pagination-link:hover {
            background-color: #0056b3;
        }
        .pagination-link.disabled {
            background-color: #cccccc;
            cursor: not-allowed;
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
        /* Group Header Styles */
        .group-header {
            background-color: #e2e8f0;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Job Details</h2>

    <!-- Display Success or Error Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="p-4 mb-4 <?php echo ($_SESSION['message_type'] == 'success') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
            <?php 
                echo htmlspecialchars($_SESSION['message']); 
                unset($_SESSION['message'], $_SESSION['message_type']); 
            ?>
        </div>
    <?php endif; ?>

    <!-- Main Search Bar -->
    <div class="mb-6 flex flex-wrap gap-4">
        <input type="text" id="mainSearch" placeholder="Search..." class="p-2 border rounded w-full md:w-1/2">
    </div>

    <!-- Search Filters and Export Button -->
    <div class="mb-6 flex flex-wrap gap-4">
        <!-- Client Dropdown -->
        <select id="clientSearch" class="p-2 border rounded select2">
            <option value="">All Clients</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?php echo htmlspecialchars($client); ?>"><?php echo htmlspecialchars($client); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- DT Job Number Dropdown -->
        <select id="jobNumberSearch" class="p-2 border rounded select2">
            <option value="">All DT Job Numbers</option>
            <?php foreach ($dtJobNumbers as $jobNumber): ?>
                <option value="<?php echo htmlspecialchars($jobNumber); ?>"><?php echo htmlspecialchars($jobNumber); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Year Dropdown -->
        <select id="yearSearch" class="p-2 border rounded select2">
            <option value="">All Years</option>
            <?php foreach ($years as $year): ?>
                <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Type of Work Dropdown -->
        <select id="typeOfWorkSearch" class="p-2 border rounded select2">
            <option value="">All Types of Work</option>
            <?php foreach ($typesOfWork as $type): ?>
                <option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Date Range Filters -->
        <div class="flex items-center gap-2">
            <label for="fromDate" class="text-sm font-semibold text-gray-700">From:</label>
            <input type="date" id="fromDate" placeholder="From Date" class="p-2 border rounded">
        </div>
        <div class="flex items-center gap-2">
            <label for="toDate" class="text-sm font-semibold text-gray-700">To:</label>
            <input type="date" id="toDate" placeholder="To Date" class="p-2 border rounded">
        </div>

        <!-- Export Button -->
        <button id="exportButton" class="export-button">Export to Excel</button>
    </div>

    <!-- Table wrapper -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse bg-gray-100 rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-800">
                <tr>
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
        <!-- "Previous" and "Next" buttons will be dynamically loaded -->
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize Select2 for better dropdowns
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true
    });

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
                // Parse the JSON response
                if(response.success){
                    var tableHtml = '';
                    $.each(response.groupedData, function(yearKey, jobs) {
                        tableHtml += '<tr class="group-header"><td colspan="15">Year: ' + escapeHtml(yearKey) + '</td></tr>';
                        $.each(jobs, function(index, job) {
                            tableHtml += '<tr>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + escapeHtml(job.Year) + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + escapeHtml(job.Month) + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + escapeHtml(job.DTJobNumber) + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + (job.HOJobNumber ? escapeHtml(job.HOJobNumber) : 'N/A') + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + escapeHtml(job.Client) + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + escapeHtml(job.DateOpened) + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + escapeHtml(job.DescriptionOfWork) + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + escapeHtml(job.TARGET_DATE) + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + (job.CompletionDate ? escapeHtml(job.CompletionDate) : 'N/A') + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + (job.DeliveredDate ? escapeHtml(job.DeliveredDate) : 'N/A') + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + (job.FileClosed == 1 ? 'Yes' : 'No') + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + escapeHtml(job.LabourHours) + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + escapeHtml(job.MaterialCost) + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + (job.TypeOfWork ? escapeHtml(job.TypeOfWork) : 'N/A') + '</td>';
                            tableHtml += '<td class="px-6 py-4 border-b">' + (job.Remarks ? escapeHtml(job.Remarks) : 'N/A') + '</td>';
                            tableHtml += '</tr>';
                        });
                    });
                    $('#jobTable').html(tableHtml);
                    $('#pagination').html(response.pagination);
                } else {
                    $('#jobTable').html('<tr><td colspan="15" class="text-center text-red-500">Error loading data.</td></tr>');
                    $('#pagination').html('');
                }
            },
            dataType: 'json'
        });
    }

    // Function to escape HTML to prevent XSS
    function escapeHtml(text) {
        if(!text) return '';
        return $('<div>').text(text).html();
    }

    // Load jobs on page load
    loadJobs();

    // Trigger search on input change or dropdown selection
    $('#mainSearch, #clientSearch, #jobNumberSearch, #yearSearch, #typeOfWorkSearch, #fromDate, #toDate').on('input change', function() {
        loadJobs();
    });

    // Handle pagination click for "Previous" and "Next"
    $(document).on('click', '.pagination-link.prev:not([disabled])', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadJobs(page);
    });

    $(document).on('click', '.pagination-link.next:not([disabled])', function(e) {
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
        form.append('<input type="hidden" name="mainSearch" value="' + encodeURIComponent(mainSearch) + '">');
        form.append('<input type="hidden" name="client" value="' + encodeURIComponent(client) + '">');
        form.append('<input type="hidden" name="jobNumber" value="' + encodeURIComponent(jobNumber) + '">');
        form.append('<input type="hidden" name="year" value="' + encodeURIComponent(year) + '">');
        form.append('<input type="hidden" name="typeOfWork" value="' + encodeURIComponent(typeOfWork) + '">');
        form.append('<input type="hidden" name="fromDate" value="' + encodeURIComponent(fromDate) + '">');
        form.append('<input type="hidden" name="toDate" value="' + encodeURIComponent(toDate) + '">');
        $('body').append(form);
        form.submit();
    });
});
</script>
</body>
</html>
