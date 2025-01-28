<?php
session_start();

// Include the database connection
require_once 'db_conn.php'; // Adjust the path if needed

// Check if the user is already logged in, if so, redirect them
if (isset($_SESSION['user_id'])) {
    header('Location: iso_Audit.php'); // Redirect to the iso_Audit.php page
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to find user by username
    $sql = "SELECT * FROM iso_login WHERE username = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':username' => $username]);

    // Check if user exists
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, create session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Success message
        $_SESSION['message'] = 'Login successful!';
        $_SESSION['message_type'] = 'success';

        // Redirect to iso_Audit.php
        header('Location: iso_Audit.php');
        exit;
    } else {
        // Invalid username or password
        $_SESSION['message'] = 'Invalid username or password!';
        $_SESSION['message_type'] = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../css/tailwind.min.css" rel="stylesheet">
    <link href="../css/all.min.css" rel="stylesheet">
    <link href="../font/css/all.min.css" rel="stylesheet">
    <link href="../css/select2.min.css" rel="stylesheet" />
    <script src="../css/jquery-3.6.0.min.js"></script>
    <script src="../css/select2.min.js"></script>
</head>

<body class="bg-gray-100 p-10">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>

        <!-- Error or Success Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div
                class="p-4 mb-4 text-white rounded <?= $_SESSION['message_type'] === 'success' ? 'bg-green-500' : 'bg-red-500' ?>">
                <?= $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="login.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold text-gray-700">Username</label>
                <input type="text" name="username" id="username" class="mt-1 p-2 w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 p-2 w-full border rounded-md" required>
            </div>
            <div class="mt-6 flex justify-end space-x-4">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Login</button>
                <button id="backButton" type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                    Back
                </button>
            </div>
        </form>
    </div>
    <script>
        // Back button functionality
        $('#backButton').on('click', function() {
            window.history.back();
        });
    </script>
</body>

</html>
