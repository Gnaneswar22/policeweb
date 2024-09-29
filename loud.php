<?php
session_start();

$name = $_POST['name'];
$contact = $_POST['contact'];
$event = $_POST['event'];
$date = $_POST['date'];
$time = $_POST['time'];

if (!empty($name) && !empty($contact) && !empty($event) && !empty($date) && !empty($time)) {
    $host = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "loudspeaker";

    $conn = new mysqli($host, $username, $dbpassword, $dbname);
    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT = "SELECT name from loudspeaker where name = ? limit 1";
        $INSERT = "INSERT into loudspeaker (name, contact, event, date, time) values(?,?,?,?,?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $name); // Assuming contact is of type INT
        $stmt->execute();
        $stmt->bind_result($name);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            // Contact is unique, proceed with insertion
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sisss", $name, $contact, $event, $date, $time);
            if ($stmt->execute()) {
                echo "Your request has been submitted successfully";
            } else {
                echo "Error inserting data: " . $stmt->error;
            }
        } else {
            echo "Someone already registered using this contact";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
}
?>