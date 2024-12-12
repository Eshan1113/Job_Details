<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Details</title>
    <script src="css/jquery-3.6.0.min.js"></script>
    <script src="3.4.16"></script>
    <style>
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
    </style>
</head>
<body>
<?php include('header.php'); ?>

<div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Job Details</h2>

    <!-- Search Bar -->
    <div class="mb-6">
        <input type="text" id="clientSearch" placeholder="Search by Client" class="p-2 border rounded">
        <input type="text" id="jobNumberSearch" placeholder="Search by DT Job Number" class="p-2 border rounded">
        <input type="text" id="yearSearch" placeholder="Search by Year" class="p-2 border rounded">
        <input type="date" id="fromDate" placeholder="From Date" class="p-2 border rounded">
        <input type="date" id="toDate" placeholder="To Date" class="p-2 border rounded">
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
        var client = $('#clientSearch').val();
        var jobNumber = $('#jobNumberSearch').val();
        var year = $('#yearSearch').val();
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

        $.ajax({
            url: 'search.php',
            type: 'POST',
            data: {
                client: client,
                jobNumber: jobNumber,
                year: year,
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

    // Trigger search on input change or date selection
    $('#clientSearch, #jobNumberSearch, #yearSearch, #fromDate, #toDate').on('input change', function() {
        loadJobs();
    });

    // Handle pagination click
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadJobs(page);
    });
});
</script>
</body>
</html>
