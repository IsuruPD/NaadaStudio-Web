<?php
session_start();

// Check if the user is logged in
$username=$_SESSION['username'];

if (!isset($username)) {
    header("Location: index.php"); 
    exit();
}

//Check if the user has privileges
$designation=$_SESSION['designation'];

if(!($designation == "Administrator" || $designation == "Receptionist")){
    header("Location: error.php"); 
    exit();
}

$host = "localhost";
$usernamedb = "root";
$password = "";
$database = "naadastudiosdb";
$conn = mysqli_connect($host, $usernamedb, $password, $database);

if (isset($_POST['update'])) {
    // Retrieve form data 
    $reservation_id=$_POST['rsrvnid'];
    $status=$_POST['status'];

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }
    $stmt = mysqli_prepare($conn, 'UPDATE reservations SET status=? WHERE reservation_id=?');
    mysqli_stmt_bind_param($stmt, 'ss', $status, $reservation_id);
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['sucvl']=4;
        // Display a success message
        header("Location:success.php");
        
        exit();
    } else {
        unset($_SESSION['sucvl']);
        // Handle update error
        echo "<script type='text/javascript'>alert('Error saving the data!');</script>";
    }
}

if (isset($_POST['rsrvbtn'])) {
    $_SESSION['emplid']=$_POST['emplid'];
    $_SESSION['fname']=$_POST['fname'];
    header("Location:emplogins.php");
}
// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manage Reservations</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="stylesheet" href="../styles/styles.css">

    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.btncheck').click(function() {
                    // Retrieve the data from the selected
                    var rsrvid = $(this).closest('tr').find('.rsrvid').text();
                    $.ajax({
                        url: 'get_reservation_details.php', 
                        method: 'POST',
                        data: { reservation_id: rsrvid },
                        dataType: 'json',
                        success: function(data) {
                            $('#rsrvid').val(data.reservation_id);
                            $('#rsrvnid').val(data.reservation_id);
                            $('#status').val(data.status);

                            // Enable the emplogin button after the data is populated
                            $('.btn-reservation').prop('disabled', false);
                        },
                        error: function() {
                            alert('Error retrieving product data.');
                        }
                    });
                });

                // Function to check if the rsrvid field is populated
                function checkrsrvId() {
                    var rsrvidVal = $('#rsrvid').val();
                    if (rsrvidVal.trim() !== '') {
                        $('#rsrvbtn').prop('disabled', false);
                    } 
                    else {
                        $('#rsrvbtn').prop('disabled', true);
                    }
                }

                // Call the function on page load to initialize the button state
                checkrsrvId();

                // Call the function whenever the rsrvid field changes
                $('#rsrvid').on('input', checkrsrvId);

                // Reset the form and disable the emplogin button on reset button click
                $('button[name="reset"]').click(function () {
                    $('#rsrvid').val('');
                    $('form').trigger('reset');
                    $('#rsrvbtn').prop('disabled', true);
                });
            });
        </script>
        <script type="text/javascript">
            function logout() {
            var confirmed = confirm("Are you sure you want to log out?");
            if (confirmed) {
                window.location.href = "adminlogout.php";
            }
        }
        </script>

        <!--Navigation Bar-->
        <nav class="navbar navbar-expand-lg navbar-light bg-dark bg-body-tertiary py-3 fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="../images/iconMic.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                    <i>Naada Studio -Administration</i>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav ml-auto navbar-nav-scroll" style="--bs-scroll-height: 160px;">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="admindashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manageinstruments.php">Instruments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="managepackages.php">Packages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="managereservations.php">Reservations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inquiries.php">Inquiries</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manageemployees.php">Employees</a>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-dark btn-sm p-2 adminbtnlogout" onclick="logout()">Logout</button>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>
        <!-- Reservation Management -->
        <div>
            <div class="container mt-5 py-5">
                <section class="recordsmanagement p-5">
                    <div class="text-center container">
                        <h2 id="subTitle">Manage Reservations</h2>
                        <hr>
                    </div>
                    <section>
                        <form action="" method="POST" enctype="multipart/form-data" class="row g-3 mx-auto d-flex justify-content-center">
                            <div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="rsrvid" class="form-label">Reservation ID</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="rsrvid" name="rsrvid" class="form-control" disabled></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="hidden" id="rsrvnid" name="rsrvnid" class="form-control"></div>

                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="status" class="form-label">Status</label></div>
                                    <div class="col-md-12 col-lg-12 col-12">
                                        <select class="form-select col-md-12 col-lg-12 col-12 p-2" id="status" name="status">
                                            <option value="N/A" selected>Select Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <br><br>
                                <div class="row col-md-12 col-lg-12 col-12">   
                                    <div class="col-md-6 col-lg-6 col-12">
                                        <button class="btn btn-warning btn-block" type="submit" name="update">Update</button>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-12">
                                        <button class="btn btn-danger  btn-block" type="reset" name="reset">Cancel</button>                                                                      
                                    </div>
                                </div>
                                <div>          
                                    <br><br>
                                    <!-- <button class="btn btn-success col-md-12 col-lg-12 col-12 btn-reservation" id="rsrvbtn" name="rsrvbtn" disabled>Send Message</button>                                    -->
                                </div>
                            </div>
                        </form>
                    </section>    
                </section>   
            </div>    
            <div class="rsearch">
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-12 col-lg-2 col-6">
                            <label for="rdatef">Date (From)</label>
                            <input type="date" class="form-control" id="rdatef" name="rdatef">
                        </div>
                        <div class="col-md-12 col-lg-2 col-6">
                            <label for="rdatet">Date (To)</label>
                            <input type="date" class="form-control" id="rdatet" name="rdatet">
                        </div>

                        <div class="col-md-6 col-lg-2 col-3"> 
                            <label for="rstart">Start Time</label>
                            <input type="number" class="form-control" id="rstime" name="rstime" min="8" max="19" oninput="updateEndTimeMin()">
                        </div>
                        <div class="col-md-6 col-lg-2 col-3">
                            <label for="rend">End Time</label>
                            <input type="number" class="form-control" id="retime" name="retime" min="9" max="20">
                        </div>

                        <div class="col-md-6 col-lg-2 col-6">
                            <label for="rusername">Username</label>
                            <input type="text" class="form-control" name="rusername" id="rusername" placeholder="Username">
                        </div>

                        <div class="col-md-6 col-lg-2 col-6">
                            <label for="rid">Reservation ID</label>
                            <input type="number" class="form-control" name="rid" id="rid" placeholder="Reservation ID">
                        </div>
                        
                    </div>
                    <br>
                    <div class="row col-md-6 col-lg-2 col-6">
                        
                        <input type="hidden" id="filterAction" name="filterAction" value="search">
                        <button type="submit" name="rbtn" id="rbtn" class="btn btn-light btn-block">Search</button>
                    </div>
                </form>
            </div>

            <?php 
            $host = "localhost";
            $usernamedb = "root";
            $password = "";
            $database = "naadastudiosdb";
            $conn = mysqli_connect($host, $usernamedb, $password, $database);

            // Retrieve data from the reservations table
            $query = mysqli_query($conn, "SELECT reservation_id, username, reserve_date, start_time, end_time, duration, cost, status FROM reservations");

            if (!$query) {
                die('Error executing query: ' . mysqli_error($conn));
            }

            if (isset($_POST['rbtn']) && $_POST['filterAction'] === 'search') {
                $filter_datef = $_POST['rdatef'];
                $filter_datet = $_POST['rdatet'];
                $filter_start_time = $_POST['rstime'];
                $filter_end_time = $_POST['retime'];
                $filter_username = $_POST['rusername'];
                $filter_reservation_id = $_POST['rid'];
            
                // Construct the SQL query with filtering conditions
                $sql = "SELECT reservation_id, username, reserve_date, start_time, end_time, duration, cost, status FROM reservations WHERE 1=1 ";

                if(!empty($filter_datef)){
                    $sql .= "AND reserve_date>='$filter_datef' ";
                }

                if(!empty($filter_datet) && empty($filter_datef)){
                    echo "<script type='text/javascript'>alert('Insert a start date!'); </script>";
                }

                if (!empty($filter_datef) && !empty($filter_datet)) {
                    $sql .= "AND reserve_date BETWEEN '$filter_datef' AND '$filter_datet' ";
                }

                if (!empty($filter_start_time)) {
                    $sql .= "AND start_time >= $filter_start_time ";
                }

                if (!empty($filter_end_time)) {
                    $sql .= "AND end_time <= $filter_end_time ";
                }

                if (!empty($filter_username)) {
                    $sql .= "AND username LIKE '%$filter_username%' ";
                }

                if (!empty($filter_reservation_id)) {
                    $sql .= "AND reservation_id = $filter_reservation_id ";
                }
            
                // Execute the filtered SQL query
                $query = mysqli_query($conn, $sql);
            
                if (!$query) {
                    die('Error executing query: ' . mysqli_error($conn));
                }
                ?>
                
                <table id="reservationdetails" class="table table-light table-striped table-hover">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Username</th>
                        <th>Reservation Date</th>
                        <th>Start Time(H)</th>
                        <th>End Time(H)</th>
                        <th>Duration</th>
                        <th>Items</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                
                <?php
            
                // Display each filtered item in the desired format
                while ($row = mysqli_fetch_assoc($query)) {
                    $reservation_id = $row['reservation_id'];
                    $reserve_date = $row['reserve_date'];
                    $username = $row['username'];
                    $start_time = $row['start_time'];
                    $end_time = $row['end_time'];
                    $duration = $row['duration'];
                    $cost = $row['cost'];
                    $status = $row['status'];
            
                    // Retrieve addons data for the current reservation
                    $addons_query = mysqli_query($conn, "SELECT addon_name, quantity FROM reservation_addons WHERE reservation_id = $reservation_id");
            
                    // Initialize empty arrays to store addons data
                    $addon_names = array();
                    $addon_quantities = array();
            
                    // Fetch and store addons data
                    while ($addon_row = mysqli_fetch_assoc($addons_query)) {
                        $addon_names[] = $addon_row['addon_name'];
                        $addon_quantities[] = $addon_row['quantity'];
                    }
            
                    // Combine addons data into a single string
                    $addons_string = '';
                    if (count($addon_names) > 0) {
                        for ($i = 0; $i < count($addon_names); $i++) {
                            $addons_string .= $addon_names[$i] . ' x' . $addon_quantities[$i] . '<br>';
                        }
                    } else {
                        $addons_string = 'Location Booking';
                    }
                    ?>
                    <tr>
                        <td class="rsrvid"><?php echo $reservation_id ?></td>
                        <td class="username"><?php echo $username ?></td>
                        <td class="fname"><?php echo $reserve_date ?></td>
                        <td class="nic"><?php echo $start_time ?>:00</td>
                        <td class="contact"><?php echo $end_time ?>:00</td>
                        <td class="address"><?php echo $duration ?></td>
                        <td class="addon_name"><?php echo $addons_string ?></td>
                        <td class="email"><?php echo $cost ?></td>
                        <td class="dob"><?php echo $status ?></td>
                        <td class="empbtn"><button class="btn btn-secondary btn-sm btncheck" id="check" name="check">Check</button></td>
                    </tr>
                    <?php
                }
            }
            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </body>
    <script>
        function updateEndTimeMin() {
            // Get the value of rstime
            var startTime = parseInt(document.getElementById("rstime").value);

            // Calculate the minimum value for retime
            var minEndTime = startTime + 1;

            // Update the min attribute of retime input
            document.getElementById("retime").setAttribute("min", minEndTime);
        }
    </script>
</html>