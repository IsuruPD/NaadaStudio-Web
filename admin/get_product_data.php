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
$query = mysqli_prepare($conn, "SELECT instrument_id, name, hourlyrate, dailyrate, type, brand, model, quantity, description FROM instruments WHERE name = ?");
mysqli_stmt_bind_param($query, 's', $name);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $instrument_id, $name, $hourlyrate, $dailyrate, $type, $brand, $model, $quantity, $description);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);

// Close the database connection
mysqli_close($conn);

// Return the retrieved data as a JSON response
$response = [
    'instrument_id'=>$instrument_id,
    'name' => $name,
    'hourlyrate' => $hourlyrate,
    'dailyrate' => $dailyrate,
    'type' => $type,
    'brand' => $brand,
    'model' => $model,
    'quantity' => $quantity,
    'description' => $description
];
header('Content-Type: application/json');
echo json_encode($response);
?>
