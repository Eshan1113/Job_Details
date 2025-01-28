<?php
require_once '../db_conn.php'; // Adjust the path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'date_audited','DTJobNumber', 'job_status',
        'master_job_files_avail', 'critical_doc_order', 'fab_repair_simultaneou',
        'all_inspection_reports', 'critical_doc_signed', 'delivery_details_attach',
        'customer_feedback_atta', 'free_service_certs_attadenum',
        'calibration_reports_atta', 'extra_services_attached',
        'overall_satisfaction', 'auditor_name', 'ncr_raised', 'auditor_comments'
    ];

    $data = [];
    foreach ($fields as $field) {
        $data[$field] = $_POST[$field] ?? null;
    }

    $sql = "INSERT INTO audit_table (" . implode(',', $fields) . ") 
            VALUES (:" . implode(', :', $fields) . ")";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute($data)) {
        echo "Audit record submitted successfully.";
    } else {
        echo "Failed to submit the audit record.";
    }
}
?>
