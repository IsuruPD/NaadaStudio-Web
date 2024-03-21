<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

// Establish a connection to the database
$host = "localhost";
$usernamedb = "root";
$password = "";
$database = "naadastudiosdb"; 
$conn = mysqli_connect($host, $usernamedb, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the logged-in user's username from the session
$username = $_SESSION['username'];

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" crossorigin="anonymous"/>
        <link rel="stylesheet" href="styles/styles.css">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
        <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var servicesDropdown = document.querySelector(".services-dropdown");
            var dropdownMenu = servicesDropdown.nextElementSibling;
            
            servicesDropdown.addEventListener("click", function() {
                this.classList.toggle("active");
            });
            
            document.addEventListener("click", function(event) {
                var isClickInside = servicesDropdown.contains(event.target) || dropdownMenu.contains(event.target);
                
                if (!isClickInside) {
                    servicesDropdown.classList.remove("active");
                }
            });
        });

        function logout() {
        var confirmed = confirm("Are you sure you want to log out?");
            if (confirmed) {
                window.location.href = "logout.php";
            }
        }

        function update() {
                window.location.href = "profileupdate.php";
        }
    </script>
        <style>
            .list-group-item{
                width: 200px;
            }
            .list-group-item:hover{
                color: blue !important;
            }
            .content{
                margin-top: 100px;
            }
            .ac{
                color: blue !important;
            }
        </style>
        <title>Profile</title>
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>        
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white pt-5 mt-5" id="sidebar-wrapper">                
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-dark p-3" href="profiledashboard.php">Profile</a>
                    <a class="list-group-item list-group-item-action list-group-item-dark p-3" href="profileupdate.php">Update</a>
                    <a class="list-group-item list-group-item-action list-group-item-dark p-3 ac" href="profilereservations.php">Reservations</a>
                    <!-- <a class="list-group-item list-group-item-action list-group-item-dark p-3" href="profilemessages">Messages</a> -->
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">           
            <!--Navigation Bar-->
            <nav class="navbar navbar-expand-lg navbar-light bg-dark bg-body-tertiary py-3 fixed-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <img src="images/iconMic.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
                        <i>Naada Studio</i>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarScroll">
                        <ul class="navbar-nav ml-auto navbar-nav-scroll" style="--bs-scroll-height: 160px;">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle services-dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>                               
                                <ul class="dropdown-menu navbar-light bg-dark">
                                    <li><a class="dropdown-item" href="locationbook.php">Book Location</a></li>
                                    <li><a class="dropdown-item" href="reservations.php">Reserve Studio</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="instrumenthire.php">Hire Instruments</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.php">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.php">Contact</a>
                            </li>
                            <li class="nav-item">    
                                <a class="nav-link" href="profiledashboard.php">                
                                    <svg class="nav-link-svg" xmlns="http://www.w3.org/2000/svg" height="1.4em" viewBox="0 0 448 512">
                                        <path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/>
                                    </svg>                  
                                </a>     
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="container-fluid content">
                <section class="containerProfile">
                    <div>
                        <div>
                        <?php 
                            $host = "localhost";
                            $usernamedb = "root";
                            $password = "";
                            $database = "naadastudiosdb";
                            $conn = mysqli_connect($host, $usernamedb, $password, $database);
                            $username = $_SESSION['username'];
                            // Retrieve data from the reservations table
                            $query = mysqli_query($conn, "SELECT reservation_id, reserve_date, start_time, end_time, duration, cost, status FROM reservations WHERE username='$username'");

                            if (!$query) {
                                die('Error executing query: ' . mysqli_error($conn));
                            } 
                            
                            if (!$query) {
                                die('Error executing query: ' . mysqli_error($conn));
                            }
                            ?>
                            
                            <table id="reservationdetails" class="table table-dark table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Reservation ID</th>
                                    <th>Reservation Date</th>
                                    <th>Start Time(H)</th>
                                    <th>End Time(H)</th>
                                    <th>Duration</th>
                                    <th>Items</th>
                                    <th>Total Cost</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php
                        
                            // Display each filtered item in the desired format
                            while ($row = mysqli_fetch_assoc($query)) {
                                $reservation_id = $row['reservation_id'];
                                $reserve_date = $row['reserve_date'];
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
                                    <td class="fname"><?php echo $reserve_date ?></td>
                                    <td class="nic"><?php echo $start_time ?>:00</td>
                                    <td class="contact"><?php echo $end_time ?>:00</td>
                                    <td class="address"><?php echo $duration ?></td>
                                    <td class="addon_name"><?php echo $addons_string ?></td>
                                    <td class="email"><?php echo $cost ?></td>
                                    <td class="dob"><?php echo $status ?></td>
                                </tr>
                                <?php
                            }
                        // Close the database connection
                        mysqli_close($conn);
                            
                            ?>                                   
                        </div>
                    </div>
                </section>
            </div>
            </div>
        </div>
    </body>
</html>