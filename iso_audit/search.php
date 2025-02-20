<?php
include_once 'include/header.php';
require_once '../db_conn.php';

$searchTerm = isset($_GET['query']) ? $_GET['query'] : '';

if ($searchTerm) {
    $sql = "SELECT * FROM iso_audit_details WHERE DTJobNumber LIKE ? OR TypeOfWork LIKE ? OR inspection_status LIKE ? OR jobs_status LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTermWithWildcards = '%' . $searchTerm . '%';
    $stmt->bind_param('ssss', $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards, $searchTermWithWildcards);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<p>' . htmlspecialchars($row['DTJobNumber']) . ' - ' . htmlspecialchars($row['TypeOfWork']) . '</p>';
        }
    } else {
        echo 'No results found.';
    }

    $stmt->close();
}

$conn->close();
?>
