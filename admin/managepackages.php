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

$Emessage="";

if (isset($_POST['submit'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $package_constituents = $_POST['package_constituents'];
    $hrate = $_POST['hrate'];
    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    // Handle image upload
    $imagePath = 'dbimages/' . $_FILES['image']['name'];
    $imageTempPath = $_FILES['image']['tmp_name'];

    // Check if a record already exists with the same name or image name
    $existingRecordQuery = mysqli_prepare($conn, 'SELECT COUNT(*) FROM packages WHERE name = ?');
    mysqli_stmt_bind_param($existingRecordQuery, 's', $name);
    mysqli_stmt_execute($existingRecordQuery);
    mysqli_stmt_bind_result($existingRecordQuery, $count);
    mysqli_stmt_fetch($existingRecordQuery);
    mysqli_stmt_close($existingRecordQuery);

    if ($count > 0) {
        // Display error message if a record already exists
        echo "<script type='text/javascript'>alert('A record with the same name already exists.');</script>";
    } else {
        // Move uploaded image to the destination folder
        if (move_uploaded_file($imageTempPath, $imagePath)) {
            // Prepare and execute the SQL statement
            $stmt = mysqli_prepare($conn, 'INSERT INTO packages (name, package_constituents, hourly_rate, imagepath) VALUES (?, ?, ?, ?)');
            mysqli_stmt_bind_param($stmt, 'ssds', $name, $package_constituents, $hrate, $imagePath);
            mysqli_stmt_execute($stmt);

            // Check if the insertion was successful
            if (mysqli_affected_rows($conn) > 0) {
                $_SESSION['sucvl']=3;
                // Display a success message
                header("Location:success.php");
                exit();
            } else {
                // Handle insertion error
                $Emessage= 'Error saving the data.';
            }
        } else {
            // Handle upload error
            $Emessage= 'Error moving the uploaded file.';
        }
    }
}

// Retrieve data from the instruments table
$query = mysqli_query($conn, "SELECT package_id, name, package_constituents, hourly_rate, imagepath FROM packages");
if (!$query) {
    die('Error executing query: ' . mysqli_error($conn));
}


if (isset($_POST['update'])) {
    // Retrieve form data
    $package_id = $_POST['package_id'];
    $Newname = $_POST['name'];
    $Newpackage_constituents = $_POST['package_constituents'];
    $Newhrate = $_POST['hrate'];

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
        $stmt = mysqli_prepare($conn, 'UPDATE packages SET name=?, package_constituents=?, hourly_rate=?, imagepath=? WHERE package_id=?');
        mysqli_stmt_bind_param($stmt, 'ssdsi', $Newname, $Newpackage_constituents, $Newhrate, $NewimagePath, $package_id);
        mysqli_stmt_execute($stmt);

        // Check if the update was successful
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['sucvl']=3;
            // Display a success message
            header("Location:success.php");
            exit();
        } else {
            // Handle update error
            $Emessage= 'Error updating the data!';
        }
    } else {
        // Handle upload error
        $Emessage= 'Error uploading the file!';
    }
}

if (isset($_POST['delete'])) {
    $package_id = $_POST['package_id'];

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    $stmt= mysqli_prepare($conn, "DELETE FROM packages WHERE package_id= ?");
    mysqli_stmt_bind_param($stmt, 'i', $package_id);
    mysqli_stmt_execute($stmt);
    // Check if the update was successful
    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['sucvl']=3;
        // Display a success message
        header("Location:success.php");
        exit();
    } else {
        // Handle delete error
        $Emessage= 'Error deleting the data!';
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
        <title>Manage Packages</title>
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
                $('.mngPack').click(function() {
                    // Retrieve the data from the selected product
                    var name = $(this).find('.product-title').text();
                    $.ajax({
                        url: 'get_package_data.php', 
                        method: 'POST',
                        data: { name: name },
                        dataType: 'json',
                        success: function(data) {
                            $('#package_id').val(data.package_id);
                            $('#name').val(data.name);
                            $('#package_constituents').val(data.package_constituents);
                            $('#hrate').val(data.hourly_rate);
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
                            <a class="nav-link" href="manageinstruments.php">Instruments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="managepackages.php">Packages</a>
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
                    <h2 id="subTitle">Manage Packages</h2>
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
                                <div class="col-md-12 col-lg-12 col-12"><label for="hrate" class="form-label">Hourly Rate</label></div>
                                <div class="col-md-12 col-lg-12 col-12"><input type="number" id="hrate" name="hrate" step="0.1" class="form-control" required></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="package_constituents" class="form-label">Description</label><br></div>
                                <div class="col-md-12 col-lg-12 col-12">
                                    <textarea name="package_constituents" id="package_constituents"  placeholder="Enter description..." maxlength="500" cols="40" rows="10" class="form-control" required >           
                                    </textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-12"><label for="image" class="form-label">Image</label></div>
                                <div class="col-md-12 col-lg-12 col-12"><input type="file" id="image" name="image" class="form-control" accept="image/*"></div>
                            </div>
                            <div class="row">
                                <input type="hidden" id="package_id" name="package_id" class="form-control">
                                <?php echo $Emessage ?>
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

        <!-- Available Packages -->
        <div>
            <section class="shop container">
                <h2 class="section-title">Packages</h2>
                <div class="shop-content">
                <?php
                $host = "localhost";
                $usernamedb = "root";
                $password = "";
                $database = "naadastudiosdb";
                $conn = mysqli_connect($host, $usernamedb, $password, $database);
                // Retrieve data from the "instruments" table
                $query = mysqli_query($conn, "SELECT name, package_constituents, hourly_rate, imagepath FROM packages");
                if (!$query) {
                    die('Error executing query: ' . mysqli_error($conn));
                }         
                // Display each item in the desired format
                while ($row = mysqli_fetch_assoc($query)) { 
                    $name = $row['name'];
                    $hrate = $row['hourly_rate'];
                    $imagePath = $row['imagepath'];
                    ?>
                    <div class="product-box mngPack">
                        <img src="../admin/<?php echo $imagePath ?>" alt="" class="product-img">
                        <h2 class="product-title"><?php echo $name ?></h2>
                        <span class="price">Hourly Rate Rs. <?php echo $hrate ?><br/></span>                      
                    </div>
                <?php } ?>
                </div>
            </section>
        </div>
    </body>
</html>