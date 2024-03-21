<?php
session_start();

$username=$_SESSION['username'];

// Check if the user is logged in
if (!isset($username)) {
    header("Location: index.php"); 
    exit();
}
$host = "localhost";
$usernamedb = "root";
$password = "";
$database = "naadastudiosdb";
$conn = mysqli_connect($host, $usernamedb, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$query = "SELECT e.designation FROM employee_logins el JOIN employee_table e ON el.employee_id = e.employee_id WHERE el.username = ?";
$result = mysqli_query($conn, $query);


    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $employee = mysqli_fetch_assoc($result);
    } else {
        // Display an error message
        $error = 'Statement preparation failed.';
    }   
    $designation=$employee['designation'];
    $_SESSION['designation']=$designation;

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="stylesheet" href="../styles/adminstyles.css">


    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <a class="nav-link active" aria-current="page" href="admindashboard.php">Dashboard</a>
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
                        <a class="nav-link" href="manageemployees.php">Employees</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-dark btn-sm p-2 adminbtnlogout" onclick="logout()">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

        <h2 class="section-title text-center pt-5 mt-5">Administration Dashboard</h2>
        <p class="text-center md-2"><?php echo $username. " (".$designation.")" ?></p>
        <hr>

        <!--Admin Sections-->
        <div>        
            <section id="adminSec" class="w-100">
                <div class="row p-0 m-0">
                    <div class="aitems col-lg-4 col-md-4 col-12 p-5">                        
                        <a href="<?php if ($designation == "Administrator" || $designation == "Stock Manager") {?> manageinstruments.php <?php } else { echo "error.php"; } ?>">
                            <img class="img-fluid imgsec" src="../images/adminsec/inst.jpg" alt="Instruments">
                            <div class="details">
                                <h2 class="detailsT">Instruments</h2>
                            </div>
                        </a>                        
                    </div>
                    <div class="aitems col-lg-4 col-md-4 col-12 p-5">
                        <a href="<?php if ($designation == "Administrator" || $designation == "Stock Manager") {?> managepackages.php <?php } else { echo "error.php"; } ?>">
                            <img class="img-fluid imgsec" src="../images/adminsec/pack.jpg" alt="Packages">
                            <div class="details">
                                <h2 class="detailsT">Packages</h2>
                            </div>
                        </a>
                    </div>
                    <div class="aitems col-lg-4 col-md-4 col-12 p-5">
                        <a href="<?php if ($designation == "Administrator" || $designation == "Receptionist") {?> managereservations.php <?php } else { echo "error.php"; } ?>">
                            <img class="img-fluid imgsec" src="../images/adminsec/rsrv.jpg" alt="Reservations">
                            <div class="details">
                                <h2 class="detailsT">Reservations</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
            <section id="adminSec" class="w-100">
                <div class="row p-0 m-0">
                    <div class="aitems col-lg-4 col-md-4 col-12 p-5">
                        <a href="<?php if ($designation == "Administrator" || $designation == "Receptionist") {?> inquiries.php <?php } else { echo "error.php"; } ?>">
                            <img class="img-fluid imgsec" src="../images/adminsec/inq.jpg" alt="Inquiries">
                            <div class="details">
                                <h2 class="detailsT">Inquiries</h2>
                            </div>
                        </a>
                    </div>
                    <div class="aitems col-lg-4 col-md-4 col-12 p-5">
                        <a href="<?php if ($designation == "Administrator") {?> manageemployees.php <?php } else { echo "error.php"; } ?>">    
                            <img class="img-fluid imgsec" src="../images/adminsec/empl.jpg" alt="Employees">
                            <div class="details">
                                <h2 class="detailsT">Employees</h2>
                            </div>
                        </a>
                    </div>
                    <div class="aitems col-lg-4 col-md-4 col-12 p-5">
                        <a href="<?php if ($designation == "Administrator" || $designation == "Accountant") {?> analytics.php <?php } else { echo "error.php"; } ?>">
                            <img class="img-fluid imgsec" src="../images/adminsec/anl.jpg" alt="Analytics">
                            <div class="details">
                                <h2 class="detailsT">Analytics</h2>                            
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>  
    </body>
</html>