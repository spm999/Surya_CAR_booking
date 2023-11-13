<?php 
session_start(); 
require 'connection.php';
$conn = Connect();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Agency Registration</title>
    <link rel="stylesheet" href="css/agency_registration.css">
    <script>
        function validateForm() {
            var name = document.forms["registrationForm"]["agency_username"].value;
            var mobile = document.forms["registrationForm"]["agency_mobile"].value;
            var address = document.forms["registrationForm"]["agency_address"].value;
            var password = document.forms["registrationForm"]["agency_password"].value;
            var email = document.forms["registrationForm"]["agency_email"].value;

            // Mobile number validation (10 digits)
            if (mobile === "" || isNaN(mobile) || mobile.length !== 10) {
                alert("Mobile number must be a 10-digit numeric value");
                return false;
            }

            // Password validation (strong password)
            var passwordPattern = /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[@#$%^&+=]).{8,}$/;
            if (password === "" || !password.match(passwordPattern)) {
                alert("Password must be at least 8 characters long and include a combination of letters, numbers, and special characters (@#$%^&+=)");
                return false;
            }

            // Email validation (basic format)
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            if (email === "" || !email.match(emailPattern)) {
                alert("Please enter a valid email address");
                return false;
            }

            if (name === "") {
                alert("Name must be filled out");
                return false;
            }
            if (address === "") {
                alert("Address must be filled out");
                return false;
            }
        }
    </script>
</head>
<body>

<header>
        <h1 style="color:white">Surya Car Booking</h1>
        <p style="color:white">"Your trusted destination for hassle-free car rentals. Discover our diverse fleet and hit the road with confidence."</p>
    </header>

<?php
    if (isset($_SESSION['login_agency'])) {
    ?>
        <nav>
            <ul>
                <li><a class="nav-bar" href="index.php">Home</a></li>
                <li><a class="nav-bar"  href="#">Welcome <?php echo $_SESSION['login_agency']; ?></a></li>
                <li>
                    <ul>
                        <li><a class="nav-bar"  href="addcar.php">Add Car</a></li>
                        <li><a class="nav-bar"  href="agencyview.php">View Booked Cars</a></li>
                    </ul>
                </li>
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
                <li>
                    <ul>
                        <li><a class="nav-bar"  href="prereturncar.php">Return Now</a></li>
                        <li><a class="nav-bar"  href="mybookings.php"> My Bookings</a></li>
                    </ul>
                </li>
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


    <h1>Agency Registration</h1>
<form class="form" name="registrationForm" action="process_registration_agency.php" onsubmit="return validateForm()" method="post">
    <label for="agency_username">Username:</label>
    <input type="text" name="agency_username" id="agency_username" required><br><br>
    <label for="agency_mobile">Mobile Number (10 digits):</label>
    <input type="text" name="agency_mobile" id="agency_mobile" required><br><br>
    <label for="agency_address">Address:</label>
    <input type="text" name="agency_address" id="agency_address" required><br><br>
    <label for="agency_password">Password (at least 8 characters, letters, numbers, and special characters):</label>
    <input type="password" name="agency_password" id="agency_password" required><br><br>
    <label for="agency_email">Email (e.g., example@example.com):</label>
    <input type="email" name="agency_email" id="agency_email" required><br><br>
    <input type="submit" value="Sign Up">
</form>
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
