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

// Check the request method to determine if it's a GET or POST request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if a ticket ID is provided in the query string
    if (isset($_GET['ticket_id'])) {
        // Fetch a specific ticket by ID
        $ticket_id = $_GET['ticket_id'];
        $sql = "SELECT * FROM complaints WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $ticket = $result->fetch_assoc();

        echo json_encode($ticket); // Return the ticket details as a JSON response
        $stmt->close();
    } else {
        // Fetch all tickets
        $sql = "SELECT * FROM complaints";
        $result = $conn->query($sql);

        $tickets = [];
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }

        echo json_encode($tickets); // Return all tickets as a JSON response
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update ticket status
    $ticket_id = $_POST['ticket_id'];
    $status = $_POST['status'];

    // Update ticket status in the database
    $sql = "UPDATE complaints SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $ticket_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating status']);
    }

    $stmt->close();
}

$conn->close();
?>













