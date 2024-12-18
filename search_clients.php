<?php
// search_clients.php
session_start();
header('Content-Type: application/json');
include('db_conn.php');

// Initialize response array
$response = [
    'success' => false,
    'data' => [],
    'message' => ''
];

// Retrieve and sanitize POST parameters
$search = trim($_POST['search'] ?? '');
$page = isset($_POST['page']) && is_numeric($_POST['page']) ? (int)$_POST['page'] : 1;
$recordsPerPage = isset($_POST['recordsPerPage']) && is_numeric($_POST['recordsPerPage']) ? (int)$_POST['recordsPerPage'] : 10;

// Calculate the offset
$offset = ($page - 1) * $recordsPerPage;

// Prepare the SQL query with search and pagination
if($search === ''){
    // If search is empty, fetch all clients with pagination
    $countQuery = "SELECT COUNT(*) FROM client_list";
    $dataQuery = "SELECT ref_no, client FROM client_list ORDER BY ref_no ASC LIMIT :limit OFFSET :offset";
    $params = [];
} else {
    // Fetch clients that match the search query (case-insensitive) with pagination
    $countQuery = "SELECT COUNT(*) FROM client_list WHERE client LIKE :search";
    $dataQuery = "SELECT ref_no, client FROM client_list WHERE client LIKE :search ORDER BY ref_no ASC LIMIT :limit OFFSET :offset";
    $params = [':search' => '%' . $search . '%'];
}

try {
    // Count total matching records
    $countStmt = $pdo->prepare($countQuery);
    if($search !== ''){
        $countStmt->bindParam(':search', $params[':search'], PDO::PARAM_STR);
    }
    $countStmt->execute();
    $totalRecords = $countStmt->fetchColumn();
    
    // Calculate total pages
    $totalPages = ceil($totalRecords / $recordsPerPage);
    $totalPages = $totalPages > 0 ? $totalPages : 1;

    // Fetch the relevant records
    $dataStmt = $pdo->prepare($dataQuery);
    if($search !== ''){
        $dataStmt->bindParam(':search', $params[':search'], PDO::PARAM_STR);
    }
    $dataStmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
    $dataStmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $dataStmt->execute();
    $clients = $dataStmt->fetchAll();

    // Populate the response
    $response['success'] = true;
    $response['data'] = [
        'clients' => $clients,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];
} catch (PDOException $e) {
    // Handle error appropriately
    $response['message'] = "Database Error: " . $e->getMessage();
}

// Return the response as JSON
echo json_encode($response);
exit();
?>
