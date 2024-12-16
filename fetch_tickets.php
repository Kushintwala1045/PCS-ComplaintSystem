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
        
        // Fetch the assigned expert details
        if ($ticket['expert_id']) {
            $expert_sql = "SELECT * FROM experts WHERE id = ?";
            $expert_stmt = $conn->prepare($expert_sql);
            $expert_stmt->bind_param("i", $ticket['expert_id']);
            $expert_stmt->execute();
            $expert_result = $expert_stmt->get_result();
            $ticket['expert'] = $expert_result->fetch_assoc();
            $expert_stmt->close();
        }

        echo json_encode($ticket); // Return the ticket details with expert info (if assigned)
        $stmt->close();
    } else {
        // Fetch all tickets
        $sql = "SELECT * FROM complaints";
        $result = $conn->query($sql);

        $tickets = [];
        while ($row = $result->fetch_assoc()) {
            // For each ticket, fetch the expert details if assigned
            if ($row['expert_id']) {
                $expert_sql = "SELECT * FROM experts WHERE id = ?";
                $expert_stmt = $conn->prepare($expert_sql);
                $expert_stmt->bind_param("i", $row['expert_id']);
                $expert_stmt->execute();
                $expert_result = $expert_stmt->get_result();
                $row['expert'] = $expert_result->fetch_assoc();
                $expert_stmt->close();
            }
            $tickets[] = $row;
        }

        echo json_encode($tickets); // Return all tickets as a JSON response
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ticket_id']) && isset($_POST['status'])) {
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
    } elseif (isset($_POST['ticket_id']) && isset($_POST['expert_id'])) {
        // Assign expert to a ticket
        $ticket_id = $_POST['ticket_id'];
        $expert_id = $_POST['expert_id'];

        // Update the ticket with the assigned expert
        $sql = "UPDATE complaints SET expert_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $expert_id, $ticket_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error assigning expert']);
        }

        $stmt->close();
    }
}

$conn->close();
?>
