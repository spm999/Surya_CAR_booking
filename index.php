<?php
session_start();
require 'connection.php';
$conn = Connect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Surya Car Booking</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <header>
        <h1>Surya Car Booking</h1>
        <p>"Your trusted destination for hassle-free car rentals. Discover our diverse fleet and hit the road with
            confidence."</p>
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

    <section class="menu-content">
        <?php
        $sql1 = "SELECT * FROM cars WHERE car_available='yes'";
        $result1 = mysqli_query($conn, $sql1);

        if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
                $car_id = $row1["car_id"];
                $car_model = $row1["car_model"];
                $car_number = $row1["car_number"];
                $seating_cap = $row1["seating_cap"];
                $rent_per_day = $row1["rent_per_day"];
                $car_img = $row1["car_img"];
                ?>
                <div class="sub-menu">
                    <img src="<?php echo $car_img; ?>" alt="Car Image" width="250" height="150">
                    <h5><b>
                            <?php echo $car_model; ?>
                        </b></h5>
                    <h6>Car Number
                        <?php echo $car_number; ?>
                    </h6>
                    <h6>Seating Capacity:
                        <?php echo $seating_cap; ?>
                    </h6>
                    <h6>Rent Per Day:
                        <?php echo $rent_per_day; ?>
                    </h6>
                    <?php
                    if (isset($_SESSION['login_customer'])) {
                        ?>
                        <a href="booking.php?id=<?php echo $car_id; ?>" class="btn">Book Car</a>
                        <?php
                    } else {
                        ?>
                        <a href="customer_login.php" class="btn">Log In to Book</a>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
        } else {
            ?>
            <h1>No cars available :(</h1>
            <?php
        }
        ?>
    </section>

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
            <p class="footer">&copy;
                <?php echo date("Y"); ?> Surya Car Booking
            </p>
        </div>
    </footer>

</body>

</html>