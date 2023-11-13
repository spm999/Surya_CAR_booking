<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Cars</title>
    <link rel="stylesheet" href="css/agencyview.css">

</head>
<body>
<header>
        <h1>Surya Car Booking</h1>
        <p>"Your trusted destination for hassle-free car rentals. Discover our diverse fleet and hit the road with confidence."</p>
    </header>

<?php 
include('session_agency.php'); 

// Check if an agency is not logged in, redirect to a login page
if (!isset($_SESSION['login_agency'])) {
    header("Location: agency_login.php");
    exit();
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
        <div class="">
            <ul>
                <li><a class="nav-bar"  href="index.php">Home</a></li>
                <li><a class="nav-bar"  href="#">Welcome <?php echo $_SESSION['login_customer']; ?></a></li>

                        <li><a class="nav-bar"  href="prereturncar.php">Return Now</a></li>
                        <li><a class="nav-bar"  href="mybookings.php"> My Bookings</a></li>

                <li><a class="nav-bar"  href="about.php">About US</a></li>
                <li><a class="nav-bar"  href="logout.php">Logout</a></li>


            </ul>
        </div>
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
// Assuming you have already connected to your database

// Start the session

// Assuming you have a user session variable for the agency_username
$agencyUsername = $_SESSION['login_agency'];

// Your SQL query to retrieve booked cars with return_status 'R' and details from the 'cars' table
$sql = "SELECT agencycar.car_id, cars.car_number, cars.car_model, rentedcar.start_date,rentedcar.customer_username, rentedcar.end_date
        FROM agencycar
        INNER JOIN rentedcar ON agencycar.car_id = rentedcar.car_id
        INNER JOIN cars ON agencycar.car_id = cars.car_id
        WHERE agencycar.agency_username = '$agencyUsername' AND rentedcar.return_status = 'NR'";

// Execute the query
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Display the booked cars
    echo "<h2>Currently Booked Cars </h2>";
    echo "<table border='1'>
            <tr>
                <th>Customer Name</th>
                <th>Car Number</th>
                <th>Car Model</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['customer_username']}</td>
                <td>{$row['car_number']}</td>
                <td>{$row['car_model']}</td>
                <td>{$row['start_date']}</td>
                <td>{$row['end_date']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    // Handle the case when the query fails
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>


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

</body>
</html>
