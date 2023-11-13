<!DOCTYPE html>
<html>
<?php
session_start();
require 'connection.php';
$conn = Connect();
?>

<head>
    <title>Return Car</title>
    <link rel="stylesheet" href="css/returncar.css">
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
                    </a>
                </li>

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


    function dateDiff($start, $end)
    {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }

    $id = $_GET["id"];
    $sql1 = "SELECT c.car_model, c.car_number, rc.start_date, rc.end_date
    FROM rentedcar rc
    JOIN cars c ON c.car_id = rc.car_id
    WHERE rc.car_id = '$id'";

    $result1 = $conn->query($sql1);
    if (mysqli_num_rows($result1) > 0) {
        while ($row = mysqli_fetch_assoc($result1)) {
            $car_name = $row["car_model"];
            $car_nameplate = $row["car_number"];
            $rent_start_date = $row["start_date"];
            $rent_end_date = $row["end_date"];
            $no_of_days = dateDiff("$rent_start_date", "$rent_end_date");
        }
    }
    ?>
    <div class="form-area">
        <form
            action="car_returned.php?id=<?php echo $id ?>&start_date=<?php echo $rent_start_date ?>&end_date=<?php echo $rent_end_date ?>"
            method="POST">

            <h3 style="margin-bottom: 5px; text-align: center; font-size: 30px;"> Journey Details </h3>

            <h5> Car:&nbsp;
                <?php echo ($car_name); ?>
            </h5>

            <h5> Vehicle Number:&nbsp;
                <?php echo ($car_nameplate); ?>
            </h5>

            <h5> Rent Start Date:&nbsp;
                <?php echo ($rent_start_date); ?>
            </h5>

            <h5> Rent End Date:&nbsp;
                <?php echo ($rent_end_date); ?>
            </h5>


            <?php ?>
            <h5> Number of Day(s):&nbsp;
                <?php echo ($no_of_days); ?>
            </h5>
            <input type="hidden" name="distance_or_days" value="<?php echo $no_of_days; ?>">
            <?php ?>

            <input type="submit" name="submit" value="Submit">
        </form>
    </div>

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
        <p class="footer">&copy;
            <?php echo date("Y"); ?> Surya Car Booking
        </p>
    </div>
</footer>

</html>