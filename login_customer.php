<?php
session_start(); // Starting Session
$error = ''; // Variable To Store Error Message

if (isset($_POST['submit'])) {
    if (empty($_POST['customer_username']) || empty($_POST['customer_password'])) {
        $error = "Username or Password is invalid";
    } else {
        // Define $username and $password
        $customer_username = $_POST['customer_username'];
        $customer_password = $_POST['customer_password'];
        
        // Establish a connection to the database
        require 'connection.php';
        $conn = Connect();

        // SQL query to fetch information of registered agencies and find a user match.
        $query = "SELECT customer_username FROM customers WHERE customer_username=? AND customer_password=? LIMIT 1";

        // To protect against SQL injection, use prepared statements
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $customer_username, $customer_password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $_SESSION['login_customer'] = $customer_username; // Initialize Session
            header("location: index.php"); // Redirect to the Index Page
        } else {
            $error = "Username or Password is invalid";
        }
        $stmt->close();
        $conn->close(); // Closing the database connection
    }
}
?>