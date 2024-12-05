<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('db_conn.php');
$sql = "SELECT * FROM jobdetails";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$jobs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php Include('header.php');?>

<!-- View Job Details Table with Horizontal Scrolling -->
<div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-xl">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Job Details</h2>

    <!-- Table wrapper with horizontal scroll -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse bg-gray-100 rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left">Order ID</th>
                    <th class="px-6 py-3 text-left">Year</th>
                    <th class="px-6 py-3 text-left">Month</th>
                    <th class="px-6 py-3 text-left">DT Job Number</th>
                    <th class="px-6 py-3 text-left">HO Job Number</th>
                    <th class="px-6 py-3 text-left">Client</th>
                    <th class="px-6 py-3 text-left">Date Opened</th>
                    <th class="px-6 py-3 text-left">Description of Work</th>
                    <th class="px-6 py-3 text-left">Target Date</th>
                    <th class="px-6 py-3 text-left">Completion Date</th>
                    <th class="px-6 py-3 text-left">Delivered Date</th>
                    <th class="px-6 py-3 text-left">File Closed</th>
                    <th class="px-6 py-3 text-left">Labour Hours</th>
                    <th class="px-6 py-3 text-left">Material Cost</th>
                    <th class="px-6 py-3 text-left">Type of Work</th>
                    <th class="px-6 py-3 text-left">Remarks</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $index => $job): ?>
                    <tr class="border-b hover:bg-gray-50 <?php echo $index % 2 == 0 ? 'bg-white' : 'bg-gray-100'; ?>">
                        <td class="px-6 py-4"><?php echo $job['Order_ID']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['Year']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['Month']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['DTJobNumber']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['HOJobNumber']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['Client']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['DateOpened']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['Description_Of_Work']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['TargetDate']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['CompletionDate']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['DeliveredDate']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['FileClosed'] ? 'Yes' : 'No'; ?></td>
                        <td class="px-6 py-4"><?php echo $job['LabourHours']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['MaterialCost']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['TypeOfWork']; ?></td>
                        <td class="px-6 py-4"><?php echo $job['Remarks']; ?></td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="edit_job.php?id=<?php echo $job['Order_ID']; ?>" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                            <a href="delete_job.php?id=<?php echo $job['Order_ID']; ?>" class="text-red-600 hover:text-red-800 font-semibold">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
