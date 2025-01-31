<?php


include('db_conn.php'); // Database connection

// Fetch distinct TypeOfWork for the dropdown
try {
    $typeQuery = "SELECT DISTINCT TypeOfWork FROM jayantha_1500_table WHERE TypeOfWork IS NOT NULL AND TypeOfWork != '' ORDER BY TypeOfWork ASC";
    $typeStmt = $pdo->prepare($typeQuery);
    $typeStmt->execute();
    $typesOfWork = $typeStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $typesOfWork = [];
}

// Fetch distinct Years for the dropdown
try {
    $yearQuery = "SELECT DISTINCT Year FROM jayantha_1500_table WHERE Year IS NOT NULL ORDER BY Year ASC";
    $yearStmt = $pdo->prepare($yearQuery);
    $yearStmt->execute();
    $years = $yearStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $years = [];
}

// Fetch distinct DT Job Numbers for the dropdown
try {
    $jobNumberQuery = "SELECT DISTINCT DTJobNumber FROM jayantha_1500_table WHERE DTJobNumber IS NOT NULL AND DTJobNumber != '' ORDER BY DTJobNumber ASC";
    $jobNumberStmt = $pdo->prepare($jobNumberQuery);
    $jobNumberStmt->execute();
    $dtJobNumbers = $jobNumberStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $dtJobNumbers = [];
}

