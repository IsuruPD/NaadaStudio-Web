<?php
// Connect to the database
$host = "localhost";
$usernamedb = "root";
$password = "";
$database = "naadastudiosdb";
$conn = mysqli_connect($host, $usernamedb, $password, $database);

if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

// Retrieve the product data based on the provided id
$empid = $_POST['empid'];
$query = mysqli_prepare($conn, "SELECT fname, nic, contact, address, email, dob, join_date, designation, status FROM employee_table WHERE employee_id = ?");
mysqli_stmt_bind_param($query, 'i', $empid);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $fname, $nic, $contact, $address, $email, $dob, $joind, $designation, $status);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);

// Close the database connection
mysqli_close($conn);

// Return the retrieved data as a JSON response
$response = [
    'employee_id'=>$empid,
    'fname' => $fname,
    'nic' => $nic,
    'contact' => $contact,
    'address' =>$address,
    'email' => $email,
    'dob' => $dob,
    'join_date'=>$joind,
    'designation' => $designation,
    'status'=> $status
];
header('Content-Type: application/json');
echo json_encode($response);
?>
