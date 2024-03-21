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

// Retrieve the product data based on the provided name
$name = $_POST['name'];
$query = mysqli_prepare($conn, "SELECT package_id, name, package_constituents, hourly_rate, imagepath FROM packages WHERE name = ?");
mysqli_stmt_bind_param($query, 's', $name);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $package_id, $name, $package_constituents, $hourly_rate, $imagepath);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);

// Close the database connection
mysqli_close($conn);

// Return the retrieved data as a JSON response
$response = [
    'package_id'=>$package_id,
    'name' => $name,
    'package_constituents' => $package_constituents,
    'hourly_rate' => $hourly_rate
];
header('Content-Type: application/json');
echo json_encode($response);
?>
