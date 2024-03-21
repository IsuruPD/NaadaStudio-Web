<?php


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
    $hourlyRate = 16500;
    $cost = $hourlyRate * $duration;
    $end_time = $start_time + $period;
    $duration = $period;
    $cost = $_POST['totalCost'];

    // Check for overlapping reservations
    $sql_check_overlap = "SELECT * FROM reservations 
                         WHERE reserve_date = '$reserve_date' 
                         AND ((start_time <= '$start_time' AND end_time > '$start_time') 
                         OR (start_time < '$end_time' AND end_time >= '$end_time') 
                         OR ('$start_time' <= start_time AND '$end_time' >= end_time))";

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
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Naada Music</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/imgcarousal.css">
</head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let slideIndex = 1;
            showSlides(slideIndex);
        });
        let slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
            slideIndex = 1;
            }
            if (n < 1) {
            slideIndex = slides.length;
            }
            for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" present", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " present";
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
                        <a class="nav-link dropdown-toggle services-dropdown active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
                    
                        <ul class="dropdown-menu navbar-light bg-dark">
                            <li><a class="dropdown-item active" href="locationbook.php">Book Location</a></li>
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
    
    <!-- Slideshow -->
    <div class="slideshow-container mt-5">

        <div class="mySlides">
        <img src="images/main/1i.jpg" style="width:100%">
        </div>

        <div class="mySlides">
        <img src="images/main/2i.jpg" style="width:100%">
        </div>

        <div class="mySlides">
        <img src="images/main/3i.jpg" style="width:100%">
        </div>

        <div class="mySlides">
        <img src="images/main/4i.jpg" style="width:100%">
        </div>

        <div class="mySlides">
        <img src="images/main/5i.jpg" style="width:100%">
        </div>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <!-- The dots/circles -->
        <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
        <span class="dot" onclick="currentSlide(5)"></span>
    </div>

    <!-- Reservation -->
    <section>
        <div class="container text-justify mt-5">
            <p>
                Welcome to <span id="subTitle">Naada Studios,</span> a haven of artistic inspiration nestled amidst the breathtaking beauty of nature's grandeur. Situated in the heart of the serene Kottawa, our prestigious music studio boasts not only unrivaled state-of-the-art facilities but also a magnificent location that will leave you spellbound and invigorate your creative senses like never before.
            </p>
            <p>
                As you step onto our grounds, a symphony of sceneries unfolds before your eyes. Rolling hills painted in lush greens stretch into the horizon, merging harmoniously with the azure skies above. The warm sun casts its golden rays upon our studio, illuminating every inch of our carefully designed structure, which marries contemporary <span id="subTitle">luxury</span> with a touch of timeless elegance.
            </p>
            <p>
                Your musical journey begins in our opulent reception area, where you'll be greeted by our team of passionate professionals, dedicated to making your experience nothing short of extraordinary. Adorned with captivating art pieces and melodic motifs, our reception sets the tone for the auditory marvels that await you.
            </p>
            <p>
                Moving into our <span id="subTitle">recording rooms</span>, you'll find yourself immersed in a world of acoustic perfection. Our cutting-edge soundproofing technology ensures that no external noise disturbs your creative flow, allowing you to focus solely on the harmony you wish to compose. Our sound engineers, with their keen ears and artistic flair, are always on hand to ensure that every note resonates with pure clarity and brilliance.
            </p>
            <p>
            For videography and photography enthusiasts, our studio caters to your every need with our meticulously designed production sets. From vintage-inspired sets that harken back to the golden era of music to futuristic stages that push the boundaries of imagination, we have thoughtfully crafted environments that set the scene for your visual masterpiece.
            </p>
            <p>
            Take a stroll outside, and you'll find yourself embraced by the picturesque landscapes that encircle Naada Studios. Our sprawling gardens, adorned with vibrant blooms and tranquil water features, provide the perfect <span id="subTitle"> backdrop for music videos, photoshoots, </span> or simply moments of personal introspection.
            </p>
        </div>
    </section>
    <section class="shop container">
        <div class="rsrvbgloc">          
            <div class="">
                <h2 class="section-title text-center">Reserve Location</h2>
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
                            <td><span id="orderTotal" class='ordertot'>Rs. 16500/= per hour</span></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><input type="hidden" id="hiddenTotalCost" name="totalCost" value=""></td>
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
    </section>

    <!-- Calculations -->
    <script>
        // Function to update the total cost based on the duration
        function updateTotalCost() {
            const periodInput = document.getElementById("period");
            const selectedPeriod = parseInt(periodInput.value, 10);
            const hourlyRate = 16500; // Set the hourly rate
            const totalCost = hourlyRate * selectedPeriod;

            // Update the text inside the span with the calculated total cost
                const orderTotalSpan = document.getElementById("orderTotal");
                orderTotalSpan.textContent = "Total: Rs. " + totalCost + "/=";
                document.getElementById("hiddenTotalCost").value = totalCost;
        }

        // Add event listener to the period input to update the total cost
        document.getElementById("period").addEventListener("change", updateTotalCost);

    </script>

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