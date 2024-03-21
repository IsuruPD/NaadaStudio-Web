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

$package_id = $_POST['package_id'];
$query = mysqli_prepare($conn, "SELECT name, package_constituents, hourly_rate, imagepath FROM packages WHERE package_id= ?");
mysqli_stmt_bind_param($query, 'i', $package_id);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $name, $constituents, $hourlyrate, $imagepath);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);

// Close the database connection
mysqli_close($conn);

// Return the retrieved data as a JSON response
$response = [
    'name' => $name,
    'package_constituents' =>$constituents,
    'hourlyrate' => $hourlyrate,
    'imagepath'=>$imagepath
];
header('Content-Type: application/json');
echo json_encode($response);
?>
