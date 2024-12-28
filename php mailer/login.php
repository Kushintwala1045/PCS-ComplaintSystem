<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check credentials
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;

        // Check if the user is an expert and get their expert_id
        $expert_id = $user['expert_id'];

        // Check if the user is an admin (Assuming 'role' is a column in the users table)
        $role = $user['role']; // For example: 'admin' or 'user'

        // Redirect based on role
        if ($role === 'admin') {
            // Redirect to the admin dashboard
            header('Location: dashboard.html');
        } elseif ($expert_id > 0) {
            // If expert_id is not null, redirect to the expert dashboard
            header('Location: dashboard.php?expert_id=' . $expert_id);
        } else {
            // For other users (non-experts), redirect to the default user dashboard
            header('Location: index.html');
        }
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style2.css">
    <img src="computer service.jpg" id="logo" alt="Logo">
</head>
<body>
    <form action="login.php" method="POST">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <a href="signup.php">Don't have an Account?</a>
    </form>
</body>
</html>
