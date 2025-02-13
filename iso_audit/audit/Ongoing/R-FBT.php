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
    <title>Ongoing R-FBT Form</title>
    <link href="../../../css/tailwind.min.css" rel="stylesheet">
    <link href="../../../css/all.min.css" rel="stylesheet">
    <link href="../../../font/css/all.min.css" rel="stylesheet">
    <link href="../../../css/select2.min.css" rel="stylesheet" />
    <script src="../../../css/jquery-3.6.0.min.js"></script>
    <script src="../../../css/select2.min.js"></script>
</head>
<?php ?>
<br>

<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-xl">
        <h1 class="text-3xl font-bold mb-6 text-blue-600 border-b-2 border-blue-200 pb-4">Ongoing R-FBT Audit Form</h1>

        <!-- Bilingual Note -->
        <div class="mb-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
          
            <p class="text-sm text-blue-800">
                <span class="font-bold">Note:</span> Complete all inspection data and verify accuracy. Attach relevant
                verification reports and documents.
            </p>
        </div>
        <form action="../../Controller/submit_data.php" method="POST" enctype="multipart/form-data">
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