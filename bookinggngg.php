<?php
include('session_customer.php');
if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: customer_login.php");
    exit;
}

$customer_username = $_SESSION["login_customer"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form input
    $car_id = $conn->real_escape_string($_POST['hidden_carid']);
    $no_of_days = $conn->real_escape_string($_POST['no_of_days']);
    $rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date']));
    $no_of_days = intval($_POST['no_of_days']);
    $rent_end_date = date('Y-m-d', strtotime($rent_start_date . ' + ' . $no_of_days . ' days'));
    $return_status = "NR"; // not returned

    function dateDiff($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }

    $err_date = dateDiff("$rent_start_date", "$rent_end_date");

    $sql0 = "SELECT * FROM cars WHERE car_id = '$car_id'";
    $result0 = $conn->query($sql0);

    if ($err_date >= 0) {
        $sql0 = "SELECT rent_per_day FROM cars WHERE car_id = '$car_id'";
        $result0 = $conn->query($sql0);
        $row = $result0->fetch_assoc();
        $rent_per_day = $row['rent_per_day'];

        $sql1 = "INSERT into rentedcar(customer_username, car_id, no_of_days, start_date, end_date, rent_per_day, return_status) 
                 VALUES('" . $customer_username . "','" . $car_id . "','" . $no_of_days . "','" . $rent_start_date . "','" . $rent_end_date . "','" . $rent_per_day . "','" . $return_status . "')";
        $result1 = $conn->query($sql1);

        $sql2 = "UPDATE cars SET car_available = 'no' WHERE car_id = '$car_id'";
        $result2 = $conn->query($sql2);

        // $sql4 = "SELECT c.car_model, c.car_number, cl.agency_username, cl.agency_mobile
        //          FROM cars c
        //          JOIN agency cl ON c.agency_username = cl.agency_username
        //          JOIN rentedcar rc ON c.car_id = rc.car_id
        //          WHERE c.car_id = '$car_id'";
        // $result4 = $conn->query($sql4);

        // if (mysqli_num_rows($result4) > 0) {
        //     while ($row = $result4->fetch_assoc()) {
        //         $car_model = $row["car_model"];
        //         $car_number = $row["car_number"];
        //         $agency_name = $row["agency_name"];
        //         $agency_phone = $row["agency_phone"];
        //     }
        // }

        if (!$result1 || !$result2) {
            die("Couldn't enter data: " . $conn->error);
        }
    }
}
?>
<!DOCTYPE html>



<html>
<?php 
 include('session_customer.php');
if(!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customer_login.php");
}
?> 
<title>Book Car </title>
<head>

</head>
<body > 

