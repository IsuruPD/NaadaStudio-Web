<?php 
    session_start();
    // Check if the user is logged in
    $username=$_SESSION['username'];

    // Check if the user is logged in
    if (!isset($username)) {
        header("Location: index.php"); 
        exit();
    }

    if(isset($_POST['btnback'])){       
        header("Location: admindashboard.php");       
    }
?>
<!DOCTYPE html>
<html>
  <head>
      <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
    <style>
      body {
        text-align: left;
        padding: 40px 0;
        background: url('../images/messages/errorimgg.png') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }
        h1 {
          color: #545172;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #545172;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
        .errorB{
            margin-top: 50px;
        }
        .pagebody{
            margin-top: 120px;
            margin-left:120px;
        }
    </style>
    <body>
        <div class="pagebody">
            <div>
                <h1 class="errorT float-left">Access Denied!</h1> 
                <p class="errorB"><br><br>You do not have permission to access this page; <br>Contact an admin for support.</p>
            </div>
            <div class="mt-5">
                <form method="POST" action="#">
                <button class="btn btn-dark py-2 pl-5 pr-5 float-left" type="submit" name="btnback">Go Back</button>
                </form>
            </div>
        </div>
    </body>
</html>