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

if(!($designation == "Administrator" || $designation == "Receptionist")){
    header("Location: error.php"); 
    exit();
}

$host = "localhost";
$usernamedb = "root";
$password = "";
$database = "naadastudiosdb";
$conn = mysqli_connect($host, $usernamedb, $password, $database);


if (isset($_POST['update'])) {
    // Retrieve form data
    $inquiry_id = $_POST['inqid'];
    $Newstatus = $_POST['status'];

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    // Prepare and execute the SQL statement
    $stmt = mysqli_prepare($conn, 'UPDATE inquiries_table SET  status=? WHERE inquiry_id=?');
    mysqli_stmt_bind_param($stmt, 'si', $Newstatus, $inquiry_id);
    mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if (mysqli_affected_rows($conn) > 0) {
        // Display a success message
        echo "<script type='text/javascript'> alert('Successfully Updated!');</script>";
        exit();
    } else {
        // Handle update error
        echo 'Error updating the data!';
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
        <title>Manage Inquiries</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="stylesheet" href="../styles/styles.css">

    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.btncheck').click(function() {
                    // Retrieve the data from the selected product
                    var inqid = $(this).closest('tr').find('.inqid').text();
                    $.ajax({
                        url: 'get_inquiry_data.php', 
                        method: 'POST',
                        data: { inqid: inqid },
                        dataType: 'json',
                        success: function(data) {
                            $('#inqid').val(data.inquiry_id);
                            $('#username').val(data.username);
                            $('#name').val(data.name);
                            $('#contact').val(data.contact);
                            $('#email').val(data.email); 
                            $('#status').val(data.status);                          
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
                            <a class="nav-link" href="manageinstruments.php">Instruments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="managepackages.php">Packages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="managereservations.php">Reservations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="inquiries.php">Inquiries</a>
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

        <!-- Inquiry Management -->
        <div>
            <div class="container mt-5 py-5">
                <section class="recordsmanagement p-5">
                    <div class="text-center container">
                        <h2 id="subTitle">Manage Inquiries</h2>
                        <hr>
                    </div>
                    <section>
                        <form action="" method="POST" enctype="multipart/form-data" class="row g-3 mx-auto d-flex justify-content-center">
                            <div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="username" class="form-label">Username</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="username" name="username" class="form-control" disabled></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="name" class="form-label">Name</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="name" name="name" class="form-control" disabled></div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="contact" class="form-label">Contact</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="contact" name="contact" class="form-control" disabled></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="email" class="form-label">Email</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="email" name="email" class="form-control" disabled></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="description" class="form-label">Description</label><br></div>
                                    <div class="col-md-12 col-lg-12 col-12">
                                        <textarea name="description" id="description"  placeholder="Enter description..." maxlength="500" cols="40" rows="10" class="form-control" disabled >           
                                        </textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="status" class="form-label">Status</label></div>

                                    <select class="form-select col-md-12 col-lg-12 col-12 p-2" id="status" name="status">
                                        <option value="Unread" selected>Unread</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Complete">Complete</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="inqid" class="form-label"></label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="hidden" id="inqid" name="inqid" class="form-control"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"></div>
                                    <div class="col-md-12 col-lg-12 col-12">
                                        
                                        <button class="btn btn-success" type="submit" name="update">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>    
                </section>   
            </div>    
                <hr>

            <table class="table table-dark table-striped table-hover">
                <thead>
                    <tr>
                        <th>Inquiry ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $host = "localhost";
                    $usernamedb = "root";
                    $password = "";
                    $database = "naadastudiosdb";
                    $conn = mysqli_connect($host, $usernamedb, $password, $database);
                    // Retrieve data from the inquiries table
                    $query = mysqli_query($conn, "SELECT inquiry_id, username, name, contact, email, description, status FROM inquiries_table");
                    if (!$query) {
                        die('Error executing query: ' . mysqli_error($conn));
                    }         
                    // Display each item in the desired format
                    while ($row = mysqli_fetch_assoc($query)) { 
                        $inquiry_id = $row['inquiry_id'];
                        $name = $row['name'];
                        $username = $row['username'];
                        $contact = $row['contact'];
                        $email = $row['email'];
                        $description = $row['description'];
                        $status = $row['status'];
                        ?>
                    <tr>
                        <td class="inqid"><?php echo $inquiry_id ?></td>
                        <td class="inqusr"><?php echo $username ?></td>
                        <td class="inqnam"><?php echo $name ?></td>
                        <td class="inqcon"><?php echo $contact ?></td>
                        <td class="inqem"><?php echo $email ?></td>
                        <td class="inqdes"><?php echo $description ?></td>
                        <td class="inqsta"><?php echo $status ?></td>
                        <td class="inqcbtn"><button class="btn btn-secondary btn-sm btncheck" name="check">Check</button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>