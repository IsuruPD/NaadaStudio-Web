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

if(!($designation == "Administrator")){
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
    $fname=$_POST['fname']; 
    $nic=$_POST['nic']; 
    $contact=$_POST['contact']; 
    $address=$_POST['address']; 
    $email=$_POST['email']; 
    $dob=$_POST['dob']; 
    $join_date=$_POST['joind']; 
    $designation=$_POST['designation'];
    $status=$_POST['status'];

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    // Check if a record already exists with the same details
    $existingRecordQuery = mysqli_prepare($conn, 'SELECT COUNT(*) FROM employee_table WHERE nic = ? OR contact= ? OR email = ?');
    mysqli_stmt_bind_param($existingRecordQuery, 'sss', $nic, $contact, $email);
    mysqli_stmt_execute($existingRecordQuery);
    mysqli_stmt_bind_result($existingRecordQuery, $count);
    mysqli_stmt_fetch($existingRecordQuery);
    mysqli_stmt_close($existingRecordQuery);

    if ($count > 0) {
        // Display error message if a record already exists
        echo "<script type='text/javascript'>alert('A record with the details already exists.');</script>";
    } else {
        $stmt = mysqli_prepare($conn, 'INSERT INTO employee_table (fname, nic, contact, address, email, dob, join_date, designation, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'sssssssss', $fname, $nic, $contact, $address, $email, $dob, $join_date, $designation, $status);
        mysqli_stmt_execute($stmt);

        // Check if the insertion was successful
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['sucvl']=1;
            // Redirect or display a success message         
            header("Location:success.php");
            exit();
        } else {
            // Handle insertion error
            unset($_SESSION['sucvl']);
            echo "<script type='text/javascript'>alert('Error saving the data!');</script>";
        }
    }
}

