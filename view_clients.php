<?php
// view_clients.php
session_start();
include('db_conn.php');
?>
<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clients List</title>
    <link href="css/tailwind.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link href="font/css/all.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet" />
    <script src="css/jquery-3.6.0.min.js"></script>
    <script src="css/select2.min.js"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto mt-10 p-6 bg-white rounded shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Clients List</h2>

        <!-- Search Bar -->
        <div class="mb-6">
            <input type="text" id="searchInput" placeholder="Search for a client..."
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Clients Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100">Ref No</th>
                        <th class="px-4 py-2 border-b-2 border-gray-200 bg-gray-100">Client Name</th>
                    </tr>
                </thead>
                <tbody id="clientsTableBody">
                    <?php
                    try {
                        // Fetch the first 10 clients initially
                        $stmt = $pdo->prepare("SELECT ref_no, client FROM client_list ORDER BY ref_no ASC LIMIT 10 OFFSET 0");
                        $stmt->execute();
                        $clients = $stmt->fetchAll();
    
                        foreach ($clients as $row) {
                            echo '<tr>';
                            echo '<td class="px-4 py-2 border-b border-gray-200">' . htmlspecialchars($row['ref_no']) . '</td>';
                            echo '<td class="px-4 py-2 border-b border-gray-200">' . htmlspecialchars($row['client']) . '</td>';
                            echo '</tr>';
                        }
                    } catch (PDOException $e) {
                        echo '<tr><td colspan="2" class="px-4 py-2 border-b border-gray-200 text-red-500">Error fetching clients: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="flex justify-between mt-6">
            <button id="prevButton" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 focus:outline-none disabled:opacity-50" disabled>
                <i class=""></i> Previous
            </button>
            <button id="nextButton" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 focus:outline-none">
                Next <i class=""></i>
            </button>
        </div>

        <!-- Link to Add New Client -->
        <div class="container mx-auto mt-4 p-6 text-center">
        <a href="add_client.php">
        <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none">
           Add Clinet
        </button>
    </a>
</div>
    </div>

    <!-- JavaScript for Real-Time Search and Pagination -->
    <script>
        $(document).ready(function(){
            let currentPage = 1;
            const recordsPerPage = 10;
            let totalPages = 1;
            let currentSearch = '';

            // Function to fetch and display clients
            function fetchClients(page = 1, search = '') {
                $.ajax({
                    url: 'search_clients.php',
                    type: 'POST',
                    data: { search: search, page: page, recordsPerPage: recordsPerPage },
                    dataType: 'json',
                    success: function(response){
                        if(response.success){
                            const clients = response.data.clients;
                            totalPages = response.data.totalPages;
                            currentPage = response.data.currentPage;

                            let tableRows = '';

                            if(clients.length > 0){
                                $.each(clients, function(index, client){
                                    tableRows += '<tr>';
                                    tableRows += '<td class="px-4 py-2 border-b border-gray-200">' + escapeHtml(client.ref_no) + '</td>';
                                    tableRows += '<td class="px-4 py-2 border-b border-gray-200">' + escapeHtml(client.client) + '</td>';
                                    tableRows += '</tr>';
                                });
                            } else {
                                tableRows += '<tr><td colspan="2" class="px-4 py-2 border-b border-gray-200 text-center">No clients found.</td></tr>';
                            }

                            $('#clientsTableBody').html(tableRows);

                            // Update button states
                            if(currentPage <= 1){
                                $('#prevButton').attr('disabled', true);
                            } else {
                                $('#prevButton').attr('disabled', false);
                            }

                            if(currentPage >= totalPages){
                                $('#nextButton').attr('disabled', true);
                            } else {
                                $('#nextButton').attr('disabled', false);
                            }
                        } else {
                            // Handle errors
                            const errorMsg = response.message || 'An error occurred while fetching clients.';
                            $('#clientsTableBody').html('<tr><td colspan="2" class="px-4 py-2 border-b border-gray-200 text-red-500">' + escapeHtml(errorMsg) + '</td></tr>');
                        }
                    },
                    error: function(xhr, status, error){
                        // Handle AJAX errors
                        $('#clientsTableBody').html('<tr><td colspan="2" class="px-4 py-2 border-b border-gray-200 text-red-500">An error occurred: ' + escapeHtml(error) + '</td></tr>');
                    }
                });
            }

            // Function to escape HTML to prevent XSS
            function escapeHtml(text) {
                if(!text) return '';
                return $('<div>').text(text).html();
            }

            // Initial fetch
            fetchClients();

            // Search input event
            $('#searchInput').on('keyup', function(){
                const query = $(this).val().trim();
                currentSearch = query;
                currentPage = 1;
                fetchClients(currentPage, currentSearch);
            });

            // Previous button click
            $('#prevButton').on('click', function(){
                if(currentPage > 1){
                    currentPage--;
                    fetchClients(currentPage, currentSearch);
                }
            });

            // Next button click
            $('#nextButton').on('click', function(){
                if(currentPage < totalPages){
                    currentPage++;
                    fetchClients(currentPage, currentSearch);
                }
            });
        });
    </script>
</body>
</html>
