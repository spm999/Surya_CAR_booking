<?php 
session_start(); 
require 'connection.php';
$conn = Connect();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Customer Registration Success</title>
</head>
<body>
    <h1>Registration Successful</h1>
    <p>Your registration was successful. You can now log in using your credentials.</p>

    <button onclick="location.href='customer_login.php'">Customer Login</button>
</body>
</html>