// Fetch distinct Clients for the dropdown
try {
    $clientQuery = "SELECT DISTINCT Client FROM jayantha_1500_table WHERE Client IS NOT NULL AND Client != '' ORDER BY Client ASC";
    $clientStmt = $pdo->prepare($clientQuery);
    $clientStmt->execute();
    $clients = $clientStmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $clients = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head Content -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Details</title>
    <link href="css/tailwind.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link href="font/all.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet" />
    <script src="css/jquery-3.6.0.min.js"></script>
    <script src="css/select2.min.js"></script>

    <style>
        /* Existing CSS styles */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word;
            /* Allow text to wrap within cells */
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

        /* Edit Button Styles */
        .edit-button {
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            background-color: #ffc107;
            color: white;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #e0a800;
        }

        /* Modal Styles */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1000;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            /* 5% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
            max-width: 800px;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .save-button {
            padding: 8px 16px;
            margin-top: 12px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .save-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

<nav class="bg-blue-600 p-4 shadow-md">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo/Title Section -->
        <div class="flex items-center">
            <div class="text-white font-bold text-xl tracking-tight">
                DT
                <span class="block text-sm font-light">Pallekele</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="hidden md:flex items-center space-x-6">
            <!-- Theam-01 Login Link -->
            <a href="http://192.168.1.210:4141/home.php"
                class="text-white hover:text-blue-100 transition-colors duration-300 font-semibold flex items-center">
                <span class="mr-2"><i class="fas fa-sign-in-alt"></i></span>
                Theam-01 Login
            </a>
            
            <!-- Job Details Link -->
            <a href="login.php"
                class="text-white hover:text-blue-100 transition-colors duration-300 font-semibold flex items-center">
                <span class="mr-2"><i class="fas fa-briefcase"></i></span>
                Job Details
            </a>
            
            <!-- Iso Audit Link -->
            <a href="iso_audit/login.php"
                class="text-white hover:text-blue-100 transition-colors duration-300 font-semibold flex items-center">
                <span class="mr-2"><i class="fas fa-clipboard-check"></i></span>
                Iso Audit
            </a>
        </div>

        <!-- Mobile Menu Button (hidden on larger screens) -->
        <div class="md:hidden">
            <button class="text-white hover:text-blue-100 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
</nav>
    

<br>
    <!-- Display Success or Error Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div
            class="p-4 mb-4 <?php echo ($_SESSION['message_type'] == 'success') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
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

    <!-- Search Filters -->
    <div class="mb-6 flex flex-wrap gap-4">
        <!-- Client Dropdown -->
        <select id="clientSearch" class="p-2 border rounded select2">
            <option></option> <!-- Empty option for placeholder -->
            <option value="">All Clients</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?php echo htmlspecialchars($client); ?>"><?php echo htmlspecialchars($client); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- DT Job Number Dropdown -->
        <select id="jobNumberSearch" class="p-2 border rounded select2">
            <option></option> <!-- Empty option for placeholder -->
            <option value="">All DT Job Numbers</option>
            <?php foreach ($dtJobNumbers as $jobNumber): ?>
                <option value="<?php echo htmlspecialchars($jobNumber); ?>"><?php echo htmlspecialchars($jobNumber); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Year Dropdown -->
        <select id="yearSearch" class="p-2 border rounded select2">
            <option></option> <!-- Empty option for placeholder -->
            <option value="">All Years</option>
            <?php foreach ($years as $year): ?>
                <option value="<?php echo htmlspecialchars($year); ?>"><?php echo htmlspecialchars($year); ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Type of Work Dropdown -->
        <select id="typeOfWorkSearch" class="p-2 border rounded select2">
            <option></option> <!-- Empty option for placeholder -->
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
    </div>

    <!-- Table wrapper -->
    <div class="overflow-y-auto max-h-96">
        <table class="min-w-full table-auto table-fixed border-collapse bg-gray-100 rounded-lg">
            <colgroup>
                <col class="w-16"> <!-- Year -->
                <col class="w-24"> <!-- Month -->
                <col class="w-24"> <!-- DT Job Number -->
                <col class="w-24"> <!-- HO Job Number -->
                <col class="w-24"> <!-- Client -->
                <col class="w-24"> <!-- Date Opened -->
                <col class="w-32"> <!-- Description of Work -->
                <col class="w-24"> <!-- Target Date -->
                <col class="w-24"> <!-- Completion Date -->
                <col class="w-24"> <!-- Delivered Date -->
                <col class="w-16"> <!-- File Closed -->
                <col class="w-16"> <!-- Labour Hours -->
                <col class="w-16"> <!-- Material Cost -->
                <col class="w-24"> <!-- Type of Work -->
                <col class="w-24"> <!-- Remarks -->
                <col class="w-16"> <!-- Actions -->
            </colgroup>
            <thead class="bg-gray-200 text-gray-800">
                <tr>
                    <th class="px-2 py-2 text-left text-sm">Year</th>
                    <th class="px-2 py-2 text-left text-sm">Month</th>
                    <th class="px-2 py-2 text-left text-sm">DT Job Number</th>
                    <th class="px-2 py-2 text-left text-sm hidden md:table-cell">HO Job Number</th>
                    <th class="px-2 py-2 text-left text-sm">Client</th>
                    <th class="px-2 py-2 text-left text-sm hidden lg:table-cell">Date Opened</th>
                    <th class="px-2 py-2 text-left text-sm hidden lg:table-cell">Description of Work</th>
                    <th class="px-2 py-2 text-left text-sm hidden lg:table-cell">Target Date</th>
                    <th class="px-2 py-2 text-left text-sm hidden lg:table-cell">Completion Date</th>
                    <th class="px-2 py-2 text-left text-sm hidden lg:table-cell">Delivered Date</th>
                    <th class="px-2 py-2 text-left text-sm hidden md:table-cell">File Closed</th>
                    <th class="px-2 py-2 text-left text-sm hidden md:table-cell">Labour Hours</th>
                    <th class="px-2 py-2 text-left text-sm hidden md:table-cell">Material Cost</th>
                    <th class="px-2 py-2 text-left text-sm">Type of Work</th>
                    <th class="px-2 py-2 text-left text-sm hidden md:table-cell">Remarks</th>

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

    <!-- Export Modal -->
    <div id="exportModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="text-2xl font-bold mb-4">Select Columns to Export</h2>
            <form id="exportForm">
                <div class="grid grid-cols-2 gap-4">
                    <label><input type="checkbox" name="columns[]" value="Year" checked> Year</label>
                    <label><input type="checkbox" name="columns[]" value="Month" checked> Month</label>
                    <label><input type="checkbox" name="columns[]" value="DTJobNumber" checked> DT Job Number</label>
                    <label><input type="checkbox" name="columns[]" value="HOJobNumber"> HO Job Number</label>
                    <label><input type="checkbox" name="columns[]" value="Client" checked> Client</label>
                    <label><input type="checkbox" name="columns[]" value="DateOpened" checked> Date Opened</label>
                    <label><input type="checkbox" name="columns[]" value="DescriptionOfWork" checked> Description of
                        Work</label>
                    <label><input type="checkbox" name="columns[]" value="TARGET_DATE"> Target Date</label>
                    <label><input type="checkbox" name="columns[]" value="CompletionDate"> Completion Date</label>
                    <label><input type="checkbox" name="columns[]" value="DeliveredDate"> Delivered Date</label>
                    <label><input type="checkbox" name="columns[]" value="FileClosed"> File Closed</label>
                    <label><input type="checkbox" name="columns[]" value="LabourHours"> Labour Hours</label>
                    <label><input type="checkbox" name="columns[]" value="MaterialCost"> Material Cost</label>
                    <label><input type="checkbox" name="columns[]" value="TypeOfWork"> Type of Work</label>
                    <label><input type="checkbox" name="columns[]" value="Remarks"> Remarks</label>

            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="text-2xl font-bold mb-4">Edit Job Details</h2>
            <form id="editForm">
                <input type="hidden" id="editSrNo" name="sr_no">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="editYear" class="block text-sm font-medium text-gray-700">Year</label>
                        <input type="number" id="editYear" name="Year" required class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editMonth" class="block text-sm font-medium text-gray-700">Month</label>
                        <input type="text" id="editMonth" name="Month" required class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editDTJobNumber" class="block text-sm font-medium text-gray-700">DT Job
                            Number</label>
                        <input type="text" id="editDTJobNumber" name="DTJobNumber" required
                            class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editHOJobNumber" class="block text-sm font-medium text-gray-700">HO Job
                            Number</label>
                        <input type="text" id="editHOJobNumber" name="HOJobNumber"
                            class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editClient" class="block text-sm font-medium text-gray-700">Client</label>
                        <input type="text" id="editClient" name="Client" required
                            class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editDateOpened" class="block text-sm font-medium text-gray-700">Date Opened</label>
                        <input type="date" id="editDateOpened" name="DateOpened" required
                            class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editDescriptionOfWork" class="block text-sm font-medium text-gray-700">Description
                            of Work</label>
                        <textarea id="editDescriptionOfWork" name="DescriptionOfWork" required
                            class="mt-1 p-2 border rounded w-full"></textarea>
                    </div>
                    <div>
                        <label for="editTARGET_DATE" class="block text-sm font-medium text-gray-700">Target Date</label>
                        <input type="date" id="editTARGET_DATE" name="TARGET_DATE" required
                            class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editCompletionDate" class="block text-sm font-medium text-gray-700">Completion
                            Date</label>
                        <input type="date" id="editCompletionDate" name="CompletionDate"
                            class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editDeliveredDate" class="block text-sm font-medium text-gray-700">Delivered
                            Date</label>
                        <input type="date" id="editDeliveredDate" name="DeliveredDate"
                            class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editFileClosed" class="block text-sm font-medium text-gray-700">File Closed</label>
                        <select id="editFileClosed" name="FileClosed" class="mt-1 p-2 border rounded w-full">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div>
                        <label for="editLabourHours" class="block text-sm font-medium text-gray-700">Labour
                            Hours</label>
                        <input type="text" id="editLabourHours" name="LabourHours"
                            class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editMaterialCost" class="block text-sm font-medium text-gray-700">Material
                            Cost</label>
                        <input type="text" id="editMaterialCost" name="MaterialCost"
                            class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editTypeOfWork" class="block text-sm font-medium text-gray-700">Type of Work</label>
                        <input type="text" id="editTypeOfWork" name="TypeOfWork" class="mt-1 p-2 border rounded w-full">
                    </div>
                    <div>
                        <label for="editRemarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                        <textarea id="editRemarks" name="Remarks" class="mt-1 p-2 border rounded w-full"></textarea>
                    </div>
                </div>
                <button type="submit" class="save-button">Save Changes</button>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Initialize Select2 for each dropdown with specific placeholders
            $('#clientSearch').select2({
                placeholder: "Select a Client",
                allowClear: true,
                width: 'resolve'
            });

            $('#jobNumberSearch').select2({
                placeholder: "Select a DT Job Number",
                allowClear: true,
                width: 'resolve'
            });

            $('#yearSearch').select2({
                placeholder: "Select a Year",
                allowClear: true,
                width: 'resolve'
            });

            $('#typeOfWorkSearch').select2({
                placeholder: "Select a Type of Work",
                allowClear: true,
                width: 'resolve'
            });

            // Function to load jobs via AJAX
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
                    success: function (response) {
                        if (response.success) {
                            var tableHtml = '';
                            $.each(response.groupedData, function (yearKey, months) {
                                tableHtml += '<tr class="group-header"><td colspan="16">Year: ' + escapeHtml(yearKey) + '</td></tr>';
                                $.each(months, function (monthKey, jobs) {
                                    tableHtml += '<tr class="group-header"><td colspan="16">Month: ' + escapeHtml(monthKey) + '</td></tr>';
                                    $.each(jobs, function (index, job) {
                                        tableHtml += '<tr>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm">' + escapeHtml(job.Year) + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm">' + escapeHtml(job.Month) + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm">' + escapeHtml(job.DTJobNumber) + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm hidden md:table-cell">' + (job.HOJobNumber ? escapeHtml(job.HOJobNumber) : 'N/A') + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm">' + escapeHtml(job.Client) + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm hidden lg:table-cell">' + escapeHtml(job.DateOpened) + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm hidden lg:table-cell">' + escapeHtml(job.DescriptionOfWork) + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm hidden lg:table-cell">' + escapeHtml(job.TARGET_DATE) + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm hidden lg:table-cell">' + (job.CompletionDate ? escapeHtml(job.CompletionDate) : 'N/A') + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm hidden lg:table-cell">' + (job.DeliveredDate ? escapeHtml(job.DeliveredDate) : 'N/A') + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm hidden md:table-cell">' + escapeHtml(job.FileClosed) + '</td>'; // Display as "Yes" or "No"
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm hidden md:table-cell">' + escapeHtml(job.LabourHours) + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm hidden md:table-cell">' + escapeHtml(job.MaterialCost) + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm">' + (job.TypeOfWork ? escapeHtml(job.TypeOfWork) : 'N/A') + '</td>';
                                        tableHtml += '<td class="px-2 py-1 border-b text-sm hidden md:table-cell">' + (job.Remarks ? escapeHtml(job.Remarks) : 'N/A') + '</td>';
                                        // Add Actions column with Edit button

                                    });
                                });
                            });
                            $('#jobTable').html(tableHtml);
                            $('#pagination').html(response.pagination);
                        } else {
                            $('#jobTable').html('<tr><td colspan="16" class="text-center text-red-500">' + escapeHtml(response.message || 'Error loading data.') + '</td></tr>');
                            $('#pagination').html('');
                        }
                    },
                    dataType: 'json',
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        $('#jobTable').html('<tr><td colspan="16" class="text-center text-red-500">An error occurred while loading data.</td></tr>');
                        $('#pagination').html('');
                    }
                });
            }

            // Function to escape HTML to prevent XSS
            function escapeHtml(text) {
                if (!text) return '';
                return $('<div>').text(text).html();
            }

            // Load jobs on page load
            loadJobs();

            // Trigger search on input change or dropdown selection
            $('#mainSearch, #clientSearch, #jobNumberSearch, #yearSearch, #typeOfWorkSearch, #fromDate, #toDate').on('input change', function () {
                loadJobs();
            });

            // Handle pagination click for "Previous" and "Next"
            $(document).on('click', '.pagination-link.prev:not([disabled])', function (e) {
                e.preventDefault();
                var page = $(this).data('page');
                loadJobs(page);
            });

            $(document).on('click', '.pagination-link.next:not([disabled])', function (e) {
                e.preventDefault();
                var page = $(this).data('page');
                loadJobs(page);
            });

            // Export Modal Handling
            var exportModal = $('#exportModal');
            var exportBtn = $('#exportButton');
            var exportSpan = $('#exportModal .close');

            // When the user clicks the Export button, open the modal 
            exportBtn.on('click', function () {
                exportModal.show();
            });

            // When the user clicks on <span> (x), close the modal
            exportSpan.on('click', function () {
                exportModal.hide();
            });

            // When the user clicks anywhere outside of the modal, close it
            $(window).on('click', function (event) {
                if ($(event.target).is(exportModal)) {
                    exportModal.hide();
                }
            });

            // Handle Export Confirmation
            $('#confirmExport').on('click', function () {
                var selectedColumns = [];
                $('input[name="columns[]"]:checked').each(function () {
                    selectedColumns.push($(this).val());
                });

                if (selectedColumns.length === 0) {
                    alert('Please select at least one column to export.');
                    return;
                }

                // Initiate export with selected columns
                exportSelectedColumns(selectedColumns);

                // Close the modal
                exportModal.hide();
            });

            // Function to handle export via AJAX
            function exportSelectedColumns(columns) {
                // Fetch current filter values
                var mainSearch = $('#mainSearch').val();
                var client = $('#clientSearch').val();
                var jobNumber = $('#jobNumberSearch').val();
                var year = $('#yearSearch').val();
                var typeOfWork = $('#typeOfWorkSearch').val();
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();

                $.ajax({
                    url: 'export.php',
                    type: 'POST',
                    data: {
                        columns: columns,
                        mainSearch: mainSearch,
                        client: client,
                        jobNumber: jobNumber,
                        year: year,
                        typeOfWork: typeOfWork,
                        fromDate: fromDate,
                        toDate: toDate
                    },
                    xhrFields: {
                        responseType: 'blob' // Important for handling binary data
                    },
                    success: function (blob, status, xhr) {
                        // Check if the Blob is empty (likely an error)
                        if (blob.size === 0) {
                            var reader = new FileReader();
                            reader.onload = function () {
                                var errorMessage = reader.result;
                                alert('Error: ' + errorMessage);
                            };
                            reader.readAsText(blob);
                            return;
                        }

                        // Get the filename from the Content-Disposition header
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        var filename = "";
                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);
                            if (matches != null && matches[1]) {
                                filename = matches[1].replace(/['"]/g, '');
                            }
                        }

                        if (typeof window.navigator.msSaveBlob !== 'undefined') {
                            // IE workaround
                            window.navigator.msSaveBlob(blob, filename);
                        } else {
                            var URL = window.URL || window.webkitURL;
                            var downloadUrl = URL.createObjectURL(blob);

                            if (filename) {
                                // Use HTML5 a[download] attribute to specify filename
                                var a = document.createElement("a");
                                a.href = downloadUrl;
                                a.download = filename;
                                document.body.appendChild(a);
                                a.click();
                                document.body.removeChild(a);
                            } else {
                                // Fallback if filename is not provided
                                window.location = downloadUrl;
                            }

                            // Release the object URL
                            URL.revokeObjectURL(downloadUrl);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Export Error:', status, error);
                        alert('An error occurred while exporting data.');
                    }
                });
            }

            // Edit Modal Functionality
            var editModal = $('#editModal');
            var editSpan = $('#editModal .close');

            // When the user clicks on <span> (x), close the modal
            editSpan.on('click', function () {
                editModal.hide();
            });

            // When the user clicks anywhere outside of the modal, close it
            $(window).on('click', function (event) {
                if ($(event.target).is(editModal)) {
                    editModal.hide();
                }
            });

            // Handle Edit Button Click
            $(document).on('click', '.edit-button', function () {
                var sr_no = $(this).data('srno');
                // Fetch the current data for the selected sr_no via AJAX
                $.ajax({
                    url: 'get_job.php',
                    type: 'POST',
                    data: { sr_no: sr_no },
                    success: function (response) {
                        if (response.success) {
                            // Populate the modal form with the data
                            $('#editSrNo').val(response.data.sr_no);
                            $('#editYear').val(response.data.Year);
                            $('#editMonth').val(response.data.Month);
                            $('#editDTJobNumber').val(response.data.DTJobNumber);
                            $('#editHOJobNumber').val(response.data.HOJobNumber);
                            $('#editClient').val(response.data.Client);
                            $('#editDateOpened').val(response.data.DateOpened);
                            $('#editDescriptionOfWork').val(response.data.DescriptionOfWork);
                            $('#editTARGET_DATE').val(response.data.TARGET_DATE);
                            $('#editCompletionDate').val(response.data.CompletionDate);
                            $('#editDeliveredDate').val(response.data.DeliveredDate ? response.data.DeliveredDate : '');
                            $('#editFileClosed').val(response.data.FileClosed); // Set to "Yes" or "No"
                            $('#editLabourHours').val(response.data.LabourHours);
                            $('#editMaterialCost').val(response.data.MaterialCost);
                            $('#editTypeOfWork').val(response.data.TypeOfWork);
                            $('#editRemarks').val(response.data.Remarks);
                            // Show the modal
                            editModal.show();
                        } else {
                            alert('Failed to fetch data for editing. ' + escapeHtml(response.message || ''));
                        }
                    },
                    dataType: 'json',
                    error: function (xhr, status, error) {
                        console.error('AJAX Edit Error:', status, error);
                        alert('An error occurred while fetching data for editing.');
                    }
                });
            });

            // Handle Edit Form Submission
            $('#editForm').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: 'edit_job.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            alert('Record updated successfully.');
                            editModal.hide();
                            loadJobs(); // Refresh the table data
                        } else {
                            alert('Failed to update the record. ' + escapeHtml(response.message || ''));
                        }
                    },
                    dataType: 'json',
                    error: function (xhr, status, error) {
                        console.error('AJAX Edit Submit Error:', status, error);
                        alert('An error occurred while updating the record.');
                    }
                });
            });
        });
    </script>

<?php include('footer.php'); ?>
</body>

</html>