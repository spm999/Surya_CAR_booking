<?php
session_start();
require 'connection.php';
$conn = Connect();
?>

<!DOCTYPE html>
<html>

<head>
    <title>About Our Company</title>
    <link rel="stylesheet" href="css/about.css">
</head>

<body>

    <header class="header">
        <h1 style="color:white;">Surya Car Booking</h1>
        <p style="color:white;">"Your trusted destination for hassle-free car rentals. Discover our diverse fleet and
            hit the road with confidence."</p>
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
                        </a>
                    </li>

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

    <h1>About Our Company</h1>




    <section>
        <h2 style="text-align:center;">Who We Are</h2>
        <p>
            Welcome to Surya Car Booking, your trusted source for car rental services. </p>
         <p>   We have been providing quality car rental solutions for years, ensuring</p>
           <p> a seamless and enjoyable travel experience for our customers.
        </p>
    </section>

    <section>
        <h2 style="text-align:center;" >Our Mission</h2>
        <p>
            Our mission is to provide reliable and affordable car rental services to our customers. </p>
         <p>   We strive to make your journeys comfortable, whether you're traveling for business or pleasure.
        </p>
    </section>

    <section>
        <h2 style="text-align:center;" >Testimonials</h2>
        <div class="testimonial">
            <br>
            <br>
<h4 style="text-align:center;" >Akash</h4>
        <p>"I had a great experience with Surya Car Bookings. The car was in excellent condition, and the staff was very
                helpful!"</p>
        </div>
        <div class="testimonial">
        <br>
            <br>
        <h4 style="text-align:center;" >Anant</h4>          
          <p>"Surya Car Booking made my trip hassle-free. I highly recommend their services!"</p>
        </div>
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