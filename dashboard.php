<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- <link rel="stylesheet" href="style2.css"> -->
</head>
<body>
    <div class="relative">
        <!-- Logo -->
        <img src="computer service.jpg" id="logo" alt="Logo" class="h-20 m-5 block" />
    
        <!-- Top-right section -->
        <div id="top-right" class="absolute top-5 right-5 flex items-center justify-end gap-3">
            <!-- Welcome Text -->
            <span class="text-gray-700 font-medium">Welcome, Expert</span>
    
            <!-- Logout Button -->
            <button onclick="logout()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Logout
            </button>
        </div>
    </div>
    <div class="flex">
        <div class="w-1/4 bg-blue-800 text-white min-h-screen p-4">
            <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
            <ul>
                   <li><a href="resolve_complaint.php" class="block py-2 px-4 text-lg hover:bg-blue-700 rounded">Resolve Complaint</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="w-3/4 p-6">
            <h1 class="text-3xl font-semibold mb-6">Welcome to the Complaint Dashboard</h1>

            <!-- Add content here depending on the page you are on -->
            <p class="text-lg text-gray-700">Choose an option from the sidebar to manage complaints.</p>
        </div>
    </div>
    <script>
        function logout() {
            // Redirect to the logout page or handle logout logic
            window.location.href = 'logout.php';
        }
</script>
</body>
</html>
