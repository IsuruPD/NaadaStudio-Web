<?php

session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: profiledashboard.php"); 
    exit();
}

$message="";

if(isset($_POST['registerbtn'])){

        $host="localhost";
        $usernamedb="root";
        $password="";
        $database="naadastudiosdb";
        $conn=mysqli_connect($host,$usernamedb,$password,$database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $fname=$_POST['fname'];
        $contact=$_POST['contact'];
        $address=$_POST['address'];
        $email=$_POST['email'];
        $dob=$_POST['dob'];

        $username=$_POST['username'];
        $password=$_POST['password'];
        //$encrypted_pwd = password_hash($password, PASSWORD_DEFAULT);
        $encrypted_pwd = md5($password);

        // Check if the contact number is already used
        $checkContactQuery = "SELECT * FROM customer WHERE contact = '$contact'";
        $contactResult = mysqli_query($conn, $checkContactQuery);
        if (mysqli_num_rows($contactResult) > 0) {
            // Contact number already exists, show error message
            echo "Contact number already used. Please choose a different contact number.";
            exit();
        }

        // Check if the email is already used
        $checkEmailQuery = "SELECT * FROM customer WHERE email = '$email'";
        $emailResult = mysqli_query($conn, $checkEmailQuery);
        if (mysqli_num_rows($emailResult) > 0) {
            // Email already exists, show error message
            echo "Email already used. Please choose a different email.";
            exit();
        }

        // Check if the username is already used
        $checkUsernameQuery = "SELECT * FROM customerlogin WHERE username = '$username'";
        $usernameResult = mysqli_query($conn, $checkUsernameQuery);
        if (mysqli_num_rows($usernameResult) > 0) {
            // Username already exists, show error message
            echo "Username already used. Please choose a different username.";
            exit();
        }

        // Insert data into the customer table
        $sqlReg = "INSERT INTO customer (fname, contact, address, email, dob) 
                VALUES ('$fname','$contact', '$address','$email', '$dob')";

        if (mysqli_query($conn, $sqlReg)) {
            $customerID = mysqli_insert_id($conn);
    
            // Insert data into the customerlogin table
            $sqlLogins = "INSERT INTO customerlogin (customer_id, username, password) 
                        VALUES ('$customerID', '$username', '$encrypted_pwd')";
    
            if (mysqli_query($conn, $sqlLogins)) {
                header("Location: login.php");
                exit();
            } else {
                $message = "Error inserting data into customerlogin table: " . mysqli_error($conn);
            }
        } else {
            $message = "Error inserting data into customer table: " . mysqli_error($conn);
        }
        mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="styles/styles.css">
    <title>Signup Page</title>
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
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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
                <!--<form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>-->
            </div>
        </div>
    </nav>

    <!-- Signup Form -->
    <section class="containerSignup" style="background-image: url('images/locinst.jpg');">
        <div class="containerSignupForm">
            <div>
                <form action="#" method="post">
                    <h2 class="titleSignup" >Signup</h2>
                    <?php echo "".$message; ?>
                    <div class="txtInputParentLogin">
                        <div class="txtInputSignup inlineLogin">
                            <input type="text" name="fname" required>
                            <label for="">Full Name</label>
                        </div>
                        <div class="txtInputSignup inlineLogin">
                            <input type="text" name="contact" maxlength="10" minlength="10" required>
                            <label for="">Contact Number</label>
                        </div>
                    </div>
                    <div class="txtInputParentLogin">
                        <div class="txtInputSignup inlineLogin">
                            <input type="text" name="address" required>
                            <label for="">Address</label>
                        </div>
                        <div class="txtInputSignup inlineLogin">
                            <input type="email" name="email" required>
                            <label for="">Email</label>
                        </div>
                    </div>
                    <div class="txtInputParentLogin">
                        <div class="txtInputSignup inlineLogin">
                            <input name="dob" onload="(this.type='text')" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" required>
                            <label for="">Date of Birth</label>
                        </div>
                    </div>
                    <hr>
                    <div class="txtInputParentLogin">
                        <div class="txtInputSignup inlineLogin">
                            <input type="text" name="username" required>
                            <label for="">Username</label>
                        </div>
                        <div class="txtInputSignup inlineLogin">
                            <input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            <label for="">Password</label>
                        </div>
                    </div>

                    <button type="submit" name="registerbtn" class="btnSignup">Signup</button>
                    <div class="register">
                        <p>Already have an account? <a href="login.php">Login</a></p>
                    </div>
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