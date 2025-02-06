<?php
include_once "../../include/header.php"; // Start session to access session variables

// Retrieve session data if available
$date_audited = isset($_SESSION['date_audited']) ? $_SESSION['date_audited'] : '';
$inspection_status = isset($_SESSION['inspection_status']) ? $_SESSION['inspection_status'] : '';
$job_status = isset($_SESSION['job_status']) ? $_SESSION['job_status'] : '';
$DTJobNumber = isset($_SESSION['DTJobNumber']) ? $_SESSION['DTJobNumber'] : '';
$TypeOfWork = isset($_SESSION['TypeOfWork']) ? $_SESSION['TypeOfWork'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>N-SILO Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<?php ?>
<br>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-xl">
        <h1 class="text-3xl font-bold mb-6 text-blue-600 border-b-2 border-blue-200 pb-4">N-SILO Audit Form</h1>

        <!-- Bilingual Note -->
        <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
          
            <p class="text-sm text-blue-800">
                <span class="font-bold">Note:</span> Complete all inspection data and verify accuracy. Attach relevant
                verification reports and documents.
            </p>
        </div>

        <form action="../../Controller/submit_data.php" method="POST">
            <!-- Top Section Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <!-- Date Audited -->
                <div>
                    <label for="date_audited" class="block text-sm font-semibold text-gray-700">Date Audited</label>
                    <input type="text" name="date_audited" id="date_audited"
                        value="<?php echo htmlspecialchars($date_audited); ?>" class="mt-1 p-2 w-full border rounded-md"
                        disabled>
                </div>

                <!-- Inspection Status -->
                <div>
                    <label for="inspection_status" class="block text-sm font-semibold text-gray-700">Inspection
                        Status</label>
                    <input type="text" name="inspection_status" id="inspection_status"
                        value="<?php echo htmlspecialchars($inspection_status); ?>"
                        class="mt-1 p-2 w-full border rounded-md" disabled>
                </div>

                <!-- Job Status -->
                <div>
                    <label for="job_status" class="block text-sm font-semibold text-gray-700">Job Status</label>
                    <input type="text" name="job_status" id="job_status"
                        value="<?php echo htmlspecialchars($job_status); ?>" class="mt-1 p-2 w-full border rounded-md"
                        disabled>
                </div>

                <!-- DTJobNumber -->
                <div>
                    <label for="DTJobNumber" class="block text-sm font-semibold text-gray-700">DTJobNumber</label>
                    <input type="text" name="DTJobNumber" id="DTJobNumber"
                        value="<?php echo htmlspecialchars($DTJobNumber); ?>" class="mt-1 p-2 w-full border rounded-md"
                        disabled>
                </div>

                <!-- Type Of Work -->
                <div>
                    <label for="TypeOfWork" class="block text-sm font-semibold text-gray-700">Type Of Work</label>
                    <input type="text" name="TypeOfWork" id="TypeOfWork"
                        value="<?php echo htmlspecialchars($TypeOfWork); ?>" class="mt-1 p-2 w-full border rounded-md"
                        disabled>
                </div>
            </div>

            <!-- Checkbox Group Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- Job Order Issued by FM -->
                <div class="p-4 border rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Job Order Issued by FM</label>
                    <div class="flex space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="job_order_issued_by_fm" name="job_order_issued_by_fm" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="job_order_issued_by_fm_no" name="job_order_issued_by_fm"
                                value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- Master Job Files Available -->
                <div class="p-4 border rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Master Job Files Available</label>
                    <div class="flex space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="master_job_files_avail" name="master_job_files_avail" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="master_job_files_avail" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="master_job_files_avail_no" name="master_job_files_avail"
                                value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="master_job_files_avail_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <div class="p-4 border rounded-lg">
                    <label for="spec_sheets_and_all_fabr_drawings"
                        class="block text-sm font-medium text-gray-700 mb-2">Specification Sheets and All Fabrication
                        Drawings</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="spec_sheets_and_all_fabr_drawings"
                                name="spec_sheets_and_all_fabr_drawings" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="spec_sheets_and_all_fabr_drawings"
                                class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="spec_sheets_and_all_fabr_drawings_no"
                                name="spec_sheets_and_all_fabr_drawings" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="spec_sheets_and_all_fabr_drawings_no"
                                class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>

                </div>
                <div class="p-4 border rounded-lg">
                    <label for="complete_set_of_qa_forms" class="block text-sm font-medium text-gray-700 mb-2">Complete
                        Set of QA
                        Forms</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="complete_set_of_qa_forms" name="complete_set_of_qa_forms"
                                value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="complete_set_of_qa_forms" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="complete_set_of_qa_forms_no" name="complete_set_of_qa_forms"
                                value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="complete_set_of_qa_forms_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Percentage Inputs -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="physical_pro_percent" class="block text-sm font-medium text-gray-700 mb-2">Physical Pro.
                        %</label>
                    <input type="number" id="physical_pro_percent" name="physical_pro_percent"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm" placeholder="Enter percentage">
                </div>
                <div class="mb-4">
                    <label for="qa_pro_percent" class="block text-sm font-medium text-gray-700 mb-2">QA Pro. %</label>
                    <input type="number" id="qa_pro_percent" name="qa_pro_percent"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm"
                        placeholder="Enter percentage">
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="p-4 border rounded-lg">
                    <label for="tank_joining_report" class="block text-sm font-medium text-gray-700 mb-2">Tank Joining
                        Report</label>
                    <div class="flex space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="tank_joining_report" name="tank_joining_report" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="tank_joining_report" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="tank_joining_report_no" name="tank_joining_report" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="tank_joining_report_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>
                <!-- 47. manhole_test_report -->
                <div class="p-4 border rounded-lg">
                    <label for="manhole_test_report" class="block text-sm font-medium text-gray-700 mb-2">Manhole Test
                        Report</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="manhole_test_report" name="manhole_test_report" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="manhole_test_report" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="manhole_test_report_no" name="manhole_test_report" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="manhole_test_report_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>
                <div class="p-4 border rounded-lg">
                    <label for="tank_test_report" class="block text-sm font-medium text-gray-700 mb-2">Tank Test
                        Report</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="tank_test_report" name="tank_test_report" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="tank_test_report" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="tank_test_report_no" name="tank_test_report" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="tank_test_report_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>
                <div class="p-4 border rounded-lg">
                    <label for="valve_body_test_report" class="block text-sm font-medium text-gray-700 mb-2">Valve Body
                        Test
                        Report</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="valve_body_test_report" name="valve_body_test_report" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="valve_body_test_report" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="valve_body_test_report_no" name="valve_body_test_report"
                                value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="valve_body_test_report_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 50. valve_test_report -->
                <div class="p-4 border rounded-lg">
                    <label for="valve_test_report" class="block text-sm font-medium text-gray-700 mb-2">Valve Test
                        Report</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="valve_test_report" name="valve_test_report" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="valve_test_report" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="valve_test_report_no" name="valve_test_report" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="valve_test_report_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 51. letter_to_chassis_manufacturer -->
                <div class="p-4 border rounded-lg">
                    <label for="letter_to_chassis_manufacturer"
                        class="block text-sm font-medium text-gray-700 mb-2">Letter to
                        Chassis Manufacturer</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="letter_to_chassis_manufacturer"
                                name="letter_to_chassis_manufacturer" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="letter_to_chassis_manufacturer" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="letter_to_chassis_manufacturer_no"
                                name="letter_to_chassis_manufacturer" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="letter_to_chassis_manufacturer_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 52. fire_extinguisher_report -->
                <div class="p-4 border rounded-lg">
                    <label for="fire_extinguisher_report" class="block text-sm font-medium text-gray-700 mb-2">Fire
                        Extinguisher
                        Report</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="fire_extinguisher_report" name="fire_extinguisher_report"
                                value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="fire_extinguisher_report" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="fire_extinguisher_report_no" name="fire_extinguisher_report"
                                value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="fire_extinguisher_report_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 53. axel_alignment_test_report -->
                <div class="p-4 border rounded-lg">
                    <label for="axel_alignment_test_report" class="block text-sm font-medium text-gray-700 mb-2">Axel
                        Alignment
                        Test Report</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="axel_alignment_test_report" name="axel_alignment_test_report"
                                value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="axel_alignment_test_report" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="axel_alignment_test_report_no" name="axel_alignment_test_report"
                                value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="axel_alignment_test_report_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 54. pressure_test_report-->
                <div class="p-4 border rounded-lg">
                    <label for="pressure_test_report" class="block text-sm font-medium text-gray-700 mb-2">Pressure Test
                        Report</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="pressure_test_report" name="pressure_test_report" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="pressure_test_report" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="pressure_test_report_no" name="pressure_test_report" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="pressure_test_report_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 55. aeration_test_report-->
                <div class="p-4 border rounded-lg">
                    <label for="aeration_test_report" class="block text-sm font-medium text-gray-700 mb-2">Aeration Test
                        Report</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="aeration_test_report" name="aeration_test_report" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="aeration_test_report" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="aeration_test_report_no" name="aeration_test_report" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="aeration_test_report_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 56. calibration_chart -->
                <div class="p-4 border rounded-lg">
                    <label for="calibration_chart" class="block text-sm font-medium text-gray-700 mb-2">Calibration
                        Chart</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="calibration_chart" name="calibration_chart" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="calibration_chart" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="calibration_chart_no" name="calibration_chart" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="calibration_chart_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 57. final_check_list_inspection_report -->
                <div class="p-4 border rounded-lg">
                    <label for="final_check_list_inspection_report"
                        class="block text-sm font-medium text-gray-700 mb-2">Final
                        Checklist Inspection Report</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="final_check_list_inspection_report"
                                name="final_check_list_inspection_report" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="final_check_list_inspection_report"
                                class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="final_check_list_inspection_report_no"
                                name="final_check_list_inspection_report" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="final_check_list_inspection_report_no"
                                class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 58. labour_hours_sheet -->
                <div class="p-4 border rounded-lg">
                    <label for="labour_hours_sheet" class="block text-sm font-medium text-gray-700 mb-2">Labour Hours
                        Sheet</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="labour_hours_sheet" name="labour_hours_sheet" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="labour_hours_sheet" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="labour_hours_sheet_no" name="labour_hours_sheet" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="labour_hours_sheet_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 59. all_inspection_reports_signed -->
                <div class="p-4 border rounded-lg">
                    <label for="all_inspection_reports_signed" class="block text-sm font-medium text-gray-700 mb-2">All
                        Inspection Reports Signed</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="all_inspection_reports_signed"
                                name="all_inspection_reports_signed" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="all_inspection_reports_signed" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="all_inspection_reports_signed_no"
                                name="all_inspection_reports_signed" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="all_inspection_reports_signed_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 60. critical_doc_signed -->
                <div class="p-4 border rounded-lg">
                    <label for="critical_doc_signed" class="block text-sm font-medium text-gray-700 mb-2">Critical
                        Document
                        Signed</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="critical_doc_signed" name="critical_doc_signed" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="critical_doc_signed" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="critical_doc_signed_no" name="critical_doc_signed" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="critical_doc_signed_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 61. delivery_details_attach -->
                <div class="p-4 border rounded-lg">
                    <label for="delivery_details_attach" class="block text-sm font-medium text-gray-700 mb-2">Delivery
                        Details
                        Attach</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="delivery_details_attach" name="delivery_details_attach"
                                value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="delivery_details_attach" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="delivery_details_attach_no" name="delivery_details_attach"
                                value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="delivery_details_attach_no" class="ml-2 text-sm text-gray-700">No
                        </div>
                    </div>
                </div>

                <!-- 62. customer_feedback_attach -->
                <div class="p-4 border rounded-lg">
                    <label for="customer_feedback_attach" class="block text-sm font-medium text-gray-700 mb-2">Customer
                        Feedback
                        Attach</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="customer_feedback_attach" name="customer_feedback_attach"
                                value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="customer_feedback_attach" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="customer_feedback_attach_no" name="customer_feedback_attach"
                                value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="customer_feedback_attach_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 63. service_at_cost -->
                <div class="p-4 border rounded-lg">
                    <label for="service_at_cost" class="block text-sm font-medium text-gray-700 mb-2">Service at
                        Cost</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="service_at_cost" name="service_at_cost" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="service_at_cost" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="service_at_cost_no" name="service_at_cost" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="service_at_cost_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>

                <!-- 64. all_reports_signed -->
                <div class="p-4 border rounded-lg">
                    <label for="all_reports_signed" class="block text-sm font-medium text-gray-700 mb-2">All Reports
                        Signed</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="all_reports_signed" name="all_reports_signed" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="all_reports_signed" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="all_reports_signed_no" name="all_reports_signed" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="all_reports_signed_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label for="if_no_specify" class="block text-sm font-medium text-gray-700">If No, Specify</label>
                <input type="text" id="if_no_specify" name="if_no_specify"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Provide details if 'No'">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- Job Order Issued by FM -->
                <div class="p-4 border rounded-lg">
                    <label for="extra_works_attached" class="block text-sm font-medium text-gray-700 mb-2">Extra Works
                        Attached</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="extra_works_attached" name="extra_works_attached" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="extra_works_attached" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="extra_works_attached_no" name="extra_works_attached" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="extra_works_attached_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>
                <!-- 66. extra_works_attached -->


                <!-- 67. overall_satisfaction -->
                <div class="p-4 border rounded-lg">
                    <label for="overall_satisfaction" class="block text-sm font-medium text-gray-700 mb-2">Overall
                        Satisfaction</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="overall_satisfaction" name="overall_satisfaction" value="v_good"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="overall_satisfaction" class="ml-2 text-sm text-gray-700">Very Good</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="overall_satisfaction_good" name="overall_satisfaction"
                                value="good"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="overall_satisfaction_good" class="ml-2 text-sm text-gray-700">Good</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="overall_satisfaction_fair" name="overall_satisfaction"
                                value="fair"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="overall_satisfaction_fair" class="ml-2 text-sm text-gray-700">Fair</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="overall_satisfaction_v_bad" name="overall_satisfaction"
                                value="v_bad"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="overall_satisfaction_v_bad" class="ml-2 text-sm text-gray-700">Very Bad</label>
                        </div>
                    </div>
                </div>

                <!-- 68. ncr_raised -->
                <div class="p-4 border rounded-lg">
                    <label for="ncr_raised" class="block text-sm font-medium text-gray-700 mb-2">NCR Raised</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="ncr_raised" name="ncr_raised" value="yes"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="ncr_raised" class="ml-2 text-sm text-gray-700">Yes</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="ncr_raised_no" name="ncr_raised" value="no"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="ncr_raised_no" class="ml-2 text-sm text-gray-700">No</label>
                        </div>
                    </div>
                </div>
            </div>     <div class="mb-4">
                <label for="ncr_specify" class="block text-sm font-medium text-gray-700">If Yes, Specify:</label>
                <input type="text" id="ncr_specify" name="ncr_specify"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Specify details of NCR raised">
            </div>
            <div class="mb-4">
                <label for="attachment" class="block text-sm font-medium text-gray-700">Attachment</label>
                <input type="file" id="attachment" name="attachment"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <!-- Final Section -->
            <div class="grid grid-cols-1 gap-4 mb-6">
                <!-- Auditor Comments -->
                <div>
                    <label for="auditor_comments" class="block text-sm font-medium text-gray-700">Auditor
                        Comments</label>
                    <textarea id="auditor_comments" name="auditor_comments"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm" rows="4"
                        placeholder="Enter comments..."></textarea>
                </div>

                <!-- Auditor Name -->
                <div>
                    <label for="auditor_name" class="block text-sm font-medium text-gray-700">Auditor Name</label>
                    <input type="text" id="auditor_name" name="auditor_name"
                        class="mt-1 block w-full px-3 py-2 border rounded-md shadow-sm" placeholder="Auditor name">
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-6 text-center">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Submit
                </button>
                <button type="button" onclick="window.history.back();"
                    class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 ml-4">
                    Back
                </button>
            </div>
        </form>
    </div>

</html>