if (isset($_POST['update'])) {
    // Retrieve form data 
    $employee_id=$_POST['emplid'];
    $fname=$_POST['fname']; 
    $nic=$_POST['nic']; 
    $contact=$_POST['contact']; 
    $address=$_POST['address']; 
    $email=$_POST['email']; 
    $dob=$_POST['dob']; 
    $join_date=$_POST['joind']; 
    $designation=$_POST['designation'];
    $status=$_POST['status'];

    // Check if the connection was successful
    if (!$conn) {
        die('Database connection error: ' . mysqli_connect_error());
    }
    $stmt = mysqli_prepare($conn, 'UPDATE employee_table SET fname=?, nic=?, contact=?, address=?, email=?, dob=?, join_date=?, designation=?, status=? WHERE employee_id=?');
    mysqli_stmt_bind_param($stmt, 'ssssssssss', $fname, $nic, $contact, $address, $email, $dob, $join_date, $designation, $status, $employee_id);
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

if (isset($_POST['emplogin'])) {
    $_SESSION['emplid']=$_POST['emplid'];
    $_SESSION['fname']=$_POST['fname'];
    header("Location:emplogins.php");
}
// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manage Employees</title>
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
                    // Retrieve the data from the selected
                    var empid = $(this).closest('tr').find('.empid').text();
                    $.ajax({
                        url: 'get_employee_data.php', 
                        method: 'POST',
                        data: { empid: empid },
                        dataType: 'json',
                        success: function(data) {
                            $('#empid').val(data.employee_id);
                            $('#emplid').val(data.employee_id);
                            $('#fname').val(data.fname);
                            $('#nic').val(data.nic);
                            $('#contact').val(data.contact);
                            $('#address').val(data.address);
                            $('#email').val(data.email); 
                            $('#dob').val(data.dob); 
                            $('#joind').val(data.join_date);                          
                            $('#designation').val(data.designation);
                            $('#status').val(data.status);

                            // Enable the emplogin button after the data is populated
                            $('.btn-emplogin').prop('disabled', false);
                        },
                        error: function() {
                            alert('Error retrieving product data.');
                        }
                    });
                });

                // Function to check if the empid field is populated
                function checkEmpId() {
                    var empidVal = $('#empid').val();
                    if (empidVal.trim() !== '') {
                        $('#emplogin').prop('disabled', false);
                    } 
                    else {
                        $('#emplogin').prop('disabled', true);
                    }
                }

                // Call the function on page load to initialize the button state
                checkEmpId();

                // Call the function whenever the empid field changes
                $('#empid').on('input', checkEmpId);

                // Reset the form and disable the emplogin button on reset button click
                $('button[name="reset"]').click(function () {
                    $('#empid').val('');
                    $('form').trigger('reset');
                    $('#emplogin').prop('disabled', true);
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
                            <a class="nav-link" href="inquiries.php">Inquiries</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="manageemployees.php">Employees</a>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-dark btn-sm p-2 adminbtnlogout" onclick="logout()">Logout</button>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </nav>
        <!-- Employee Management -->
        <div>
            <div class="container mt-5 py-5">
                <section class="recordsmanagement p-5">
                    <div class="text-center container">
                        <h2 id="subTitle">Manage Employees</h2>
                        <hr>
                    </div>
                    <section>
                        <form action="" method="POST" enctype="multipart/form-data" class="row g-3 mx-auto d-flex justify-content-center">
                            <div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="empid" class="form-label">Employee ID</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="empid" name="empid" class="form-control" disabled></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="hidden" id="emplid" name="emplid" class="form-control"></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="hidden" id="username" name="username" class="form-control"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="fname" class="form-label">Full Name</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="fname" name="fname" class="form-control" required></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="nic" class="form-label">NIC</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="nic" name="nic" class="form-control" minlength="10" maxlength="12" required></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="contact" class="form-label">Contact</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="contact" name="contact" class="form-control" minlength="10" maxlength="10" required></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="address" class="form-label">Address</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="text" id="address" name="address" class="form-control" required></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="email" class="form-label">Email</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="email" id="email" name="email" class="form-control"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="dob" class="form-label">Date of Birth</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="date" id="dob" name="dob" class="form-control" required></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="joind" class="form-label">Join Date</label></div>
                                    <div class="col-md-12 col-lg-12 col-12"><input type="date" id="joind" name="joind" class="form-control" required></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="designation" class="form-label">Designation</label></div>
                                    <div class="col-md-12 col-lg-12 col-12">
                                        <select class="form-select col-md-12 col-lg-12 col-12 p-2" id="designation" name="designation" required>
                                            <option value="N/A" selected>Select designaton</option>
                                            <option value="Administrator">Administrator</option>
                                            <option value="Receptionist">Receptionist</option>
                                            <option value="Stock Manager">Stock Manager</option>
                                            <option value="Accountant">Accountant</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12"><label for="status" class="form-label">Status</label></div>
                                    <div class="col-md-12 col-lg-12 col-12">
                                        <select class="form-select col-md-12 col-lg-12 col-12 p-2" id="status" name="status">
                                            <option value="N/A" selected>Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <br><br>
                                <div class="row col-md-12 col-lg-12 col-12">          
                                    <div class="col-md-4 col-lg-4 col-12">
                                        <button class="btn btn-primary btn-block" type="submit" name="submit">Submit</button>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-12">
                                        <button class="btn btn-warning btn-block" type="submit" name="update">Update</button>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-12">
                                        <button class="btn btn-danger  btn-block" type="reset" name="reset">Cancel</button>                                                                      
                                    </div>
                                </div>
                                <div>          
                                    <br>
                                    <button class="btn btn-success col-md-12 col-lg-12 col-12 btn-emplogin" id="emplogin" name="emplogin" disabled>Manage Access</button>                                   
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
                        <th>Employee ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>NIC</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>DoB</th>
                        <th>Start Date</th>
                        <th>Designation</th>
                        <th>Status</th>
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
                    $query = mysqli_query($conn, "SELECT employee_table.employee_id, fname, username, nic, contact, address, email, dob, join_date, designation, status 
                                                    FROM employee_table LEFT JOIN employee_logins ON employee_table.employee_id = employee_logins.employee_id");
                    
                    if (!$query) {
                        die('Error executing query: ' . mysqli_error($conn));
                    }         
                    // Display each item in the desired format
                    while ($row = mysqli_fetch_assoc($query)) { 
                        $employee_id=$row['employee_id']; 
                        $fname=$row['fname']; 
                        $username=$row['username'] ?? 'N/A';
                        $nic=$row['nic']; 
                        $contact=$row['contact']; 
                        $address=$row['address']; 
                        $email=$row['email']; 
                        $dob=$row['dob']; 
                        $join_date=$row['join_date']; 
                        $designation=$row['designation'];
                        $status=$row['status'];
                        ?>
                    <tr>
                        <td class="empid"><?php echo $employee_id ?></td>
                        <td class="fname"><?php echo $fname ?></td>
                        <td class="username"><?php echo $username ?></td>
                        <td class="nic"><?php echo $nic ?></td>
                        <td class="contact"><?php echo $contact ?></td>
                        <td class="address"><?php echo $address ?></td>
                        <td class="email"><?php echo $email ?></td>
                        <td class="dob"><?php echo $dob ?></td>
                        <td class="joind"><?php echo $join_date ?></td>
                        <td class="designation"><?php echo $designation ?></td>
                        <td class="status"><?php echo $status ?></td>
                        <td class="empbtn"><button class="btn btn-secondary btn-sm btncheck" id="check" name="check">Check</button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>