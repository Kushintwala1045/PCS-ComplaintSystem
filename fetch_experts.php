<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'complaints_db';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all experts who are not assigned to any complaint
$sql = "SELECT * FROM experts WHERE id NOT IN (SELECT expert_id FROM complaints WHERE status != 'Resolved')";
$result = $conn->query($sql);

$experts = [];
while ($row = $result->fetch_assoc()) {
    $experts[] = $row;
}

echo json_encode($experts); // Return the experts as a JSON response
$conn->close();
?>
