<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $company_name=$_POST['company_name'];
    $phone_no=$_POST['phone_no'];

    $sql = "INSERT INTO users (name, email, password, role,company_name,phone_no) VALUES ('$name', '$email', '$password', 'user','$company_name','$phone_no')";

    if ($conn->query($sql) === TRUE) {
        header('Location: login.php');
        exit;
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<img src="computer service.jpg" id="logo" alt="Logo">
     
    <form action="signup.php" method="POST">
        <h2>Signup</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="company_name" placeholder="Company Name">
        <input type="tel" name="phone_no" placeholder="Phone Number">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Signup</button>
    </form>
</body>
</html>
