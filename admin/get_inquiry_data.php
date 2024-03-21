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
$inqid = $_POST['inqid'];
$query = mysqli_prepare($conn, "SELECT inquiry_id, username, name, contact, email, description, status FROM inquiries_table WHERE inquiry_id = ?");
mysqli_stmt_bind_param($query, 'i', $inqid);
mysqli_stmt_execute($query);
mysqli_stmt_bind_result($query, $inquiry_id,$username, $name, $contact, $email, $description, $status);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);

// Close the database connection
mysqli_close($conn);

// Return the retrieved data as a JSON response
$response = [
    'inquiry_id'=>$inquiry_id,
    'username' => $username,
    'name' => $name,
    'contact' => $contact,
    'email' => $email,
    'description' => $description,
    'status' => $status
];
header('Content-Type: application/json');
echo json_encode($response);
?>
