<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = "";
}

$message = "";

if (isset($_POST['sendbtn'])) {
    $host = "localhost";
    $usernamedb = "root";
    $password = "";
    $database = "naadastudiosdb";
    $conn = mysqli_connect($host, $usernamedb, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $contact = filter_var($_POST['contact'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    if ($username == "") {
        $message = "Login to continue";
    } else {
        // Check if message already exists
        $existing_messages = "SELECT COUNT(*) FROM inquiries_table WHERE username = ? AND description = ?";
        $existing_stmt = mysqli_stmt_init($conn);

        if(mysqli_stmt_prepare($existing_stmt, $existing_messages)){
            mysqli_stmt_bind_param($existing_stmt, "ss", $username, $message);
            mysqli_stmt_execute($existing_stmt);
            mysqli_stmt_bind_result($existing_stmt, $count);
            mysqli_stmt_fetch($existing_stmt);
            mysqli_stmt_close($existing_stmt);

            if ($count > 0) {
                $message = "Message already sent!";
            } else {
                $insert_message = "INSERT INTO inquiries_table (username, name, contact, email, description) VALUES (?, ?, ?, ?, ?)";
                $insert_stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($insert_stmt, $insert_message)) {
                    mysqli_stmt_bind_param($insert_stmt, "sssss", $username, $name, $contact, $email, $message);

                    if (mysqli_stmt_execute($insert_stmt)) {
                        $message = 'Message sent successfully!';
                    } else {
                        $message = 'Error: ' . mysqli_stmt_error($insert_stmt);
                    }
                } else {
                    $message = 'Statement preparation failed.';
                }
            }
        }
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Naada Music</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="styles/styles.css">
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
                        <a class="nav-link  active" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">    
                        <a class="nav-link" href="profiledashboard.php">                
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

    
    <!-- <section class="bg-img bg-cover" style="background-image: url('images/studiobg.jpg'); height:100vh; width:100%; background-position: bottom -170px left -120px; display: flex; flex-direction: column; justify-content: center; align-items: flex-start;" id="homepg">
        <div class="container">
            <h1><span>Naada Music</span> Kottawa</h1>
            <p id="titleDes">For all your music production and sound engineering <br>needs</p>
            <button id="rsrvBtn">Reserve Now</button>    
        </div>

    <!-- Contact Form -->
    <section class="containerContact" style="background-image: url('images/locinst.jpg');">
        <div class="containerContactForm">
            <div>
                <form action="#" method="post">
                    <h2 class="titleContact" >Reach us here!</h2>
                    <div class="txtInputContact">
                        <input type="text" name="name" id="name" required>
                        <label for="">Name</label>
                    </div>
                    <div class="txtInputContact">
                        <input type="text" name="contact" id="contact" maxlength="10" required>
                        <label for="">Contact Number</label>
                    </div>
                    <div class="txtInputContact">
                        <input type="email" name="email" id="email" required>
                        <label for="" >Email</label>
                    </div>
                    <div class="txtInputContact">
                        <textarea name="message" class="box" placeholder="Enter your message..." maxlength="500" cols="41" rows="10" required ></textarea>
                    </div>
                    <div>
                        <?php echo "<p class='errormsg'>".$message."</p>" ?>
                    </div>
                    <input type="submit" value="Send Message" name="sendbtn" class="btnSend">
                </form>
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
</body>
</html>