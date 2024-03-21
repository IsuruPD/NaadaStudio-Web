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
$rsrvid = $_POST['reservation_id'];
$query = mysqli_prepare($conn, "SELECT reservation_id, status FROM reservations WHERE reservation_id = ?");
mysqli_stmt_bind_param($query, 's', $rsrvid);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $reservation_id, $status);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);

// Close the database connection
mysqli_close($conn);

// Return the retrieved data as a JSON response
$response = [
    'reservation_id'=>$reservation_id, 
    'status'=>$status
];
header('Content-Type: application/json');
echo json_encode($response);
?>
