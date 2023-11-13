<!DOCTYPE html>
<html>
<?php 
session_start();
require 'connection.php';
$conn = Connect();
?>


<head>
<link rel="stylesheet" href="css/car_returned.css">
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
<header>
        <h1>Surya Car Booking</h1>
        <p>"Your trusted destination for hassle-free car rentals. Discover our diverse fleet and hit the road with confidence."</p>
    </header>
<?php
    if (isset($_SESSION['login_agency'])) {
    ?>
        <nav>
            <ul>
                <li><a class="nav-bar" href="index.php">Home</a></li>
                <li><a class="nav-bar"  href="#">Welcome <?php echo $_SESSION['login_agency']; ?></a></li>

                        <li><a class="nav-bar"  href="addcar.php">Add Car</a></li>
                        <li><a class="nav-bar"  href="agencyview.php">View Booked Cars</a></li>

                <li><a class="nav-bar"  href="about.php">About US</a></li>
                <li><a class="nav-bar"  href="logout.php">Logout</a></li>
            </ul>
        </nav>
    <?php
    } else if (isset($_SESSION['login_customer'])) {
    ?>
<nav>
                <ul>
                <li><a class="nav-bar"  href="index.php">Home</a></li>
                <li><a class="nav-bar"  href="#">Welcome <?php echo $_SESSION['login_customer']; ?></a></li>

                        <li><a class="nav-bar"  href="prereturncar.php">Return Now</a></li>
                        <li><a class="nav-bar"  href="mybookings.php"> My Bookings</a></li>

                <li><a class="nav-bar"  href="about.php">About US</a></li>
                <li><a class="nav-bar"  href="logout.php">Logout</a></li>


            </ul>
    </nav>
    <?php
    } else {
    ?>
        <nav>
            <ul>
                <li><a class="nav-bar"  href="index.php">Home</a></li>
                <li><a class="nav-bar"  href="agency_login.php">Agency Login</a></li>
                <li><a class="nav-bar"  href="customer_login.php">Customer Login</a></li>
                <li><a class="nav-bar"  href="about.php">About US</a></li>
            </ul>
        </nav>
    <?php
    }
    ?>

<?php 

$id = $_GET["id"];
$start_date=$_GET["start_date"];
$end_date=$_GET["end_date"];

//var_dump($_GET);  // Add this line to print the contents of the $_GET array


$sql = "SELECT no_of_days, rent_per_day FROM rentedcar WHERE car_id = '$id' and start_date='$start_date' and end_date='$end_date'";

$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Check if the row is not empty
    if ($row) {
        // Retrieve values
        $no_of_days = $row['no_of_days'];
        $rent_per_day = $row['rent_per_day'];

        // Output or use the retrieved values as needed
    }
} else {
    echo "Error in the SQL query: " . $conn->error;
}


$sql9 = "SELECT car_model, car_number FROM cars WHERE car_id = '$id'";

$result = $conn->query($sql9);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    if ($row) {
        // Retrieve values
        $car_model = $row['car_model'];
        $car_number = $row['car_number'];
    }
} else {
    echo "Error in the SQL query: " . $conn->error;
}



$total_amount = $no_of_days * $rent_per_day;
$return_status = "R";
$login_customer = $_SESSION['login_customer'];


function dateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

$car_return_date=date('Y-m-d');
$extra_days = dateDiff($end_date, $car_return_date);
$total_fine = $extra_days * 200;

$duration = dateDiff($start_date, $end_date);

if ($extra_days > 0 && $total_fine>0) {
    $total_amount = $total_amount + $total_fine;
}




$sql1 = "UPDATE rentedcar SET car_return_date='$car_return_date', no_of_days='$no_of_days', total_amount='$total_amount', return_status='$return_status' WHERE car_id = '$id' and start_date='$start_date' and end_date='$end_date'";

$result1 = $conn->query($sql1);

