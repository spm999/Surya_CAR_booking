<?php
include('session_agency.php');

// Check if an agency is not logged in, redirect to a login page
if (!isset($_SESSION['login_agency'])) {
    header("Location: agency_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Surya Car Booking</title>
    <link rel="stylesheet" href="css/addcar.css">
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
        <h3 style="text-align:center;">Add New Car</h3>
        <form action="addcar_process1.php" method="post" enctype="multipart/form-data">
            <label for="car_model">Car Model:</label>
            <input type="text" name="car_model" required><br>

            <label for="car_number">Car Number:</label>
            <input type="text" name="car_number" required><br>

            <label for="seating_capacity">Seating Capacity:</label>
            <input type="number" name="seating_capacity" required><br>

            <label for="rent_per_day">Rent per Day (in INR):</label>
            <input type="number" name="rent_per_day" required><br>

            <label for="car_image">Car Image:</label>
            <input type="file" name="car_image" accept="image/*" required><br>

            <input type="submit" value="Add Car">
        </form>

        <?php
        if (isset($_GET['success'])) {
            echo '<p style="color: green;">' . htmlspecialchars($_GET['success']) . '</p>';
        }
        ?>

    </section>



    <section>
        <form method="POST">
            <br style="clear: both">
            <h3 style="margin-bottom: 25px; text-align: center; font-size: 30px;"> My Cars </h3>
            <?php
            // Storing Session
            $user_check = $_SESSION['login_agency'];
            $sql = "SELECT * FROM cars WHERE car_id IN (SELECT car_id FROM agencycar WHERE agency_username='$user_check');";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {

            } else {
                ?>
                <h4>
                    <center>0 Cars available</center>
                </h4>
                <?php
            }
            ?>


            <!-- Display your cars in a table -->
            <table>
                <thead>
                    <tr>
                        <th>Car Model</th>
                        <th>Car Number</th>
                        <th>Seating Capacity</th>
                        <th>Rent per Day</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch and display cars from the database
                    $sql_fetch_cars = "SELECT * FROM cars WHERE car_id IN (SELECT car_id FROM agencycar WHERE agency_username='$user_check');";
                    $result_fetch_cars = $conn->query($sql_fetch_cars);




                    while ($row = $result_fetch_cars->fetch_assoc()) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row['car_model']; ?>
                            </td>
                            <td>
                                <?php echo $row['car_number']; ?>
                            </td>
                            <td>
                                <?php echo $row['seating_cap']; ?>
                            </td>
                            <td>
                                <?php echo $row['rent_per_day']; ?>
                            </td>
                            <?php
                            // Your PHP code here, such as handling form submissions
                        
                            if (isset($_POST['edit_button'])) {
                                // Assuming car_id is a variable containing the car ID value
                                $car_id = $_POST['car_id']; // Adjust this line based on how your car_id is obtained
                        
                                // Redirect to another page with car_id as a query parameter
                                header("Location: edit_car.php?car_id=" . urlencode($car_id));
                                exit(); // Make sure to exit after the header to prevent further execution
                            }
                            ?>
                            <td>
                                <form style="padding:0px;" method="post" action="">
                                    <input type="hidden" name="car_id" value="<?php echo $row['car_id']; ?>">
                                    <button class="edit" name="edit_button" type="submit">Edit</button>
                                </form>

                                <form method="post" action="addcar.php" style="padding:0px;">
                                    <input type="hidden" name="car_id" value="<?php echo $row['car_id']; ?>">
                                    <button type="submit" class="edit" name="delete">Delete</button>
                                </form>

                            </td>

                        </tr>
                    <?php }



                    ?>
                </tbody>
            </table>

            <?php
            // Handle delete action
            if (isset($_POST['delete'])) {
                $id = $_POST['car_id'];
                $sql_del = "DELETE FROM cars WHERE car_id = $id";
                $result = mysqli_query($conn, $sql_del);

                $sql_del1 = "DELETE FROM agencycar where car_id=$id";
                $result2 = mysqli_query($conn, $sql_del1);


                if ($result && $result2) {
                    echo '<script>window.location = "addcar.php?success=Car deleted successfully";</script>';
                    exit();
                } else {
                    // Handle error, if needed
                    echo 'Error deleting car';
                }
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