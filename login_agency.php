<?php
session_start(); // Starting Session
$error = ''; // Variable To Store Error Message

if (isset($_POST['submit'])) {
    if (empty($_POST['agency_username']) || empty($_POST['agency_password'])) {
        $error = "Username or Password is invalid";
    } else {
        // Define $username and $password
        $agency_username = $_POST['agency_username'];
        $agency_password = $_POST['agency_password'];
        
        // Establish a connection to the database
        require 'connection.php';
        $conn = Connect();

        // SQL query to fetch information of registered agencies and find a user match.
        $query = "SELECT agency_username FROM agency WHERE agency_username=? AND agency_password=? LIMIT 1";

        // To protect against SQL injection, use prepared statements
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $agency_username, $agency_password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $_SESSION['login_agency'] = $agency_username; // Initialize Session
            header("location: index.php"); // Redirect to the Index Page
        } else {
            $error = "Username or Password is invalid";
        }
        $stmt->close();
        $conn->close(); // Closing the database connection
    }
}
?>