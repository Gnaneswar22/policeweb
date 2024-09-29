<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "police_login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
print_r($conn);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$name = $_POST['name'];
$contact = $_POST['contact'];
$event = $_POST['event'];
$date = $_POST['date'];
$time = $_POST['time'];

// Check if contact number already exists
$checkContactSql = "SELECT COUNT(*) AS count FROM loudspeaker WHERE contact = ?";
$checkContactStmt = $conn->prepare($checkContactSql);
$checkContactStmt->bind_param("s", $contact);
$checkContactStmt->execute();
$checkContactResult = $checkContactStmt->get_result();
$checkContactRow = $checkContactResult->fetch_assoc();

if ($checkContactRow['count'] > 0) {
    echo "Contact number already exists.";
    exit;
}

// Prepare SQL statement
$sql = "INSERT INTO loudspeaker (name, contact, event, date, time) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param("sssss", $name, $contact, $event, $date, $time);

// Execute statement
if ($stmt->execute()) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>