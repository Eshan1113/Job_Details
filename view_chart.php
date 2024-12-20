<?php
// view_chart.php

session_start();

// Database Connection Parameters
$host = 'localhost';           // e.g., 'localhost'
$db   = 'complete_dt_jobs';    // e.g., 'jayantha_1500_db'
$user = 'root';                // e.g., 'root'
$pass = '';                    // e.g., 'password123'
$charset = 'utf8mb4';

// Initialize Data Arrays
$labels = [];
$counts = [];

try {
    // Set up the PDO DSN (Data Source Name)
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    // PDO options for better error handling and performance
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulation
    ];

    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);

    // SQL Query to count jobs grouped by Year and Month
    $sql = "
        SELECT 
            Year, 
            Month, 
            COUNT(*) AS job_count
        FROM 
            jayantha_1500_table
        WHERE 
            Year IS NOT NULL AND Month IS NOT NULL
        GROUP BY 
            Year, Month
        ORDER BY 
            Year ASC, 
            FIELD(Month, 'January','February','March','April','May','June','July','August','September','October','November','December') ASC
    ";

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll();

    // Process the results to prepare labels and counts for the chart
    foreach ($results as $row) {
        $year = $row['Year'];
        $month = $row['Month'];
        $count = (int)$row['job_count'];

        // Create a label in the format "Year - Month" (e.g., "2023 - January")
        $labels[] = "$year - $month";

        // Append the count to the counts array
        $counts[] = $count;
    }

} catch (PDOException $e) {
    // Handle any database connection or query errors
    $_SESSION['message'] = 'Database error: ' . htmlspecialchars($e->getMessage());
    $_SESSION['message_type'] = 'error';
}

// Include the header if you have one
// Ensure that 'header.php' does not contain opening <html>, <head>, or <body> tags
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Creation Chart</title>
    <!-- Include Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include Tailwind CSS via CDN (optional, for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Customize the canvas size further if needed */
        #jobChart {
            /* Example: Set maximum width and height */
            max-width: 1600px;   /* Increased from 1200px */
            max-height: 800px;   /* Increased from 600px */
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto p-6"> <!-- Increased max-width from 6xl to 7xl -->
        <h1 class="text-4xl font-bold mb-6 text-center">Job Creation Overview</h1> <!-- Increased font size and centered the title -->
        
        <!-- Success or Error Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="p-4 mb-6 <?php echo ($_SESSION['message_type'] == 'success') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?> rounded">
                <?php 
                    echo htmlspecialchars($_SESSION['message']); 
                    unset($_SESSION['message'], $_SESSION['message_type']); 
                ?>
            </div>
        <?php endif; ?>

        <!-- Chart Container -->
        <div class="bg-white p-8 rounded shadow w-full h-128"> <!-- Increased padding and height -->
            <canvas id="jobChart"></canvas>
        </div>
    </div>

    <script>
        // Prepare the data passed from PHP to JavaScript
        const labels = <?php echo json_encode($labels); ?>;
        const counts = <?php echo json_encode($counts); ?>;

        // Function to render the chart
        function renderChart(labels, data) {
            const ctx = document.getElementById('jobChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // Change to 'line', 'pie', etc., if desired
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Jobs Created',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)', // Bar color
                        borderColor: 'rgba(54, 162, 235, 1)',       // Border color
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Allows the chart to resize properly
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false, // Show all labels
                                maxRotation: 90, // Rotate labels if necessary
                                minRotation: 45
                            },
                            title: {
                                display: true,
                                text: 'Year - Month',
                                font: {
                                    size: 18
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jobs Created',
                                font: {
                                    size: 18
                                }
                            },
                            ticks: {
                                precision:0 // Ensure whole numbers on Y-axis
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Jobs Created Over Time',
                            font: {
                                size: 22
                            }
                        },
                        tooltip: {
                            enabled: true
                        },
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: {
                                    size: 16
                                }
                            }
                        }
                    }
                }
            });
        }

        // Check if there is data to display
        if(labels.length > 0 && counts.length > 0) {
            renderChart(labels, counts);
        } else {
            // Display a message if there is no data
            const chartContainer = document.getElementById('jobChart').parentElement;
            chartContainer.innerHTML = '<p class="text-red-600 text-center text-lg">No job data available to display.</p>';
        }
    </script>
</body>
</html>
