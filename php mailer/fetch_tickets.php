<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "complaints_db";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all tickets
$sql = "SELECT id, ticket_number, customer_email, customer_name, complaint_description, priority, category, created_at, status FROM complaints";
$result = $conn->query($sql);

$tickets = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($tickets);

$conn->close();
?>
