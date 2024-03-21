<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Instruments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="styles/styles.css">
</head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script type="text/javascript" src="javascript/cart.js"></script>


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
                            <li><a class="dropdown-item" href="locationbook.php">Book Location</a></li>
                            <li><a class="dropdown-item" href="reservations.php">Reserve Studio</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item active" href="instrumenthire.php">Hire Instruments</a></li>
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


                    <li class="nav-item">
                        <a class="nav-link">
                            <svg id="cart-icon" class="nav-link-svg" xmlns="http://www.w3.org/2000/svg" height="1.4em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <style>svg{fill:#ffffff}</style>
                                <path d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64v48H160V112zm-48 48H48c-26.5 0-48 21.5-48 48V416c0 53 43 96 96 96H352c53 0 96-43 96-96V208c0-26.5-21.5-48-48-48H336V112C336 50.1 285.9 0 224 0S112 50.1 112 112v48zm24 48a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm152 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/>
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

    <!-- Cart -->
    <header>
        <div class="cart">
            <h2 class="cart-title">Cart</h2>
            <div class="cart-container">
                <div class="cart-content">

                </div>
            </div>
            <div class="total">
                <div class="total-title" id="titles">Total</div>
                <div class="total-price">Rs. 0</div>
            </div>
            <button type="button" class="btn-buy" onclick="confirmCart()">Confirm</button>
            <svg xmlns="http://www.w3.org/2000/svg" height="1.4em" viewBox="0 0 384 512" id="close-cart">
                <style>svg{fill:#000000}</style>
                <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
            </svg>
        </div>
    </header>

    <!-- Instrument Addons -->
    <section class="shop container">

            <!-- The Modal -->
            <div class="modal fade custom-modal" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="itemModalLabel">Item Details</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="itemModalBody">
                        <div class="row">
                            <!-- Item details will be dynamically inserted here -->
                            <div class="col-md-6" id="itemModalBodyL"><!--Image--></div>
                            <div class="col-md-6" id="itemModalBodyR"><!--Details--></div>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark btn-sm" id="btnadd" onclick="addToCart()">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="section-title">Inventory</h2>
            <div class="shop-content">

            <?php
            $host = "localhost";
            $usernamedb = "root";
            $password = "";
            $database = "naadastudiosdb";
            $conn = mysqli_connect($host, $usernamedb, $password, $database);
            // Retrieve data from the "instruments" table
            $query = mysqli_query($conn, "SELECT instrument_id, name, type, brand, model, quantity, dailyrate, description, imagepath FROM instruments");
            if (!$query) {
                die('Error executing query: ' . mysqli_error($conn));
            }         
            // Display each item
            while ($row = mysqli_fetch_assoc($query)) { 
                $instrument_id= $row['instrument_id'];
                $name = $row['name'];
                $rated = $row['dailyrate'];
                $imagePath = $row['imagepath'];
                $type= $row['type'];
                $brand= $row['brand'];
                $model= $row['model'];
                $quantity= $row['quantity'];
                $description= $row['description'];
                ?>
                <div class="product-box">
                    <div class="pop"  data-item-id="<?php echo $instrument_id; ?>">
                        <img src="admin/<?php echo $imagePath ?>" alt="" class="product-img">
                        <h2 class="product-title"><?php echo $name ?></h2>
                    </div>
                        <span><input type="hidden" class="item-quantity" name="item-quantity" value="<?php echo $quantity ?>"></span>
                        <span class="price">Rs. <?php echo $rated ?> /d</span>                    
                    <svg class="add-cart" xmlns="http://www.w3.org/2000/svg" height="1.3em" viewBox="0 0 448 512">
                        <style>svg{fill:#000000}</style>
                    <path d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64v48H160V112zm-48 48H48c-26.5 0-48 21.5-48 48V416c0 53 43 96 96 96H352c53 0 96-43 96-96V208c0-26.5-21.5-48-48-48H336V112C336 50.1 285.9 0 224 0S112 50.1 112 112v48zm24 48a24 24 0 1 1 0 48 24 24 0 1 1 0-48zm152 24a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"/>
                    </svg>
                </div>
            <?php } ?>
            </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        // Get all elements with class "product-box"
        const productBoxes = document.querySelectorAll(".pop");

        // Function to handle the click event and display the modal with item details
        function showModal(event) {
            const itemID = event.currentTarget.dataset.itemId;

            // Make an AJAX request to retrieve item details
            fetch('get_item_details.php', {
                method: 'POST',
                body: new URLSearchParams({
                    instrument_id: itemID
                }),
            })
            .then(response => response.json())
            .then(itemDetails => {
                // Create the modal content using the retrieved data
                const modalBodyL = document.getElementById("itemModalBodyL");
                modalBodyL.innerHTML = `
                    <img src="admin/${itemDetails.imagepath}" alt="" class="product-img img-fluid">
                `;

                const modalBodyR = document.getElementById("itemModalBodyR");
                modalBodyR.innerHTML = `
                    <h2 class="product-title">${itemDetails.name}</h2>
                    <p class="item-price pt-3">Rs. ${itemDetails.dailyrate} /d</p>
                    <p class="item-type">Type: ${itemDetails.type}</p>
                    <p class="item-brand">Brand: ${itemDetails.brand}</p>
                    <p class="item-model">Model: ${itemDetails.model}</p>
                    <p class="item-quantity">Available: ${itemDetails.quantity}</p>
                    <input type="hidden" class="item-quantity-value" name="item-quantity" value="${itemDetails.quantity}">
                    <p class="item-description">Description: <br>${itemDetails.description}</p>
                `;
                

                // Show the modal
                const itemModal = new bootstrap.Modal(document.getElementById("itemModal"));
                itemModal.show();
            })
            .catch(error => {
                console.error('Error fetching item details:', error);
            });
        }

            // Add click event listener to each product-box
            productBoxes.forEach((box) => {
                box.addEventListener("click", showModal);
            });
        });

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