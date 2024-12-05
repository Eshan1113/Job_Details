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
<?php Include ('header.php');?>

    <!-- View Job Details Table -->
    <div class="container mx-auto mt-8 p-6 bg-white rounded shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Job Details</h2>
        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Year</th>
                    <th class="px-4 py-2">Month</th>
                    <th class="px-4 py-2">Client</th>
                    <th class="px-4 py-2">DT Job Number</th>
                    <th class="px-4 py-2">Target Date</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $job): ?>
                    <tr>
                        <td class="px-4 py-2"><?php echo $job['Year']; ?></td>
                        <td class="px-4 py-2"><?php echo $job['Month']; ?></td>
                        <td class="px-4 py-2"><?php echo $job['Client']; ?></td>
                        <td class="px-4 py-2"><?php echo $job['DTJobNumber']; ?></td>
                        <td class="px-4 py-2"><?php echo $job['TargetDate']; ?></td>
                        <td class="px-4 py-2">
                            <a href="edit_job.php?id=<?php echo $job['Order_ID']; ?>" class="text-blue-500 hover:text-blue-700">Edit</a> | 
                            <a href="delete_job.php?id=<?php echo $job['Order_ID']; ?>" class="text-red-500 hover:text-red-700">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
