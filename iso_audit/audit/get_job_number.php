<?php
require_once '../db_conn.php';

// Check if TypeOfWork is set
if (isset($_POST['TypeOfWork'])) {
    $typeOfWork = $_POST['TypeOfWork'];

    // Fetch job numbers filtered by TypeOfWork using a JOIN
    $query = "
        SELECT j.DTJobNumber 
        FROM jayantha_1500_table j
        JOIN type_of_work t ON j.TypeOfWork = t.work_type
        WHERE t.work_type = :typeOfWork
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':typeOfWork', $typeOfWork, PDO::PARAM_STR);
    $stmt->execute();
    
    // Fetch the job numbers
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as a JSON response
    echo json_encode($jobs);
}
?>
