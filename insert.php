<?php
session_start(); // Start a session to store user data

$username = $_POST['first'];
$password = $_POST['password'];
$email = $_POST['email'];



if (!empty($username) && !empty($password) && !empty($email)) {
    $host = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "police_login";

    // Create connection
    $conn = new mysqli($host, $username, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT = "SELECT email from users where email = ? limit 1";
        $INSERT = "INSERT into users (username, password, email) values(?,?,?)";

        // Prepare SELECT statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 0) {
            // Email is unique, proceed with insertion
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sss", $username, $password, $email);
            $stmt->execute();

            // After successful insertion, start a session and redirect
            $_SESSION['user_id'] = $stmt->insert_id; // Store the inserted user ID in the session
            $_SESSION['username'] = $username;
            header("Location: homepage.html"); // Redirect to the homepage
            exit();
        } else {
            echo "Someone already registered using this email";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
}
?>