<?php


    $customer_username = $_SESSION["login_customer"];
    $car_id = $conn->real_escape_string($_POST['hidden_carid']);
    $no_of_days = $conn->real_escape_string($_POST['no_of_days']);
    $rent_start_date = date('Y-m-d', strtotime($_POST['rent_start_date'])); // Ensure that rent_start_date is in the correct format first
    $no_of_days = intval($_POST['no_of_days']); // Convert to an integer
    $rent_end_date = date('Y-m-d', strtotime($rent_start_date . ' + ' . $no_of_days . ' days'));
    
    // $return_status = "NR"; // not returned


    // function dateDiff($start, $end) {
    //     $start_ts = strtotime($start);
    //     $end_ts = strtotime($end);
    //     $diff = $end_ts - $start_ts;
    //     return round($diff / 86400);
    // }
    
    $err_date = dateDiff("$rent_start_date", "$rent_end_date");

    $sql0 = "SELECT * FROM cars WHERE car_id = '$car_id'";
    $result0 = $conn->query($sql0);


    if($err_date >= 0) { 
    $sql1 = "INSERT into rentedcar(customer_username,car_id,no_of_days, start_date, end_date, rent_per_day, return_status) 
    VALUES('" . $customer_username . "','" . $car_id . "','" . $no_of_days . "','" . $rent_start_date ."','" . $rent_end_date . "','" . $rent_per_day . "','" . $return_status . "')";
    $result1 = $conn->query($sql1);

    $sql2 = "UPDATE cars SET car_available = 'no' WHERE car_id = '$car_id'";
    $result2 = $conn->query($sql2);

//     $sql4 = "SELECT c.car_model, c.car_number, cl.agency_username, cl.agency_mobile
//     FROM cars c
//     JOIN agency cl ON c.agency_username = cl.agency_username
//     JOIN rentedcar rc ON c.car_id = rc.car_id
//     WHERE c.car_id = '$car_id'";
// $result4 = $conn->query($sql4);



    if (mysqli_num_rows($result4) > 0) {
        while($row = mysqli_fetch_assoc($result4)) {
            $id = $row["id"];
            $car_model = $row["car_model"];
            $car_number = $row["car_number"];
            $agency_name = $row["agency_name"];
            $agency_phone = $row["agency_phone"];
        }
    }

    if (!$result1 | !$result2 | !$result3){
        die("Couldnt enter data: ".$conn->error);
    }

?>
<!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   Car Rentals </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            <?php
                if(isset($_SESSION['login_agency'])){
            ?> 
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_agency']; ?></a>
                    </li>
                    <li>
                    <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Control Panel <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="addcar.php">Add Car</a></li>
              <li> <a href="agencyview.php">View</a></li>

            </ul>
            </li>
          </ul>
                    </li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>
            
            <?php
                }
                else if (isset($_SESSION['login_customer'])){
            ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                    </li>
                    <ul class="nav navbar-nav">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Garagge <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="prereturncar.php">Return Now</a></li>
              <li> <a href="mybookings.php"> My Bookings</a></li>
            </ul>
            </li>
          </ul>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>

            <?php
            }
                else {
            ?>

            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="agency_login.php">Agency</a>
                    </li>
                    <li>
                        <a href="customer_login.php">Customer</a>
                    </li>
                    <li>
                        <a href="#"> FAQ </a>
                    </li>
                </ul>
            </div>
                <?php   }
                ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="container">
        <div class="jumbotron">
            <h1 class="text-center" style="color: green;"><span class="glyphicon glyphicon-ok-circle"></span> Booking Confirmed.</h1>
        </div>
    </div>
    <br>

    <h2 class="text-center"> Thank you for using Car Rental System! We wish you have a safe ride. </h2>

 

    <h3 class="text-center"> <strong>Your Order Number:</strong> <span style="color: blue;"><?php echo "$id"; ?></span> </h3>


    <div class="container">
        <h5 class="text-center">Please read the following information about your order.</h5>
        <div class="box">
            <div class="col-md-10" style="float: none; margin: 0 auto; text-align: center;">
                <h3 style="color: orange;">Your booking has been received and placed into out order processing system.</h3>
                <br>
                <h4>Please make a note of your <strong>order number</strong> now and keep in the event you need to communicate with us about your order.</h4>
                <br>
                <h3 style="color: orange;">Invoice</h3>
                <br>
            </div>
            <div class="col-md-10" style="float: none; margin: 0 auto; ">
                <h4> <strong>Car Model: </strong> <?php echo $car_model; ?></h4>
                <br>
                <h4> <strong>Car Number:</strong> <?php echo $car_number; ?></h4>
                <br>

                <br>
                <h4> <strong>Booking Date: </strong> <?php echo date("Y-m-d"); ?> </h4>
                <br>
                <h4> <strong>Start Date: </strong> <?php echo $rent_start_date; ?></h4>
                <br>
                <h4> <strong>Return Date: </strong> <?php echo $rent_end_date; ?></h4>
                <br>
                <br>
                <h4> <strong>Agency Name:</strong>  <?php echo $agency_name; ?></h4>
                <br>
                <h4> <strong>Agency Contact: </strong> <?php echo $agency_phone; ?></h4>
                <br>
            </div>
        </div>
        <div class="col-md-12" style="float: none; margin: 0 auto; text-align: center;">
            <h6>Warning! <strong>Do not reload this page</strong> or the above display will be lost. If you want a hardcopy of this page, please print it now.</h6>
        </div>
    </div>
</body>
<?php } else { ?>
    <!-- Navigation -->
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="color: black">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand page-scroll" href="index.php">
                   Car Rentals </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->

            <?php
                if(isset($_SESSION['login_agency'])){
            ?> 
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_agency']; ?></a>
                    </li>
                    <li>
                    <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Control Panel <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="add.php">Add Car</a></li>
              <li> <a href="agencyview.php">View</a></li>

            </ul>
            </li>
          </ul>
                    </li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>
            
            <?php
                }
                else if (isset($_SESSION['login_customer'])){
            ?>
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_customer']; ?></a>
                    </li>
                    <ul class="nav navbar-nav">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Garagge <span class="caret"></span> </a>
                <ul class="dropdown-menu">
              <li> <a href="returncar.php">Return Now</a></li>
              <li> <a href="mybookings.php"> My Bookings</a></li>
            </ul>
            </li>
          </ul>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </li>
                </ul>
            </div>

            <?php
            }
                else {
            ?>

            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="agencylogin.php">Employee</a>
                    </li>
                    <li>
                        <a href="customerlogin.php">Customer</a>
                    </li>
                    <li>
                        <a href="#"> FAQ </a>
                    </li>
                </ul>
            </div>
                <?php   }
                ?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="container">
	<div class="jumbotron" style="text-align: center;">
        You have selected an incorrect date.
        <br><br>
</div>
                <?php } ?>
<footer class="site-footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6">
                <p>&copy; <?php echo date("Y"); ?>Surya Car Booking</p>
                </div>
            </div>
        </div>
    </footer>
</html>