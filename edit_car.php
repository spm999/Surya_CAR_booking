<?php
// edit_car.php

include('session_agency.php');

// Check if an agency is not logged in, redirect to a login page
if (!isset($_SESSION['login_agency'])) {
    header("Location: agency_login.php");
    exit();
}

// Check if car_id is provided in the URL
if (!isset($_GET['car_id'])) {
    // Redirect to a page indicating that car_id is missing
    header("Location: some_error_page.php");
    exit();
}

// Retrieve car_id from the URL
$car_id = $_GET['car_id'];

// Fetch car details from the database based on car_id
$sql_fetch_car = "SELECT * FROM cars WHERE car_id = $car_id";
$result_fetch_car = $conn->query($sql_fetch_car);

if ($result_fetch_car->num_rows > 0) {
    $car_details = $result_fetch_car->fetch_assoc();
} else {
    // Redirect to a page indicating that the car with the provided car_id doesn't exist
    header("Location: some_error_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Car - Surya Car Booking</title>
    <link rel="stylesheet" href="css/editcar.css">
</head>

<body>

    <header>
        <h1 style="color:white">Surya Car Booking</h1>
        <p style="color:white">"Your trusted destination for hassle-free car rentals.
            Discover our diverse fleet and hit the road with confidence."
        </p>
    </header>

    <?php
    if (isset($_SESSION['login_agency'])) {
        ?>
        <nav>
            <ul>
                <li><a class="nav-bar" href="index.php">Home</a></li>
                <li><a class="nav-bar" href="#">Welcome
                        <?php echo $_SESSION['login_agency']; ?>
                    </a></li>

                <li><a class="nav-bar" href="addcar.php">Add Car</a></li>
                <li><a class="nav-bar" href="agencyview.php">View Booked Cars</a></li>

                <li><a class="nav-bar" href="about.php">About US</a></li>
                <li><a class="nav-bar" href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <?php
    } else if (isset($_SESSION['login_customer'])) {
        ?>
            <nav>
                <ul>
                    <li><a class="nav-bar" href="index.php">Home</a></li>
                    <li><a class="nav-bar" href="#">Welcome
                        <?php echo $_SESSION['login_customer']; ?>
                        </a></li>

                    <li><a class="nav-bar" href="prereturncar.php">Return Now</a></li>
                    <li><a class="nav-bar" href="mybookings.php"> My Bookings</a></li>

                    <li><a class="nav-bar" href="about.php">About US</a></li>
                    <li><a class="nav-bar" href="logout.php">Logout</a></li>


                </ul>
            </nav>
        <?php
    } else {
        ?>
            <nav>
                <ul>
                    <li><a class="nav-bar" href="index.php">Home</a></li>
                    <li><a class="nav-bar" href="agency_login.php">Agency Login</a></li>
                    <li><a class="nav-bar" href="customer_login.php">Customer Login</a></li>
                    <li><a class="nav-bar" href="about.php">About US</a></li>
                </ul>
            </nav>
        <?php
    }
    ?>
    <section>
        <h3 style="text-align:center;">Edit Car</h3>
        <form action="editcar_process.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
            <label for="car_model">Car Model:</label>
            <input type="text" name="car_model" value="<?php echo $car_details['car_model']; ?>" required><br>

            <label for="car_number">Car Number:</label>
            <input type="text" name="car_number" value="<?php echo $car_details['car_number']; ?>" required><br>

            <label for="seating_capacity">Seating Capacity:</label>
            <input type="number" name="seating_capacity" value="<?php echo $car_details['seating_cap']; ?>" required><br>

            <label for="rent_per_day">Rent per Day (in INR):</label>
            <input type="number" name="rent_per_day" value="<?php echo $car_details['rent_per_day']; ?>" required><br>

            <label for="car_image">Car Image:</label>
            <input type="file" name="car_image" value="<?php echo $car_details['car_img']; ?>" accept="image/*" required><br>

            <input type="submit" value="Update Car">
        </form>


    </section>

    <footer>

        <div>
            <ul>
                <li><a class="footer" href="#">Contact Us</a></li>
                <li><a class="footer" href="#">Blog</a></li>
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
            <p class="footer">&copy;
                <?php echo date("Y"); ?> Surya Car Booking
            </p>
        </div>
    </footer>

</body>

</html>
