<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Get the logged-in user's name from the session
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iso Audit</title>
    <link href="../css/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-blue-600 p-4">
        <div class="flex items-center justify-between">
            <!-- Logo or App Name -->
            <div class="flex items-center space-x-4">
                <span class="text-white">Welcome, <?php echo $username; ?></span>
               
            </div>

            <!-- Links -->
            <div class="space-x-4">
            <a href="iso_audit.php" class="text-white hover:bg-blue-700 px-4 py-2 rounded">Main Menu</a>
            <a href="audit/new_audit.php" class="text-white hover:bg-blue-700 px-4 py-2 rounded">New Audit</a>
                <a href="view.php" class="text-white hover:bg-blue-700 px-4 py-2 rounded">View Audit Detils</a>
                <a href="../index.php" class="text-white bg-red-500 hover:bg-red-700 px-4 py-2 rounded">Logout</a>
            </div>

            <!-- User Info -->
            
        </div>
    </nav>

    <!-- Main Content -->
   
</body>

</html>
