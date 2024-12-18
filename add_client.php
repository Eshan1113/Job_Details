<?php
// add_client.php
session_start();
include('db_conn.php');

// Initialize variables
$client = '';
$success = false;
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input
    $client = trim($_POST['client'] ?? '');

    // Basic validation
    if (empty($client)) {
        $error = "Client name is required.";
    } elseif (strlen($client) > 30) {
        $error = "Client name must not exceed 30 characters.";
    } else {
        // Check for duplicate client
        try {
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM client_list WHERE client = :client");
            $checkStmt->bindParam(':client', $client, PDO::PARAM_STR);
            $checkStmt->execute();
            $count = $checkStmt->fetchColumn();
            
            if ($count > 0) {
                $error = "Client already exists.";
            } else {
                // Insert into database
                $stmt = $pdo->prepare("INSERT INTO client_list (client) VALUES (:client)");
                $stmt->bindParam(':client', $client, PDO::PARAM_STR);
                $stmt->execute();
                $success = true;
                $client = ''; // Clear the input field
            }
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}
?>
<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Client</title>
    <!-- Tailwind CSS -->
    <link href="css/tailwind.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link href="font/css/all.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet" />
    <script src="css/jquery-3.6.0.min.js"></script>
    <script src="css/select2.min.js"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto mt-10 p-6 bg-white rounded shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Add New Client</h2>

        <!-- Success Message -->
        <?php if ($success): ?>
            <div id="successMessage" class="mb-4 p-4 text-green-700 bg-green-100 rounded flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>Client added successfully!</span>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if (!empty($error)): ?>
            <div class="mb-4 p-4 text-red-700 bg-red-100 rounded">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Client Addition Form -->
        <form action="add_client.php" method="POST" id="clientForm">
            <div class="mb-4">
                <label for="client" class="block text-gray-700 font-semibold mb-2">Client Name:</label>
                <input type="text" id="client" name="client" maxlength="30" value="<?php echo htmlspecialchars($client); ?>" required
                       class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none">
                Add Client
            </button>
           
    
        </form>
        
    </div>

    <!-- Optional: Link to view the list of clients -->
    
    <div class="container mx-auto mt-4 p-6 text-center">
        <a href="view_clients.php">
        <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none">
            View Clients List
        </button>
    </a>
</div>
    <!-- JavaScript for Success Message and Client-Side Validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide the success message after 3 seconds
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000); // 3000 milliseconds = 3 seconds
            }

            // Client-side validation
            const clientForm = document.getElementById('clientForm');
            clientForm.addEventListener('submit', function(e) {
                const clientInput = document.getElementById('client');
                const client = clientInput.value.trim();
                let errorMessage = '';

                if (client === '') {
                    errorMessage = 'Client name is required.';
                } else if (client.length > 30) {
                    errorMessage = 'Client name must not exceed 30 characters.';
                }

                if (errorMessage !== '') {
                    e.preventDefault();
                    alert(errorMessage);
                }
            });
        });
    </script>
</body>
</html>
