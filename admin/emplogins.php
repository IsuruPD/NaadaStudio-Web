<?php

session_start();
$host = "localhost";
$usernamedb = "root";
$password = "";
$database = "naadastudiosdb";
$conn = mysqli_connect($host, $usernamedb, $password, $database);

$empid=$_SESSION['emplid'];
$fname=$_SESSION['fname'];
$query = mysqli_prepare($conn, "SELECT username FROM employee_logins WHERE employee_id= ?");
mysqli_stmt_bind_param($query, 'i', $empid);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $username);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);

if (isset($_POST['insert'])) {
    // Retrieve form data 
    $username=$_POST['username']; 
    $password=$_POST['password'];
    $encpassword=md5($password);

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    // Check if a record already exists with the same details
    $existingRecordQuery = mysqli_prepare($conn, 'SELECT COUNT(*) FROM employee_logins WHERE employee_id = ? OR username= ?');
    mysqli_stmt_bind_param($existingRecordQuery, 'ss', $empid, $username);
    mysqli_stmt_execute($existingRecordQuery);
    mysqli_stmt_bind_result($existingRecordQuery, $count);
    mysqli_stmt_fetch($existingRecordQuery);
    mysqli_stmt_close($existingRecordQuery);

    if ($count > 0) {
        // Display error message if a record already exists
        echo "<script type='text/javascript'>alert('A record with the details already exists.');</script>";
    } else {
        $stmt = mysqli_prepare($conn, 'INSERT INTO employee_logins (employee_id, username, password) VALUES (?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'sss', $empid, $username, $encpassword);
        mysqli_stmt_execute($stmt);

        // Check if the insertion was successful
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['sucvl']=1;
            // Display a success message
            header("Location:success.php");
            exit();
        } else {
            unset($_SESSION['sucvl']);
            // Handle insertion error
            echo "<script type='text/javascript'>alert('Error saving the data!');</script>";
        }
    }
}

if (isset($_POST['update'])) {
    // Retrieve form data 
    $username=$_POST['username']; 
    $password=$_POST['password'];
    $encpassword=md5($password);

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }
    $stmt = mysqli_prepare($conn, 'UPDATE employee_logins SET username=?, password=? WHERE employee_id=?');
    mysqli_stmt_bind_param($stmt, 'sss',  $username, $encpassword, $empid);
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['sucvl']=1;
        // Display a success message
        header("Location:success.php");
        exit();
    } else {
        unset($_SESSION['sucvl']);
        // Handle update error
        echo "<script type='text/javascript'>alert('Error saving the data!');</script>";
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
        <title>Manage Access</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="stylesheet" href="../styles/styles.css">
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

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
                            <a class="nav-link" href="managepackages.php">Packages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="managereservations.php">Reservations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inquiries.php">Inquiries</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="manageemployees.php">Employees</a>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>
        <!-- Employee Login Management -->
        <div>
            <div class="container mt-5 py-5">
                <section class="recordsmanagement p-5">
                    <div class="text-center container">
                        <h2 id="subTitle">Manage System Access</h2>
                        <hr>
                    </div>
                    <section>
                        <form action="" method="POST" class="row g-3 mx-auto d-flex justify-content-center">
                            <div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="empid" class="form-label">Employee ID</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="empid" name="empid" class="form-control" value="<?php echo"$empid"?>" disabled></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="hidden" id="emplid" name="emplid" class="form-control" value="<?php echo"$empid"?>"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="fname" class="form-label">Full Name</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="fname" name="fname" class="form-control" value="<?php echo"$fname"?>" disabled></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="username" class="form-label">Username</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="username" name="username" class="form-control" value="<?php echo"$username"?>"></div>
                                </div>                           
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="password" class="form-label">Password</label></div>
                                    <div class="col-md-12 col-lg-12 col-12">
                                        <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control" required>                                  
                                    </div>
                                </div>                            
                                <br><br>
                                <div class="row col-md-12 col-lg-12 col-12">          
                                    <div class="col-md-4 col-lg-4 col-12">
                                        <button class="btn btn-primary btn-block" id="submitBtn" type="submit" name="insert">Submit</button>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-12">
                                        <button class="btn btn-warning btn-block" type="submit" name="update">Update</button>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-12">
                                        <button class="btn btn-danger  btn-block" type="reset" name="reset">Cancel</button>                                                                      
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>    
                </section>   
            </div>
        </div>
    </body>
</html>