// if ($result1) {
//     echo "Rentedcar table updated successfully<br>";
// } else {
//     echo "Error updating rentedcar table: " . $conn->error . "<br>";
// }

$sql2 = "UPDATE cars c, rentedcar rc SET c.car_available='yes' WHERE rc.car_id=c.car_id AND rc.customer_username = '$login_customer' AND rc.car_id = '$id'";
$result2 = $conn->query($sql2);


?>
<?php
$login_customer = $_SESSION['login_customer'];

// Update return_status to 'R' in rentedcar table
$sql_update_rentedcar = "UPDATE rentedcar rc
                         JOIN cars c ON rc.car_id = c.car_id
                         SET rc.return_status = 'R',
                         rc.car_return_date='$car_return_date', rc.total_amount='$total_amount'
                         WHERE rc.customer_username = '$login_customer'AND rc.start_date='$start_date' AND rc.end_date='$end_date' AND c.car_available = 'yes'";

$result_update_rentedcar = $conn->query($sql_update_rentedcar);

?>

    <div class="main-container">
            <h1 style="color: green; text-align:center; padding:10px;">Car Returned</h1>
    </div>
    <br>

    <h2 style="text-align:center;"> Thank you for visiting Surya Car Booking! We wish you have a safe ride. </h2>
    <h3 style="text-align:center;"> Please print bill before refresh page. </h3>

    <div class="container">
        <div style="text-align:center;">
                <h3 style="color: orange; text-align:center">Your Bill</h3>
                <br>
                <h4> <strong>Vehicle Name: </strong> <?php echo $car_model;?></h4>
                <br>
                <h4> <strong>Vehicle Number:</strong> <?php echo $car_number; ?></h4>
                <br>
                <h4> <strong>Booking Date: </strong> <?php echo date("Y-m-d"); ?> </h4>
                <br>
                <h4> <strong>Start Date: </strong> <?php echo $start_date; ?></h4>
                <br>
                <h4> <strong>Rent End Date: </strong> <?php echo $end_date; ?></h4>
                <br>
                <h4> <strong>Car Return Date: </strong> <?php echo $car_return_date; ?> </h4>
                <br>
                    <h4> <strong>Number of days:</strong> <?php echo $no_of_days; ?>day(s)</h4>
                <br>
                <?php
                    if($extra_days > 0){ 
                ?>
                <h4> <strong>Total Fine:</strong> <label class="text-danger"> Rs. <?php echo $total_fine; ?>/- </label> for <?php echo $extra_days;?> extra days.</h4>
                <br>
                <?php } ?>
                <h4> <strong>Total Amount: </strong> Rs. <?php echo $total_amount; ?>/-   </h4>
                <br>

            </div>
                <a href="javascript:window.print()" class="print-btn">Print Invoice</a>
    </div>

<?php


// $sql = "DELETE FROM rentedcar WHERE car_id = '$id'";

// $result = $conn->query($sql);

// header("Refresh: 5; URL=index.php");

?>

<!-- <script>
    if (performance.navigation.type === 1) {
        // User manually refreshed the page
        window.location.href = "index.php";
    }
</script> -->


</body>
<footer>

    <div>
        <ul>
            <li><a class="footer" href="contact.php">Contact Us</a></li>
            <li><a class="footer" href="blog.php">Blog</a></li>
        </ul>
    </div>
    <div>
        <ul class="social-media">
            <li><a href="https://www.facebook.com/YourCarRentals"><i class="fab fa-facebook"></i></a></li>
            <li><a href="https://twitter.com/YourCarRentals"><i class="fab fa-twitter"></i></a></li>
            <li><a href="https://www.instagram.com/YourCarRentals"><i class="fab fa-instagram"></i></a></li>
        </ul>
    </div>
    <div>
    <p class="footer" >&copy; <?php echo date("Y"); ?> Surya Car Booking</p>
    </div>
</footer>
</html>