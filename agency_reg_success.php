<?php 
session_start(); 
require 'connection.php';
$conn = Connect();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Agency Registration Success</title>
</head>
<body>
    <h1>Registration Successful</h1>
    <p>Your agency registration was successful. You can now log in using your credentials.</p>

    <button onclick="location.href='agency_login.php'">Agency Login</button>
</body>
</html>
