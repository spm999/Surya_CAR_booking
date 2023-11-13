<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the connection file
    require 'connection.php';
    $conn = Connect();

    // Retrieve data from the registration form
    $customer_username = $_POST["customer_username"];
    $customer_mobile = $_POST["customer_mobile"];
    $customer_address = $_POST["customer_address"];
    $customer_password = $_POST["customer_password"];
    $customer_email = $_POST["customer_email"];

    // Check if the username is already in use
    $check_username_query = "SELECT customer_username FROM customers WHERE customer_username = ?";
    $check_stmt = $conn->prepare($check_username_query);
    $check_stmt->bind_param("s", $customer_username);
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
    $insert_query = "INSERT INTO customers (customer_username, customer_mobile, customer_address, customer_password, customer_email)
                    VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("sssss", $customer_username, $customer_mobile, $customer_address, $customer_password, $customer_email);

    if ($insert_stmt->execute()) {
        // Registration successful
        header("Location: customer_reg_success.php");
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
    header("Location: customer_registration.php");
}
?>
