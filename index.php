<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Naada Music</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="styles/styles.css">
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    
    <script type="text/javascript">

        function display() {
            location.href = "login.php";
        };
    
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
        function instrPage() {
                window.location.href = "instrumenthire.php";
        }
        function studPage() {
                window.location.href = "reservations.php";
        }
        function locPage() {
                window.location.href = "locationbook.php";
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

    <!--Background Image-->
    <section class="bg-img bg-cover" style="background-image: url('images/studiobg.jpg'); height:100vh; width:100%;  background-position: bottom -250px left -120px; display: flex; flex-direction: column; justify-content: center; align-items: flex-start;" id="homepg">
        <div class="container">
            <h1><span>Naada Music</span> Kottawa</h1>
            <p id="titleDes">For all your music production and sound engineering <br>needs</p>
            <button id="rsrvBtn" onclick="display()">Reserve Now</button>
        </div>
    </section>

    <!--Studio Description-->
    <section > <!--class="my-5 pb-5"-->
        <div class="container text-justify mt-5 py-5" >
            <div class="row">
                <div  class="col-lg-6 col-md-6 col-12">
                    <h2 id="subTitle">Who we are</h2>

                    <p>Welcome to Naada Studio, where music comes to life! We are a premier music studio dedicated to providing a vibrant and inspiring space for musicians of all levels to create, learn, and share their passion for music. <br/><br/>
                    With state-of-the-art facilities, a diverse range of instruments, and a team of talented instructors, we offer an exceptional environment for musical exploration and growth. Whether you're a beginner taking your first steps or an experienced musician honing your skills, Naada Studio is your ultimate destination for musical excellence. Join us on this extraordinary musical journey and let your melodies soar!</p>
                </div>
            <div class="col-lg-6 col-md-6 col-12">
                <img src="images/main/descimg1.png" class="img-fluid" alt="Who we are">
            </div>
            </div>
        </div>
        <div class="container text-justify mb-5 py-5" >
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <img src="images/main/descimg2.png" class="img-fluid" alt="Who we are">
                </div>
                <div  class="col-lg-6 col-md-6 col-12">
                    <h2 id="subTitle">What we do</h2>

                    <p>At Naada Studio, we are proud to be at the forefront of the music industry, setting new standards of excellence and innovation. With years of experience and a deep passion for music, we have established ourselves as a trusted name in the industry. Our mission is to provide unparalleled music services, catering to the diverse needs of musicians and music enthusiasts alike. <br><br>
                    From top-notch recording facilities to expert music lessons, instrument rentals, and more, we offer a comprehensive range of services designed to elevate your musical journey. With a team of skilled professionals and a commitment to fostering creativity and artistic expression, we are dedicated to empowering musicians and helping them unleash their full potential.</p>
                </div>
            </div>
        </div>
    </section>

    <!--Services Section-->
    <div>
        <section> <!--class="my-5 pb-5"-->
            <div class="container text-center mt-5 py-5" >
                <h2 id="subTitle">Our Services</h2>
                <hr>
                <p>Looking for the right people to help you bring your music dream to life? Need a place host your podcast? Or are you looking for the perfect instruments to record your track? Just name what you want. We've got it all!</p>
            </div>
        </section>
        <section id="servicesSec" class="w-100">
            <div class="row p-0 m-0">
                <div class="sitems col-lg-4 col-md-4 col-12 p-0">
                    <img class="img-fluid" src="images/services/location.png" alt="Location Booking">
                    <div class="details">
                        <h2>Book Location</h2>
                        <button class="" onclick="locPage()">See more</button>
                    </div>
                </div>
                <div class="sitems col-lg-4 col-md-4 col-12 p-0">
                    <img class="img-fluid" src="images/services/locinstruments.png" alt="Location Booking">
                    <div class="details">
                        <h2>Reserve Studio</h2>
                        <button class="" onclick="studPage()">See more</button>
                    </div>
                </div>
                <div class="sitems col-lg-4 col-md-4 col-12 p-0">
                    <img class="img-fluid" src="images/services/instruments.png" alt="Hire Instruments">
                    <div class="details">
                        <h2>Hire Instruments</h2>
                        <button class="" onclick="instrPage()">See more</button>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!--Brands Row-->
    <div>
        <section> <!--class="my-5 pb-5"-->
            <div class="container text-center mt-5 py-5" >
                <h2 id="subTitle">Our Brands</h2>
                <hr>
                <p>Here are some of our most demanded brands.</p>
            </div>
        </section>
        <section class="container my-b pb-5">
            <div class="row" id="brand">
                <img class="img-fluid col-lg-2 col-md-4 col-6" src="images/brands/fender.png" alt="Fender">
                <img class="img-fluid col-lg-2 col-md-4 col-6" src="images/brands/yamaha.png" alt="Yamaha">
                <img class="img-fluid col-lg-2 col-md-4 col-6" src="images/brands/harman.png" alt="Harman">
                <img class="img-fluid col-lg-2 col-md-4 col-6" src="images/brands/gibson.png" alt="Gibson">
                <img class="img-fluid col-lg-2 col-md-4 col-6" src="images/brands/sennheiser.png" alt="Sennheiser">
                <img class="img-fluid col-lg-2 col-md-4 col-6" src="images/brands/kawai.png" alt="Kawai">
            </div>
        </section>
    </div>

    <!--Something Else Row-->
    <section> 
        <div class="container text-center mt-5 py-5" >
            
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