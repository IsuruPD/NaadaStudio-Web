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

// Retrieve the customer information from the database based on the username
$query = "SELECT cl.username, c.fname, c.contact, c.address, c.email, c.dob
          FROM customer c INNER JOIN customerlogin cl ON c.customer_id = cl.customer_id WHERE cl.username = ?";

$stmt = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $customer = mysqli_fetch_assoc($result);
} else {
    // Display an error message
    $error = 'Statement preparation failed.';
}

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="styles/styles.css">
    <title>Profile</title>
</head>
<body>
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
                window.location.href = "updateProfile.php";
        }
    </script>

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
                        <a class="nav-link" href="profile.php">                
                            <svg class="nav-link-svg" xmlns="http://www.w3.org/2000/svg" height="1.4em" viewBox="0 0 448 512">
                                <path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/>
                            </svg>                  
                        </a>     
                    </li>
                </ul>
                <!--<form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>-->
            </div>
        </div>
    </nav>

    <?php if (isset($customer)) : ?>
        

        <section class="containerProfile" style="background-image: url('images/locinst.jpg');">
        <div class="containerProfileSec">
            <div>
                
                    <h2 class="titleProfile" >Hello there, <?php echo $customer['username']; ?>!</h2>
                    
                    
                    <h4 class="profileData">Full Name: <?php echo $customer['fname']; ?></h4>
                    <h4 class="profileData">Contact: <?php echo $customer['contact']; ?></h4>
                    <h4 class="profileData">Address: <?php echo $customer['address']; ?></h4>
                    <h4 class="profileData">Email: <?php echo $customer['email']; ?>    </h4>
                    <h4 class="profileData">Date of Birth: <?php echo $customer['dob']; ?></h4>
                    
                    <div class="btnProfile-container">
                        <button class="btnProfile" name="ProfileUpdatebtn" onclick="update()">Update</button>
                        <button class="btnProfile" name="ProfileSignoutbtn" onclick="logout()">Sign out</button>
                    </div>
   
                    
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="mt-0 py-5">
        <div class="row container mx-auto pt-5">
            <div class="footer-one col-lg-3 col-md-6 col-12">
                <span><img src="images/iconMic.png" style="height: 50px; width: 50px;" alt=""> Naada Studio</span>
                <p class="py-2">Unlock Your Musical Potential at Naada Studio - Where Melodies Flourish and Dreams Take Flight.</p>
            </div>
            <div class="footer-one col-lg-3 col-md-6 col-12">
                <h5 class="pb-2">Our Services</h5>
                <ul class="list-unstyled">
                    <li><a href="locationbook.php">Book Location</a></li>
                    <li><a href="reservations.php">Reserve Studio</a></li>
                    <li><a href="instrumenthire.php">Hire Instruments</a></li>
                </ul>
            </div>
            <div class="footer-one col-lg-3 col-md-6 col-12">
                <h5 class="pb-2">Contact Us</h5>
                <div>
                    <h6>Address</h6>
                    <p>
                        No.123, Highlevel Rd, Kottawa
                    </p>
                </div>
                <div>
                    <h6>Telephone</h6>
                    <p>
                        (+94)11-000-0000
                    </p>
                </div>
                <div>
                    <h6>Email</h6>
                    <p>
                        info@naadamusic.com
                    </p>
                </div>
            </div>
            <div class="footer-one col-lg-3 col-md-6 col-12">
                <h5 class="pb-2">Gallery</h5>
                <div class="row">
                    <img class="img-fluid w-25 h-100 m-2" src="images/studiobg.jpg" alt="">
                    <img class="img-fluid w-25 h-100 m-2" src="images/studiobg.jpg" alt="">
                    <img class="img-fluid w-25 h-100 m-2" src="images/studiobg.jpg" alt="">
                    <img class="img-fluid w-25 h-100 m-2" src="images/studiobg.jpg" alt="">
                    <img class="img-fluid w-25 h-100 m-2" src="images/studiobg.jpg" alt="">
                </div>
            </div>
        </div>
        <div class="copyright mt-5">
            <div class="row container mx-auto">
                <div class="col-lg-4 col-md-6 col-12">
                    <!--Img--> 
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <p>Naada Studios @ 2023. All rights reserved.</p> 
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!--Img--> 
                </div>
            </div>
        </div>
    </footer>
    <?php else : ?>
        <p>Error: <?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>

