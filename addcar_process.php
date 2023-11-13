<?php
include('session_agency.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form was submitted

    // Retrieve form data
    $car_model = $_POST['car_model'];
    $car_number = $_POST['car_number'];
    $seating_capacity = $_POST['seating_capacity'];
    $rent_per_day = $_POST['rent_per_day'];

    // Check if the car number already exists in the database
    $check_query = "SELECT car_number FROM cars WHERE car_number = '$car_number'";
    $result = $conn->query($check_query);
    if ($result->num_rows > 0) {
        header('Location: addcar.php?success=Car with this car number already exists. Please add a different car number.');
        exit;
        // echo "Car with this car number already exists. Please add a different car number.";
    } else {
        // Handle image upload
        $target_directory = 'uploads/'; // Create a directory for uploaded images
        $target_file = $target_directory . basename($_FILES['car_image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        if (getimagesize($_FILES['car_image']['tmp_name']) !== false) {
            if ($imageFileType == 'jpg' || $imageFileType == 'jpeg' || $imageFileType == 'png') {
                if (move_uploaded_file($_FILES['car_image']['tmp_name'], $target_file)) {
                    // The image has been uploaded successfully
                    // Now you can insert the data into the database
                    $query = "INSERT INTO cars (car_model, car_number, seating_cap, rent_per_day, car_img) VALUES ('$car_model', '$car_number', $seating_capacity, $rent_per_day, '$target_file')";
                    // if ($conn->query($query) === TRUE) {
                    //     echo "Car added successfully!";
                    // } else {
                    //     echo "Error: " . $query . "<br>" . $conn->error;
                    // }
                    if ($conn->query($query) === TRUE) {
                        // Car added successfully, redirect to addcars.php with success message
                        header('Location: addcar.php?success=Car added successfully!');
                        exit;
                    } else {
                        echo "Error: " . $query . "<br>" . $conn->error;
                    }
                    
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    // Close the database connection
    $conn->close();
}
?>
