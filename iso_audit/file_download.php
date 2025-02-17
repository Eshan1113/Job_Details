<?php
$file = $_GET['file'];
$filePath = 'C:/xampp/htdocs/JobDetails/iso_audit/uploads/audit_files/' . basename($file); // Adjust path as needed

if (file_exists($filePath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
} else {
    http_response_code(404);
    die('File not found');
}
?>