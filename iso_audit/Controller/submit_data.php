<?php
session_start(); // Start the session to retrieve session data

// Include your database connection
require_once '../db_conn.php'; // Adjust the path to your database connection file
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Initialize variables for success message and redirection
$successMessage = '';
$redirectUrl = '../audit/new_audit.php'; // Default redirection URL

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data and session variables
    $date_audited = isset($_POST['date_audited']) ? $_POST['date_audited'] : $_SESSION['date_audited'];
    $job_status = isset($_POST['job_status']) ? $_POST['job_status'] : $_SESSION['job_status'];
    $inspection_status = isset($_POST['inspection_status']) ? $_POST['inspection_status'] : $_SESSION['inspection_status'];
    $DTJobNumber = isset($_POST['DTJobNumber']) ? $_POST['DTJobNumber'] : $_SESSION['DTJobNumber'];
    $TypeOfWork = isset($_POST['TypeOfWork']) ? $_POST['TypeOfWork'] : $_SESSION['TypeOfWork'];

    // Ensure proper values for the 'ENUM' columns
    $job_order_issued_by_fm = isset($_POST['job_order_issued_by_fm']) && in_array($_POST['job_order_issued_by_fm'], ['Yes', 'No']) ? $_POST['job_order_issued_by_fm'] : NULL;
    $master_job_files_avail = isset($_POST['master_job_files_avail']) ? $_POST['master_job_files_avail'] : NULL;
    $spec_sheets_and_all_fabr_drawings = isset($_POST['spec_sheets_and_all_fabr_drawings']) ? $_POST['spec_sheets_and_all_fabr_drawings'] : NULL;
    $complete_set_of_qa_forms = isset($_POST['complete_set_of_qa_forms']) ? $_POST['complete_set_of_qa_forms'] : NULL;

    // Ensure numeric fields have valid values (or default to 0 if empty or non-numeric)
    $physical_pro_percent = isset($_POST['physical_pro_percent']) && is_numeric($_POST['physical_pro_percent']) ? $_POST['physical_pro_percent'] : 0;
    $qa_pro_percent = isset($_POST['qa_pro_percent']) && is_numeric($_POST['qa_pro_percent']) ? $_POST['qa_pro_percent'] : 0;

    // Handle 'overall_satisfaction' ENUM values
    $overall_satisfaction = isset($_POST['overall_satisfaction']) && in_array($_POST['overall_satisfaction'], ['V.good', 'good', 'fair', 'V.bad']) ? $_POST['overall_satisfaction'] : NULL;

    // Other form data
    $tank_joining_report = isset($_POST['tank_joining_report']) ? $_POST['tank_joining_report'] : NULL;
    $manhole_test_report = isset($_POST['manhole_test_report']) ? $_POST['manhole_test_report'] : NULL;
    $tank_test_report = isset($_POST['tank_test_report']) ? $_POST['tank_test_report'] : NULL;
    $valve_body_test_report = isset($_POST['valve_body_test_report']) ? $_POST['valve_body_test_report'] : NULL;
    $valve_test_report = isset($_POST['valve_test_report']) ? $_POST['valve_test_report'] : NULL;
    $letter_to_chassis_manufacturer = isset($_POST['letter_to_chassis_manufacturer']) ? $_POST['letter_to_chassis_manufacturer'] : NULL;
    $fire_extinguisher_report = isset($_POST['fire_extinguisher_report']) ? $_POST['fire_extinguisher_report'] : NULL;
    $axel_alignment_test_report = isset($_POST['axel_alignment_test_report']) ? $_POST['axel_alignment_test_report'] : NULL;
    $pressure_test_report = isset($_POST['pressure_test_report']) ? $_POST['pressure_test_report'] : NULL;
    $aeration_test_report = isset($_POST['aeration_test_report']) ? $_POST['aeration_test_report'] : NULL;
    $calibration_chart = isset($_POST['calibration_chart']) ? $_POST['calibration_chart'] : NULL;
    $final_check_list_inspection_report = isset($_POST['final_check_list_inspection_report']) ? $_POST['final_check_list_inspection_report'] : NULL;
    $labour_hours_sheet = isset($_POST['labour_hours_sheet']) ? $_POST['labour_hours_sheet'] : NULL;
    $all_inspection_reports_signed = isset($_POST['all_inspection_reports_signed']) ? $_POST['all_inspection_reports_signed'] : NULL;
    $critical_doc_signed = isset($_POST['critical_doc_signed']) ? $_POST['critical_doc_signed'] : NULL;
    $delivery_details_attach = isset($_POST['delivery_details_attach']) ? $_POST['delivery_details_attach'] : NULL;
    $customer_feedback_attach = isset($_POST['customer_feedback_attach']) ? $_POST['customer_feedback_attach'] : NULL;
    $service_at_cost = isset($_POST['service_at_cost']) ? $_POST['service_at_cost'] : NULL;
    $all_reports_signed = isset($_POST['all_reports_signed']) ? $_POST['all_reports_signed'] : NULL;
    $if_no_specify = isset($_POST['if_no_specify']) ? $_POST['if_no_specify'] : NULL;
    $extra_works_attached = isset($_POST['extra_works_attached']) ? $_POST['extra_works_attached'] : NULL;
    $ncr_raised = isset($_POST['ncr_raised']) ? $_POST['ncr_raised'] : NULL;
    $ncr_specify = isset($_POST['ncr_specify']) ? $_POST['ncr_specify'] : NULL;
    $auditor_comments = isset($_POST['auditor_comments']) ? $_POST['auditor_comments'] : NULL;
    $auditor_name = isset($_POST['auditor_name']) ? $_POST['auditor_name'] : NULL;

    // Handle file upload (if needed)
    $attachment = '';
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $fileName = $_FILES['attachment']['name'];
        $fileTmpName = $_FILES['attachment']['tmp_name'];
        $fileSize = $_FILES['attachment']['size'];
        $fileError = $_FILES['attachment']['error'];

        if ($fileError === UPLOAD_ERR_OK) {
            if ($fileSize > 1000000) { // 1MB size limit for this example
                echo "Error: File size is too large.";
            } else {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($fileName);

                if (move_uploaded_file($fileTmpName, $target_file)) {
                    $attachment = $target_file; // Save the file path in the database
                } else {
                    echo "Error uploading file!";
                }
            }
        } else {
            echo "Error: Unable to upload the file. Error code: " . $fileError;
        }
    }

    // Prepare SQL insert statement
    $query = "INSERT INTO iso_audit_details (
        date_audited, TypeOfWork, inspection_status, jobs_status, DTJobNumber,
        job_order_issued_by_fm, master_job_files_avail, spec_sheets_and_all_fabr_drawings, 
        complete_set_of_qa_forms, physical_pro_percent, qa_pro_percent, tank_joining_report,
        manhole_test_report, tank_test_report, valve_body_test_report, valve_test_report, 
        letter_to_chassis_manufacturer, fire_extinguisher_report, axel_alignment_test_report,
        pressure_test_report, aeration_test_report, calibration_chart, 
        final_check_list_inspection_report, labour_hours_sheet, all_inspection_reports_signed, 
        critical_doc_signed, delivery_details_attach, customer_feedback_attach, 
        service_at_cost, all_reports_signed, if_no_specify, extra_works_attached, 
        overall_satisfaction, ncr_raised, ncr_specify, attachment, auditor_comments, auditor_name
    ) VALUES (
        :date_audited, :TypeOfWork, :inspection_status, :jobs_status, :DTJobNumber,
        :job_order_issued_by_fm, :master_job_files_avail, :spec_sheets_and_all_fabr_drawings, 
        :complete_set_of_qa_forms, :physical_pro_percent, :qa_pro_percent, :tank_joining_report,
        :manhole_test_report, :tank_test_report, :valve_body_test_report, :valve_test_report, 
        :letter_to_chassis_manufacturer, :fire_extinguisher_report, :axel_alignment_test_report,
        :pressure_test_report, :aeration_test_report, :calibration_chart, 
        :final_check_list_inspection_report, :labour_hours_sheet, :all_inspection_reports_signed, 
        :critical_doc_signed, :delivery_details_attach, :customer_feedback_attach, 
        :service_at_cost, :all_reports_signed, :if_no_specify, :extra_works_attached, 
        :overall_satisfaction, :ncr_raised, :ncr_specify, :attachment, :auditor_comments, :auditor_name
    )";

    $stmt = $pdo->prepare($query);

    // Bind the parameters
    $stmt->bindParam(':date_audited', $date_audited);
    $stmt->bindParam(':TypeOfWork', $TypeOfWork);
    $stmt->bindParam(':inspection_status', $inspection_status);
    $stmt->bindParam(':jobs_status', $job_status);
    $stmt->bindParam(':DTJobNumber', $DTJobNumber);
    $stmt->bindParam(':job_order_issued_by_fm', $job_order_issued_by_fm);
    $stmt->bindParam(':master_job_files_avail', $master_job_files_avail);
    $stmt->bindParam(':spec_sheets_and_all_fabr_drawings', $spec_sheets_and_all_fabr_drawings);
    $stmt->bindParam(':complete_set_of_qa_forms', $complete_set_of_qa_forms);
    $stmt->bindParam(':physical_pro_percent', $physical_pro_percent);
    $stmt->bindParam(':qa_pro_percent', $qa_pro_percent);
    $stmt->bindParam(':tank_joining_report', $tank_joining_report);
    $stmt->bindParam(':manhole_test_report', $manhole_test_report);
    $stmt->bindParam(':tank_test_report', $tank_test_report);
    $stmt->bindParam(':valve_body_test_report', $valve_body_test_report);
    $stmt->bindParam(':valve_test_report', $valve_test_report);
    $stmt->bindParam(':letter_to_chassis_manufacturer', $letter_to_chassis_manufacturer);
    $stmt->bindParam(':fire_extinguisher_report', $fire_extinguisher_report);
    $stmt->bindParam(':axel_alignment_test_report', $axel_alignment_test_report);
    $stmt->bindParam(':pressure_test_report', $pressure_test_report);
    $stmt->bindParam(':aeration_test_report', $aeration_test_report);
    $stmt->bindParam(':calibration_chart', $calibration_chart);
    $stmt->bindParam(':final_check_list_inspection_report', $final_check_list_inspection_report);
    $stmt->bindParam(':labour_hours_sheet', $labour_hours_sheet);
    $stmt->bindParam(':all_inspection_reports_signed', $all_inspection_reports_signed);
    $stmt->bindParam(':critical_doc_signed', $critical_doc_signed);
    $stmt->bindParam(':delivery_details_attach', $delivery_details_attach);
    $stmt->bindParam(':customer_feedback_attach', $customer_feedback_attach);
    $stmt->bindParam(':service_at_cost', $service_at_cost);
    $stmt->bindParam(':all_reports_signed', $all_reports_signed);
    $stmt->bindParam(':if_no_specify', $if_no_specify);
    $stmt->bindParam(':extra_works_attached', $extra_works_attached);
    $stmt->bindParam(':overall_satisfaction', $overall_satisfaction);
    $stmt->bindParam(':ncr_raised', $ncr_raised);
    $stmt->bindParam(':ncr_specify', $ncr_specify);
    $stmt->bindParam(':attachment', $attachment);
    $stmt->bindParam(':auditor_comments', $auditor_comments);
    $stmt->bindParam(':auditor_name', $auditor_name);

    // Execute the query
    if ($stmt->execute()) {
        $successMessage = "Data successfully inserted!";
    } else {
        $successMessage = "Error inserting data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISO Audit Form Submission Successfully</title>
    <style>
        /* Add some custom styles for the success message */
        .success-message {
            background-color: #28a745;
            color: white;
            padding: 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-radius: 10px;
            width: 80%;
            margin: 50px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .redirect-message {
            text-align: center;
            margin-top: 10px;
            font-size: 16px;
            color: #555;
        }

        /* Dot loading animation */
        .dot-container {
            text-align: center;
            font-size: 24px;
            color: #555;
        }

        .dot {
            display: inline-block;
            margin: 0 5px;
            animation: dot-blink 1.5s infinite;
        }

        .dot:nth-child(1) {
            animation-delay: 0s;
        }
        .dot:nth-child(2) {
            animation-delay: 0.3s;
        }
        .dot:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes dot-blink {
            0%, 100% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }

        /* Add a fade-out effect for the success message */
        .fade-out {
            opacity: 1;
            transition: opacity 1s ease-out;
        }
        .fade-out.hidden {
            opacity: 0;
        }
    </style>
    <script>
        // JavaScript for auto-redirection and message fade-out
        function redirectToNewAudit() {
            window.location.href = "<?php echo $redirectUrl; ?>";
        }

        function hideMessage() {
            const messageBox = document.getElementById("successMessageBox");
            messageBox.classList.add("hidden");
            setTimeout(redirectToNewAudit, 2000); // Redirect after fading out
        }

        // Display success message and redirect after 3 seconds
        <?php if (!empty($successMessage)): ?>
            window.onload = function() {
                setTimeout(hideMessage, 3000); // Hide message and redirect after 3 seconds
            };
        <?php endif; ?>
    </script>
</head>
<body>
    <!-- Display success message if available -->
    <?php if (!empty($successMessage)): ?>
        <div id="successMessageBox" class="success-message fade-out">
            <?php echo $successMessage; ?>
        </div>
        <div class="redirect-message">
            <p>Redirecting to the audit form in 2 seconds...</p>
            <div class="dot-container">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
