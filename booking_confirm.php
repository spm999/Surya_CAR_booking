<!DOCTYPE html>
<html>
<?php
include('session_customer.php');
if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: customer_login.php");
}
?>

<?php

// Retrieve the car number from the session
$car_number = isset($_SESSION['car_number']) ? $_SESSION['car_number'] : 'Not booked yet';

// Display the booked car number
// echo "Booked Car Number: " . $bookedCarNumber;
?>

<title>Book Car </title>
<link rel="stylesheet" href="css/booking_confirm.css">

<head>

</head>

<body>
<header>
        <h1>Surya Car Booking</h1>
        <p>"Your trusted destination for hassle-free car rentals. Discover our diverse fleet and hit the road with confidence."</p>
    </header>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        $no_of_days = $conn->real_escape_string($_POST['no_of_days']);
        $rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date']));
        $no_of_days = intval($_POST['no_of_days']);
        $rent_end_date = date('Y-m-d', strtotime($rent_start_date . ' + ' . $no_of_days . ' days'));
        $return_status = "NR"; // not returned

        $customer_username = $_SESSION['login_customer'];
        function dateDiff($start, $end)
        {
            $start_ts = strtotime($start);
            $end_ts = strtotime($end);
            $diff = $end_ts - $start_ts;
            return round($diff / 86400);
        }

        $err_date = dateDiff("$rent_start_date", "$rent_end_date");

        $sql0 = "SELECT * FROM cars WHERE car_number = '$car_number'";
        // echo $car_number;
        $result0 = $conn->query($sql0);

        if ($err_date >= 0) {
            $sql0 = "SELECT * FROM cars WHERE  car_number = '$car_number'";
            $result0 = $conn->query($sql0);
            $row = $result0->fetch_assoc();
            $rent_per_day = $row['rent_per_day'];
            $car_id = $row['car_id'];
            $car_model = $row['car_model'];


            $sql1 = "INSERT into rentedcar(customer_username, car_id, no_of_days, start_date, end_date, rent_per_day, return_status) 
                 VALUES('" . $customer_username . "','" . $car_id . "','" . $no_of_days . "','" . $rent_start_date . "','" . $rent_end_date . "','" . $rent_per_day . "','" . $return_status . "')";
            $result1 = $conn->query($sql1);

            $sql2 = "UPDATE cars SET car_available = 'no' WHERE  car_number = '$car_number'";
            $result2 = $conn->query($sql2);

        }
    }
    ?>

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
    <div class="container">
            <h1 style="color: green; text-align:center;">Booking Confirmed.</h1>
    </div>
    <br>

    <h2 style="text-align:center;"> Thank you for using Surya car Booking. We wish you have a safe ride. </h2>

    <div class="container">
        <h5 style="text-align:center;">Please read the following information about your order.</h5>

        <div class="box">
            <div  style="float: none; margin: 0 auto; text-align: center;">
                <br>
                <h3 style="color: orange;">Invoice</h3>
                <br>
            </div>

            <div style=" text-align:center;">
                <input type="hidden" name="hidden_carid" value="your_car_id_value_here">

                <h4> <strong>Car Model: </strong>
                    <?php echo $car_model; ?>
                </h4>
                <br>

                <h4> <strong>Car Number:</strong>
                    <?php echo $car_number; ?>
                </h4>
                <br>

                <h4> <strong>Booking Date: </strong>
                    <?php echo date("Y-m-d"); ?>
                </h4>
                <br>

                <h4> <strong>Start Date: </strong>
                    <?php echo $rent_start_date; ?>
                </h4>
                <br>

                <h4> <strong>Return Date: </strong>
                    <?php echo $rent_end_date; ?>
                </h4>
                <br>

            </div>
            <a href="javascript:window.print()" class="print-btn">Print Invoice</a>

        </div>

    </div>
</body>
<?php {
?>

    <?php } ?>
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