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

if(!($designation == "Administrator" || $designation == "Stock Manager")){
    header("Location: error.php"); 
    exit();
}

$host = "localhost";
$usernamedb = "root";
$password = "";
$database = "naadastudiosdb";
$conn = mysqli_connect($host, $usernamedb, $password, $database);

if (isset($_POST['submit'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $type = $_POST['type'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $quantity = $_POST['quantity'];
    $hrate = $_POST['hrate'];
    $drate = $_POST['drate'];
    $description = $_POST['description'];
    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    // Handle image upload
    $imagePath = 'dbimages/' . $_FILES['image']['name'];
    $imageTempPath = $_FILES['image']['tmp_name'];

    // Check if a record already exists with the same name or image name
    $existingRecordQuery = mysqli_prepare($conn, 'SELECT COUNT(*) FROM instruments WHERE name = ? OR imagepath = ?');
    mysqli_stmt_bind_param($existingRecordQuery, 'ss', $name, $imagePath);
    mysqli_stmt_execute($existingRecordQuery);
    mysqli_stmt_bind_result($existingRecordQuery, $count);
    mysqli_stmt_fetch($existingRecordQuery);
    mysqli_stmt_close($existingRecordQuery);

    if ($count > 0) {
        // Display error message if a record already exists
        echo "<script type='text/javascript'>alert('A record with the same name or image already exists.');</script>";
    } else {
        // Move uploaded image to the destination folder
        if (move_uploaded_file($imageTempPath, $imagePath)) {
            // Prepare and execute the SQL statement
            $stmt = mysqli_prepare($conn, 'INSERT INTO instruments (name, type, brand, model, quantity, hourlyrate, dailyrate, description, imagepath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            mysqli_stmt_bind_param($stmt, 'ssssiddss', $name, $type, $brand, $model, $quantity, $hrate, $drate, $description, $imagePath);
            mysqli_stmt_execute($stmt);

            // Check if the insertion was successful
            if (mysqli_affected_rows($conn) > 0) {
                $_SESSION['sucvl']=2;
                // Display a success message
                header("Location:success.php");
                exit();
            } else {
                unset($_SESSION['sucvl']);
                // Handle delete error
                echo 'Error deleting the data!';
                    }
        } else {
            // Handle upload error
            echo 'Error moving the uploaded file.';
        }
    }
}

// Retrieve data from the instruments table
$query = mysqli_query($conn, "SELECT instrument_id, name, hourlyrate, dailyrate, imagepath, type, brand, model, quantity, description FROM instruments");
if (!$query) {
    die('Error executing query: ' . mysqli_error($conn));
}


if (isset($_POST['update'])) {
    // Retrieve form data
    $instrument_id = $_POST['instrument_id'];
    $Newname = $_POST['name'];
    $Newtype = $_POST['type'];
    $Newbrand = $_POST['brand'];
    $Newmodel = $_POST['model'];
    $Newquantity = $_POST['quantity'];
    $Newhrate = $_POST['hrate'];
    $Newdrate = $_POST['drate'];
    $Newdescription = $_POST['description'];

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    // Handle image upload
    $NewimagePath = 'dbimages/' . $_FILES['image']['name'];
    $imageTempPath = $_FILES['image']['tmp_name'];

    // Move uploaded image to the destination folder
    if (move_uploaded_file($imageTempPath, $NewimagePath)) {
        // Prepare and execute the SQL statement
        $stmt = mysqli_prepare($conn, 'UPDATE instruments SET name=?, type=?, brand=?, model=?, quantity=?, hourlyrate=?, dailyrate=?, description=?, imagepath=? WHERE instrument_id=?');
        mysqli_stmt_bind_param($stmt, 'ssssiddssi', $Newname, $Newtype, $Newbrand, $Newmodel, $Newquantity, $Newhrate, $Newdrate, $Newdescription, $NewimagePath, $instrument_id);
        mysqli_stmt_execute($stmt);

        // Check if the update was successful
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['sucvl']=2;
            // Display a success message
            header("Location:success.php");
            exit();
        } else {
            unset($_SESSION['sucvl']);
            // Handle delete error
            echo 'Error deleting the data!';
        }
    } else {
        // Handle upload error
        echo 'Error uploadeding the file!';
    }
}

if (isset($_POST['delete'])) {
    $instrument_id = $_POST['instrument_id'];

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    $stmt= mysqli_prepare($conn, "DELETE FROM instruments WHERE instrument_id= ?");
    mysqli_stmt_bind_param($stmt, 'i', $instrument_id);
    mysqli_stmt_execute($stmt);
    // Check if the update was successful
    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['sucvl']=2;
        // Display a success message
        header("Location:success.php");
        exit();
    } else {
        unset($_SESSION['sucvl']);
        // Handle delete error
        echo 'Error deleting the data!';
    }

}

// Close the database connection
mysqli_close($conn);
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manage Instruments</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="stylesheet" href="../styles/styles.css">

    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../javascript/cart.js"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.mngInst').click(function() {
                    // Retrieve the data from the selected product
                    var name = $(this).find('.product-title').text();
                    $.ajax({
                        url: 'get_product_data.php', 
                        method: 'POST',
                        data: { name: name },
                        dataType: 'json',
                        success: function(data) {
                            $('#instrument_id').val(data.instrument_id);
                            $('#name').val(data.name);
                            $('#type').val(data.type);
                            $('#brand').val(data.brand);
                            $('#model').val(data.model);
                            $('#quantity').val(data.quantity);
                            $('#hrate').val(data.hourlyrate);
                            $('#drate').val(data.dailyrate);
                            $('#description').val(data.description);
                        },
                        error: function() {
                            alert('Error retrieving product data.');
                        }
                    });
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
                            <a class="nav-link active" href="manageinstruments.php">Instruments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="managepackages.php">Packages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="managereservations.php">Reservations</a>
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

        <!-- Records Management -->
        <div class="container mt-5 py-5">
            <section class="recordsmanagement p-5">
                <div class="text-center container">
                    <h2 id="subTitle">Manage Instruments</h2>
                    <hr>
                </div>
                <section>
                    <form action="" method="POST" enctype="multipart/form-data" class="row g-3 mx-auto d-flex justify-content-center">
                        <div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="name" class="form-label">Name</label></div>
                                <div class="col-md-12 col-lg-12 col-12"><input type="text" id="name" name="name" class="form-control" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="type" class="form-label">Type</label></div>
                                <div class="col-md-12 col-lg-12 col-12"><input type="text" id="type" name="type" class="form-control" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="brand" class="form-label">Brand</label></div>
                                <div class="col-md-12 col-lg-12 col-12"><input type="text" id="brand" name="brand" class="form-control" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="model" class="form-label">Model</label></div>
                                <div class="col-md-12 col-lg-12 col-12"><input type="text" id="model" name="model" class="form-control" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="quantity" class="form-label">Quantity</label></div>
                                <div class="col-md-12 col-lg-12 col-12"><input type="number" id="quantity" name="quantity" class="form-control" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="hrate" class="form-label">Hourly Rate</label></div>
                                <div class="col-md-12 col-lg-12 col-12"><input type="number" id="hrate" name="hrate" step="0.1" class="form-control" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="drate" class="form-label">Daily Rate</label></div>
                                <div class="col-md-12 col-lg-12 col-12"><input type="number" id="drate" name="drate" step="0.1" class="form-control" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="description" class="form-label">Description</label><br></div>
                                <div class="col-md-12 col-lg-12 col-12">
                                    <textarea name="description" id="description"  placeholder="Enter description..." maxlength="500" cols="40" rows="10" class="form-control" required >           
                                    </textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="image" class="form-label">Image</label></div>
                                <div class="col-md-12 col-lg-12 col-12"><input type="file" id="image" name="image" class="form-control" accept="image/*"></div>
                            </div>
                            <div class="row">
                                <input type="hidden" id="instrument_id" name="instrument_id" class="form-control">
                                <br><br>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"></div>
                                <div class="col-md-12 col-lg-12 col-12">
                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                    <button class="btn btn-warning" type="submit" name="update">Update</button>
                                    <button class="btn btn-danger" type="submit" name="delete">Delete</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>    
            </section>   
        </div>    
            <hr>

        <!-- Inventory -->
        <div>
            <section class="shop container">
                <h2 class="section-title">Inventory</h2>
                <div class="shop-content">
                <?php
                $host = "localhost";
                $usernamedb = "root";
                $password = "";
                $database = "naadastudiosdb";
                $conn = mysqli_connect($host, $usernamedb, $password, $database);
                // Retrieve data from the "instruments" table
                $query = mysqli_query($conn, "SELECT name, hourlyrate, dailyrate, imagepath FROM instruments");
                if (!$query) {
                    die('Error executing query: ' . mysqli_error($conn));
                }         
                // Display each item in the desired format
                while ($row = mysqli_fetch_assoc($query)) { 
                    $name = $row['name'];
                    $hrate = $row['hourlyrate'];
                    $drate = $row['dailyrate'];
                    $imagePath = $row['imagepath'];
                    ?>
                    <div class="product-box mngInst">
                        <img src="../admin/<?php echo $imagePath ?>" alt="" class="product-img">
                        <h2 class="product-title"><?php echo $name ?></h2>
                        <span class="price">Hourly Rate Rs. <?php echo $hrate ?><br/></span>
                        <span class="price">Daily Rate Rs. <?php echo $drate ?></span>
                        
                    </div>
                <?php } ?>
                </div>
            </section>
        </div>
    </body>
</html>