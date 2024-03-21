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

$instrument_id = $_POST['instrument_id'];
$query = mysqli_prepare($conn, "SELECT name, hourlyrate, dailyrate, imagepath, type, brand, model, quantity, description FROM instruments WHERE instrument_id = ?");
mysqli_stmt_bind_param($query, 'i', $instrument_id);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $name, $hourlyrate, $dailyrate, $imagepath, $type, $brand, $model, $quantity, $description);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);

// Close the database connection
mysqli_close($conn);

// Return the retrieved data as a JSON response
$response = [
    'name' => $name,
    'hourlyrate' => $hourlyrate,
    'dailyrate' => $dailyrate,
    'type' => $type,
    'brand' => $brand,
    'model' => $model,
    'quantity' => $quantity,
    'description' => $description,
    'imagepath'=>$imagepath
];
header('Content-Type: application/json');
echo json_encode($response);
?>
