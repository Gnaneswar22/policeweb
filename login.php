<?php
session_start(); // Start a session to store user data

$username = $_POST['first'];
$password = $_POST['password'];

if (!empty($username) && !empty($password)) {
    // Database connection details (same as in your registration script)
    $host = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "police_login";

    $conn = new mysqli($host, $username, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT = "SELECT id, username, password FROM users WHERE username = ? AND password = ?";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->bind_result($id, $username, $password);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 1) {
            $stmt->fetch();
            $_SESSION['id'] = $id; // Store user ID in session
            $_SESSION['username'] = $username; // Store username in session
            header("Location: homepage.html"); // Redirect to homepage
            exit();
        } else {
            echo "Invalid username or password";
        }
    }
} else {
    echo "All fields are required";
}