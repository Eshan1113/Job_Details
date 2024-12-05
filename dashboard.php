<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php Include ('header.php');?>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Add Job Details</h2>

        <!-- Success or Error Message -->
       

        <form action="submit_job.php" method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="Year" class="block text-sm font-semibold text-gray-700">Year</label>
                    <input type="number" name="Year" id="Year" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
                <div>
                    <label for="Month" class="block text-sm font-semibold text-gray-700">Month</label>
                    <input type="text" name="Month" id="Month" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
            </div>
            <div class="mt-4">
                <label for="DTJobNumber" class="block text-sm font-semibold text-gray-700">DT Job Number</label>
                <input type="text" name="DTJobNumber" id="DTJobNumber" class="mt-1 p-2 w-full border rounded-md" required>
            </div>
            <div class="mt-4">
                <label for="HOJobNumber" class="block text-sm font-semibold text-gray-700">HO Job Number</label>
                <input type="text" name="HOJobNumber" id="HOJobNumber" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="Client" class="block text-sm font-semibold text-gray-700">Client</label>
                <input type="text" name="Client" id="Client" class="mt-1 p-2 w-full border rounded-md" required>
            </div>
            <div class="mt-4">
                <label for="DateOpened" class="block text-sm font-semibold text-gray-700">Date Opened</label>
                <input type="date" name="DateOpened" id="DateOpened" class="mt-1 p-2 w-full border rounded-md" required>
            </div>
            <div class="mt-4">
                <label for="Description_Of_Work" class="block text-sm font-semibold text-gray-700">Description of Work</label>
                <textarea name="Description_Of_Work" id="Description_Of_Work" rows="4" class="mt-1 p-2 w-full border rounded-md" required></textarea>
            </div>
            <div class="mt-4">
                <label for="TargetDate" class="block text-sm font-semibold text-gray-700">Target Date</label>
                <input type="date" name="TargetDate" id="TargetDate" class="mt-1 p-2 w-full border rounded-md" required>
            </div>
            <div class="mt-4">
                <label for="CompletionDate" class="block text-sm font-semibold text-gray-700">Completion Date</label>
                <input type="date" name="CompletionDate" id="CompletionDate" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="DeliveredDate" class="block text-sm font-semibold text-gray-700">Delivered Date</label>
                <input type="date" name="DeliveredDate" id="DeliveredDate" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="FileClosed" class="block text-sm font-semibold text-gray-700">File Closed</label>
                <select name="FileClosed" id="FileClosed" class="mt-1 p-2 w-full border rounded-md" required>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="mt-4">
                <label for="LabourHours" class="block text-sm font-semibold text-gray-700">Labour Hours</label>
                <input type="number" step="0.01" name="LabourHours" id="LabourHours" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="MaterialCost" class="block text-sm font-semibold text-gray-700">Material Cost</label>
                <input type="number" step="0.01" name="MaterialCost" id="MaterialCost" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="TypeOfWork" class="block text-sm font-semibold text-gray-700">Type of Work</label>
                <input type="text" name="TypeOfWork" id="TypeOfWork" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-4">
                <label for="Remarks" class="block text-sm font-semibold text-gray-700">Remarks</label>
                <textarea name="Remarks" id="Remarks" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>



    <script>
        $(document).ready(function() {
            $('#jobForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Get the form data

                $.ajax({
                    url: 'submit_job.php',  // The PHP file that will process the form
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Parse the response
                        var data = JSON.parse(response);
                        
                        // Show success or error message
                        $('#message').removeClass('hidden');
                        if (data.success) {
                            $('#message').addClass('bg-green-500').text(data.message);
                        } else {
                            $('#message').addClass('bg-red-500').text(data.message);
                        }

                        // Optionally clear the form
                        $('#jobForm')[0].reset();
                    },
                    error: function() {
                        $('#message').removeClass('hidden').addClass('bg-red-500').text('An error occurred. Please try again later.');
                    }
                });
            });
        });
    </script>
</body>
</html>
