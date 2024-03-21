<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

if (isset($_POST['confrsrv'])) {
    // Establish a connection to the database
    $host = "localhost";
    $usernamedb = "root";
    $password = "";
    $database = "naadastudiosdb"; 
    $conn = mysqli_connect($host, $usernamedb, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve form values
    $username = $_SESSION['username'];
    $reserve_date = $_POST['reservationDate'];
    $start_time = $_POST['startTime'];
    $period = $_POST['period'];
    $end_time = $start_time + $period;
    $duration = $period;
    $cost = $_POST['totalCost'];

    // Check for overlapping reservations
    $sql_check_overlap = "SELECT * FROM reservations 
                         WHERE reserve_date = '$reserve_date' 
                         AND (
                            ((start_time <= '$start_time' AND end_time > '$start_time') AND status != 'Cancelled' )
                         OR ((start_time < '$end_time' AND end_time >= '$end_time') AND status != 'Cancelled' )
                         OR (('$start_time' <= start_time AND '$end_time' >= end_time) AND status != 'Cancelled' ) )";

    $result_check_overlap = mysqli_query($conn, $sql_check_overlap);
    if (mysqli_num_rows($result_check_overlap) > 0) {
        // An overlapping reservation exists, show an error message
        echo "<script>alert('The chosen time slot is not available. Please choose a different time slot.');</script>";
        echo "<script>history.back()</script>";
        mysqli_close($conn);
        exit();
    }

    // Insert reservation into the reservations table
    $sql_insert_reservation = "INSERT INTO reservations (username, reserve_date, start_time, end_time, duration, cost) 
                              VALUES ('$username', '$reserve_date', '$start_time', '$end_time', '$duration', $cost)";

    if (mysqli_query($conn, $sql_insert_reservation)) {
        $reservation_id = mysqli_insert_id($conn); 

        // Insert items into the reservation_addons table
        $items = json_decode($_GET['items'], true);
        foreach ($items as $item) {
            $title = $item['title'];
            $quantity = $item['quantity'];

            // Insert addon item into reservation_addons table
            $sql_insert_addon = "INSERT INTO reservation_addons (reservation_id, addon_name, quantity) 
                                 VALUES ($reservation_id, '$title', $quantity)";

            if (!mysqli_query($conn, $sql_insert_addon)) {
                echo "Error inserting addon: " . mysqli_error($conn);
            }
        }

        // Close the database connection
        mysqli_close($conn);
        
        // Redirect to success.php
        header("Location: success.php");
        exit();
    } else {
        echo "Error inserting reservation: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css">
    <title>Place Reservation</title>
</head>
<body>

    <!--Navigation Bar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark bg-body-tertiary py-3 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <img src="images/iconMic.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                <i>Naada Studio</i>
            </a>           
        </div>
    </nav>

    <!--Items list-->
    <section class="mt-4 py-5">
        <div class="rsrvbg">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title">Order List</h2>
                </div>
            </div>
            <!-- Table for displaying cart items -->
            <?php
                $period=0;
                // Retrieve the cart items from the query parameter
                $items = json_decode($_GET['items']);

                // Display the cart items in a table
                echo "<div><div class='table-responsive'><table class='table table-light table-striped table-hover itemlist'>";
                echo "  <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>";

                $htotal = 0;

                foreach ($items as $item) {
                    $title = $item->title;
                    $price = $item->price;
                    $quantity = $item->quantity;
                    $itemTotal = $price * $quantity;

                    echo "<tr>";
                    echo "<td>$title</td>";
                    echo "<td>Rs. $price </td>";
                    echo "<td>$quantity</td>";
                    echo "<td>Rs. $itemTotal</td>";
                    echo "</tr>";

                    $htotal += $itemTotal;
                }

                echo "</table></div></div>";

                // Display the total price
                echo "<span class='ordertot'>Charge: Rs. $htotal/=</span>";
            ?>
        </div>
    <section>

    <!-- Reservation -->
    <section class="shop container">
        <div class="rsrvbg">          
            <div class="">
                <h2 class="section-title text-center">Reservation</h2>
            </div>
            <br>
            <form method="POST" action="#">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td><label for="reservationDate">Date </label></td>
                            <td><label for="startTime">Start Time </label></td>
                            <td><label for="period">Period </label></td>                   
                        </tr>
                        <tr>
                            <td><input type="date" id="reservationDate" name="reservationDate" required></td>
                            <td><input type="number" id="startTime" name="startTime" min="08" max="19" required> <span id="format">H Morning</span></td>
                            <td><input type="number" id="period" name="period" min="1" max="12" required> Hours</td>                    
                        <tr>
                        <tr>
                            <td><span id="orderTotal" class='ordertot'>Total : </span></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" id="hiddenTotalCost" name="totalCost"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" id="confrsrv" name="confrsrv" class="confrsrv btn btn-success py-2 pl-5 pr-5 col-lg-4 col-md-12 col-12" value="Confirm">
                                <input type="reset" id="rmvrsrv" name="rmvrsrv" class="rmvrsrv btn btn-danger py-2 pl-5 pr-5 col-lg-4 col-md-12 col-12" value="Cancel">
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Notice: The studio will be open everyday from 0800H to 2000H only.</td>
                            <td></td>
                            <td></td>
                        </tr>                    
                    </table>
                </div>
            </form>
        </div>
        <div class="bg"></div>
        <div class="bg bg2"></div>
        <div class="bg bg3"></div>
    </section>

    <!--Calculations-->
    <script>
        // Function to update the max attribute of the period input
        function updateEndTimeMax() {
            const startTimeInput = document.getElementById("startTime");
            const periodInput = document.getElementById("period");
            const selectedStartTime = parseInt(startTimeInput.value, 10);

            // Calculate the max value for the period input
            let maxEndTime;
            if (selectedStartTime >= 8 && selectedStartTime <= 19) {
                maxEndTime = 20 - selectedStartTime;
            } else {
                maxEndTime = 0; // Default max value if startTime is not in the valid range (8 to 19)
            }

            // Set the max attribute for the period input
            periodInput.max = maxEndTime;
        }
        function updateStartTimeFormat() {
            const startTimeInput = document.getElementById("startTime");
            const formatSpan = document.getElementById("format");
            const selectedStartTime = parseInt(startTimeInput.value, 10);

            // Check if startTime is between 12 and 19 (Evening) or between 8 and 12 (Morning)
            if (selectedStartTime >= 12 && selectedStartTime <= 19) {
            formatSpan.textContent = "H Evening";
            } else if (selectedStartTime >= 8 && selectedStartTime < 12) {
            formatSpan.textContent = "H Morning";
            } else {
            formatSpan.textContent = "N/A"; // Default text if startTime is not in the valid range (8 to 19)
            }
        }

        // Function to calculate and update the total cost
        function updateTotalCost() {
            const periodInput = document.getElementById("period");
            const selectedPeriod = parseInt(periodInput.value, 10);
            const hourlyRate = <?php echo $htotal; ?>; // Get the hourly rate from PHP variable $htotal
            const totalCost = hourlyRate * selectedPeriod;

            // Update the text inside the span with the calculated total cost
            const orderTotalSpan = document.getElementById("orderTotal");
            orderTotalSpan.textContent = "Total: Rs. " + totalCost + "/=";
            document.getElementById("hiddenTotalCost").value = totalCost;
        }

        // Add event listener to the startTime input to update the text inside the span
        document.getElementById("startTime").addEventListener("change", updateStartTimeFormat);

        // Add event listener to the startTime input to update the max attribute of the period input
        document.getElementById("startTime").addEventListener("change", updateEndTimeMax);

        //Add event listtener to calculate the order total inside span
        document.getElementById("period").addEventListener("change", updateTotalCost);
    </script>
</body>
</html>