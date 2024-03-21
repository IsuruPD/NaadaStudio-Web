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
                        <a class="nav-link  active" href="about.php">About</a>
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
        </div>
    </section>

    <!--Studio Description-->
    <section > <!--class="my-5 pb-5"-->
        <div class="container text-justify mt-5 py-5" >
            <div class="row">
                <div  class="col-lg-6 col-md-6 col-12">
                    <p>Since our establishment in  <span id="subTitle">2005</span>, Naada Studio has been at the forefront of the music industry, providing state-of-the-art recording, rehearsal, and production facilities. Our commitment to delivering uncompromising quality has earned us the privilege of working with esteemed artists such as Aathma Liyanage, Sunil Perera, Bathiya and Santhush, Umariya, and numerous other celebrated talents.</p>
                    
                    <p>Naada Studio is not just a place to record and produce music; it is a place where dreams come to life, where melodies find their wings, and where artists find their voice. Experience the legacy and expertise that have made Naada Studio the destination of choice for discerning musicians seeking unparalleled quality and artistic fulfillment.</p>
                </div>
            <div class="col-lg-6 col-md-6 col-12">
                <img src="images/main/std1.jpg" class="img-fluid" alt="Who we are">
            </div>
            </div>
        </div>
        <div class="container text-justify mb-5 py-5" >
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <img src="images/main/std3.jpeg" class="img-fluid" alt="Who we are">
                </div>
                <div  class="col-lg-6 col-md-6 col-12">
                    <p><span id="subTitle">Convenience</span> is a hallmark of Naada Studio. Situated right next to the bustling Highlevel Road, accessing our studio is a breeze. Whether you're a local artist or visiting from afar, our prime location provides easy transportation options and ample parking facilities, allowing you to focus on what truly matters – your music.
                    <br><br>
                    As you step through our doors, you'll discover a warm and inviting atmosphere, conducive to creativity and artistic expression. Our team is dedicated to providing personalized attention, understanding your unique vision, and translating it into a sonic masterpiece. We take pride in our ability to tailor our services to meet the specific requirements of each artist, ensuring an unforgettable and seamless experience from start to finish.</p>
                </div>
            </div>
        </div>
        <div class="container text-justify mt-5 py-5" >
            <div class="row">
                <div  class="col-lg-6 col-md-6 col-12">
                    <p>
                    With itscaptivating  <span id="subTitle">aesthetics</span>, Naada Studio is not limited to music alone. Its allure and charm make it an ideal place for video production and photography. Whether you're looking to capture stunning visuals for music videos, promotional shoots, or artistic projects, our studio offers an array of captivating backdrops, natural lighting, and versatile spaces that effortlessly complement your creative endeavors.<br><br>

                    Imagine capturing the essence of your musical journey against the backdrop of a mesmerizing sunset or amidst the enchanting sounds of nature. At Naada Studio, the possibilities for artistic expression are boundless, with every corner of our elegant space carefully crafted to inspire and elevate your visual creations.
                    </p>
                </div>
            <div class="col-lg-6 col-md-6 col-12">
                <img src="images/main/std2.jpg" class="img-fluid" alt="Who we are">
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

</body>
</html>