<?php
include('session_agency.php');


function GetImageExtension($imagetype) {
    if (empty($imagetype)) return false;

    switch ($imagetype) {
        case 'image/bmp': return '.bmp';
        case 'image/gif': return '.gif';
        case 'image/jpeg': return '.jpg';
        case 'image/png': return '.png';
        default: return false;
    }
}



$car_model = $conn->real_escape_string($_POST['car_model']);
$car_number = $conn->real_escape_string($_POST['car_number']);
$seating_cap = $conn->real_escape_string($_POST['seating_capacity']);
$rent_per_day = $conn->real_escape_string($_POST['rent_per_day']);
$car_availability = "yes"; // Set car availability to "yes"

$check_query = "SELECT car_number FROM cars WHERE car_number = '$car_number'";
$result = $conn->query($check_query);
if ($result->num_rows > 0) {
    header('Location: addcar.php?success=Car with this car number already exists. Please add a different car number.');
    exit;
}
else{

if (!empty($_FILES["car_image"]["name"])) {
    $file_name = $_FILES["car_image"]["name"];
    $temp_name = $_FILES["car_image"]["tmp_name"];
    $imgtype = $_FILES["car_image"]["type"];
    $ext = GetImageExtension($imgtype);
    $imagename = $file_name;
    $target_path = "uploads/" . $imagename;

    if (move_uploaded_file($temp_name, $target_path)) {
        $query = "INSERT INTO cars (car_model, car_number,seating_cap, rent_per_day,  car_img, car_available) 
                  VALUES ('$car_model', '$car_number',  '$seating_cap','$rent_per_day', '$target_path', '$car_availability')";
        $success = $conn->query($query);

        if ($success) {
            // Retrieve the car_id from the newly inserted car
            $car_id = $conn->insert_id;

            // Insert data into agencycars table
            $agency_username = $_SESSION['login_agency'];
            $query2 = "INSERT INTO agencycar (car_id, agency_username) VALUES ('$car_id', '$agency_username')";
            $success2 = $conn->query($query2);
        }
    }
}

}



if (isset($success) && $success) {
    ?>
    <div class="message_container">
        <div class="jumbotron" style="text-align: center;">
car Added successfully
            <?php echo $conn->error; ?>
            <br><br>
            <a href="addcar.php" class="btn btn-default"> Go Back </a>
        </div>
    </div>
    <?php
    exit;
}

$conn->close();
?>
