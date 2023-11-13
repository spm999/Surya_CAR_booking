<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the connection file
    require 'connection.php';
    $conn = Connect();
// 

    // Retrieve data from the registration form
    $agency_username = $_POST["agency_username"];
    $agency_mobile = $_POST["agency_mobile"];
    $agency_address = $_POST["agency_address"];
    $agency_password = $_POST["agency_password"];
    $agency_email = $_POST["agency_email"];

    // Check if the username is already in use
    $check_username_query = "SELECT agency_username FROM agency WHERE agency_username = ?";
    $check_stmt = $conn->prepare($check_username_query);
    $check_stmt->bind_param("s", $agency_username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Username is already in use
        echo "Username is already in use. Please choose a different username.";
        $check_stmt->close();
        $conn->close();
        exit();
    }

    // Insert data into the "agency" table
    $insert_query = "INSERT INTO agency (agency_username, agency_mobile, agency_address, agency_password, agency_email)
                    VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("sssss", $agency_username, $agency_mobile, $agency_address, $agency_password, $agency_email);

    if ($insert_stmt->execute()) {
        // Registration successful
        header("Location: agency_reg_success.php");
        exit(); // Terminate the script to ensure the redirect takes effect
    } else {
        // Registration failed
        echo "Registration failed. Please try again.";
    }

    // Close the database connection
    $insert_stmt->close();
    $conn->close();
} else {
    // Redirect to the registration page if accessed directly
    header("Location: agency_registration.php");
}
?>
