<?php
session_start(); // Starting Session

if (isset($_SESSION['login_customer'])) {
    header("location: index.php"); // Redirecting to the dashboard if already logged in
    exit; // Ensure the script stops here
}

require 'connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_username = $_POST['customer_username'];
    $customer_password = $_POST['customer_password'];

    $conn = Connect(); // Establish database connection

    // Prepare a SQL query (replace 'your_table' with the actual table name)
    $query = "SELECT * FROM customers WHERE customer_username = ? AND customer_password = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $customer_username, $customer_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Valid login, set the session
        $_SESSION['login_customer'] = $customer_username;
        $stmt->close();
        $conn->close();
        header("location: index.php"); // Redirect after a successful login
        exit;
    } else {
        // Invalid login, show an error message
        $error_message = "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Customer Login</title>
    <link rel="stylesheet" href="css/customer_login.css">
</head>

<body>
    <header>
        <h1 style="color:white;" >Surya Car Booking</h1>
        <p style="color:white;" >"Your trusted destination for hassle-free car rentals. Discover our diverse fleet and hit the road with
            confidence."</p>
    </header>


    <?php
    if (isset($_SESSION['login_agency'])) {
        ?>
        <nav>
            <ul>
                <li><a class="nav-bar" href="index.php">Home</a></li>
                <li>
                    <a class="nav-bar" href="#">Welcome
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
            <div>
                <ul>
                    <li><a class="nav-bar" href="index.php">Home</a></li>
                    <li><a class="nav-bar" href="#">Welcome
                        <?php echo $_SESSION['login_customer']; ?>
                        </a></li>

                    <li><a class="nav-bar" href="prereturncar.php">Return Now</a></li>
                    <li><a class="nav-bar" href="mybookings.php"> My Bookings</a></li>
                    <li><a class="nav-bar" href="logout.php">Logout</a></li>
                </ul>
            </div>
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
    <h1>Customer Login</h1>


    <form method="post">
        <label for="customer_username">Username:</label>
        <input type="text" name="customer_username" id="customer_username" required><br>
        <label for="customer_password">Password:</label>
        <input type="password" name="customer_password" id="customer_password" required><br>
        <input type="submit" value="Login">
        <p>Don't have an account? <span><a href="customer_registration.php">Sign Up</a></span></p>

        <?php
        if (isset($error_message) && !empty($error_message)) {
            echo '<p class="error">' . $error_message . '</p>';
            $error_message = ""; // Clear the error message
        }
        ?>

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
            <p class="footer">&copy;
                <?php echo date("Y"); ?> Surya Car Booking
            </p>
        </div>
    </footer>

</body>

</html>