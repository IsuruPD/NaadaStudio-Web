<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: admindashboard.php"); 
    exit();
}

$message = "";

if (isset($_POST['loginbtn'])) {
    $host = "localhost";
    $usernamedb = "root";
    $password = "";
    $database = "naadastudiosdb";
    $conn = mysqli_connect($host, $usernamedb, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $encrypted_pwd = md5($password);

    // Check if the username and password match in the customerlogin table
    $checkLogin = "SELECT * FROM employee_logins WHERE username = '$username' AND password = '$encrypted_pwd'";
    $loginResult = mysqli_query($conn, $checkLogin);
    if (mysqli_num_rows($loginResult) > 0) {
        // Username and password match, set the user as logged in
        $_SESSION['username'] = $username;
        header("Location: admindashboard.php");
        exit();
    } else {
        $message = "Invalid credentials. Please try again.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
        <link rel="stylesheet" href="../styles/adminstyles.css">
    </head>
<body>

<div class="container">
    <div class=" left col-lg-4 col-md-4 col-6">
            <div class="header">
                <h2>Welcome</h2>
                <h4>Log in to your account using the username and password</h4>
            </div>
            <div class="form">
                <form method="POST" action="#">
                    <input type="text" class="form-field" name="username" placeholder="Username" required>
                    <input type="password" class="form-field" name="password" placeholder="Password" required>
                    <br>
                    <p><?php echo $message ?></p>
                    <button class="btn btn-dark my-5" type="submit" name="loginbtn" id="loginbtn">Login Here</button>
                </form>
            </div>
    </div>
    <div class="right col-lg-8 col-md-8 col-6">
    </div>
</div>
</body>
</html>