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

$message="";

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
    $error = 'Statement preparation failed.';
}

if (isset($_POST['updateProfilebtn'])) {
    // Retrieve the updated values from the form
    $newFullName = $_POST['fname'];
    $newContact = $_POST['contact'];
    $newAddress = $_POST['address'];
    $newEmail = $_POST['email'];
    $newDOB = $_POST['dob'];
    $currentEmail = $_POST['currentEmail'];
    $currentContact = $_POST['currentContact'];

    // Check if the new contact or email already exist in the database
    $checkDuplicateQuery = "SELECT cl.username 
                            FROM customer c 
                            JOIN customerlogin cl ON c.customer_id = cl.customer_id 
                            WHERE (c.contact = ? OR c.email = ?) 
                            AND cl.username <> ?";

    $checkDuplicateStmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($checkDuplicateStmt, $checkDuplicateQuery)) {
        mysqli_stmt_bind_param($checkDuplicateStmt, "sss", $newContact, $newEmail, $username);
        mysqli_stmt_execute($checkDuplicateStmt);
        mysqli_stmt_store_result($checkDuplicateStmt);

        // If there are any duplicate records, display an error message
        if (mysqli_stmt_num_rows($checkDuplicateStmt) > 0) {
            $message = "Contact or email already exists in the database.";
        } else {
            
                // Update the customer's record in the database
                $updateQuery = "UPDATE customer AS c
                                JOIN customerlogin AS cl ON c.customer_id = cl.customer_id
                                SET c.fname = ?, c.contact = ?, c.address = ?, c.email = ?, c.dob = ?
                                WHERE cl.username = ?";

                $updateStmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($updateStmt, $updateQuery)) {
                    mysqli_stmt_bind_param($updateStmt, "ssssss", $newFullName, $newContact, $newAddress, $newEmail, $newDOB, $username);
                    mysqli_stmt_execute($updateStmt);

                    // Check if the update was successful
                    if (mysqli_stmt_affected_rows($updateStmt) > 0) {
                        header("Location: updateProfile.php");
                    } else {
                        $message = "Failed to update profile.";
                    }
                } else {
                    $error = 'Statement preparation failed.';
                }

                // Close the update statement
                mysqli_stmt_close($updateStmt);
            
        }
    } else {
        $error = 'Statement preparation failed.';
    }
}



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
    <title>Update Profile</title>
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

    <!-- Update Profile Form -->
    <section class="containerUpdateProfile" style="background:#000000;"> <!--style="background-image: url('images/locinst.jpg');" -->
        <div class="containerUpdateProfileSec">
            <div>
                <form action="#" method="post">
                    <h2 class="titleUpdateProfile" >Update Profile</h2>
                    <?php echo "".$message; ?>
                    <div class="txtInputParentUpdateProfile">
                        <div class="txtInputUpdateProfile inlineUpdateProfile">
                            <input type="text" name="fname" value="<?php echo $customer['fname']; ?>" required>
                            <label for="">Full Name</label>
                        </div>
                        <div class="txtInputUpdateProfile inlineUpdateProfile">
                            <input type="text" name="contact" value="<?php echo $customer['contact']; ?>" maxlength="10" required>
                            <label for="">Contact Number</label>
                        </div>
                    </div>
                    <div class="txtInputParentUpdateProfile">
                        <div class="txtInputUpdateProfile inlineUpdateProfile">
                            <input type="text" name="address" value="<?php echo $customer['address']; ?>" required>
                            <label for="">Address</label>
                        </div>
                        <div class="txtInputUpdateProfile inlineUpdateProfile">
                            <input type="email" name="email" value="<?php echo $customer['email']; ?>" required>
                            <label for="">Email</label>
                        </div>
                    </div>
                    <div class="txtInputParentUpdateProfile">
                        <div class="txtInputUpdateProfile inlineUpdateProfile">
                            <input name="dob" onload="(this.type='text')" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" value="<?php echo $customer['dob']; ?>" required>
                            <label for="">Date of Birth</label>
                        </div>
                    </div>
                    <button type="submit" name="updateProfilebtn" class="btnupdateProfile">Update</button>
                    <hr>
                    <div class="txtInputParentUpdateProfile">
                        <div class="txtInputUpdateProfile inlineUpdateProfile">
                            <input type="password" name="oldPassword">
                            <label for="">Old Password</label>
                        </div>
                        <div class="txtInputUpdateProfile inlineUpdateProfile">
                            <input type="password" name="newPassword">
                            <label for="">New Password</label>
                        </div>
                    </div>
                    <div>
                        <div>
                            <input type="hidden" name="currentEmail" value="<?php echo $customer['email']; ?>">
                            <input type="hidden" name="currentContact" value="<?php echo $customer['contact']; ?>">
                        </div>
                    </div>
                    <button type="submit" name="updatePassProfilebtn" class="btnupdateProfile">Change</button>
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