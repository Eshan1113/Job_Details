<?php
// fetch_job_data.php

header('Content-Type: application/json');
session_start();
include('db_conn.php'); // Ensure this file contains your PDO connection as $pdo

try {
    // Query to count jobs grouped by Year and Month
    $stmt = $pdo->prepare("
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
    ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Process data into a structured format
    $data = [];
    foreach ($results as $row) {
        $year = $row['Year'];
        $month = $row['Month'];
        $count = (int)$row['job_count'];

        if (!isset($data[$year])) {
            $data[$year] = [];
        }
        $data[$year][$month] = $count;
    }

    echo json_encode(['status' => 'success', 'data' => $data]);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
