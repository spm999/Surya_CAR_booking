<?php
include('session_agency.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $car_id = $_POST['car_id'];
    $car_model = $_POST['car_model'];
    $car_number = $_POST['car_number'];
    $seating_capacity = $_POST['seating_capacity'];
    $rent_per_day = $_POST['rent_per_day'];
    $car_img = $_FILES['car_image']['name'];

    // Check if the new car number is already present in the cars table
    $sql_check_duplicate = "SELECT car_id FROM cars WHERE car_number = '$car_number' AND car_id != $car_id";
    $result_check_duplicate = $conn->query($sql_check_duplicate);

    if ($result_check_duplicate->num_rows > 0) {
        // Display JavaScript alert
        echo '<script>alert("Car number already exists");</script>';
        
        // Redirect to the edit_car.php page with an error message
        echo '<script>window.location.href = "edit_car.php?car_id=' . $car_id . '&error=Car number already exists";</script>';
        exit();
    }

    $sql_update_car = "UPDATE cars SET
                        car_model = '$car_model',
                        car_number = '$car_number',
                        seating_cap = '$seating_capacity',
                        rent_per_day = '$rent_per_day',
                        car_img = CONCAT('uploads/', '$car_img')  -- Concatenate 'uploads/' here
                        WHERE car_id = $car_id";

    if ($conn->query($sql_update_car) === TRUE) {
        // Move uploaded file to desired directory
        move_uploaded_file($_FILES['car_image']['tmp_name'], 'uploads/' . $car_img);

        // Display JavaScript alert
        echo '<script>alert("Car is Updated!!!");</script>';
        
        // Redirect to the edit_car.php page with a success message
        // header("Location: edit_car.php?car_id=" . $car_id . "&success=Car updated successfully");
        echo '<script>window.location.href = "edit_car.php?car_id=' . $car_id . '&success=Car updated successfully";</script>';

        exit();
    } else {
        // Display JavaScript alert
        echo '<script>alert("Error updating car");</script>';

        // Redirect to the edit_car.php page with an error message
        echo '<script>window.location.href = "edit_car.php?car_id=' . $car_id . '&error=Error updating car";</script>';
        exit();
    }
} else {
    // Redirect to an error page if the form is not submitted using POST method
    echo '<script>window.location.href = "some_error_page.php";</script>';
    exit();
}
?>
