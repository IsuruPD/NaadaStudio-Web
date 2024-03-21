<?php 
  session_start();
  $value=$_SESSION['sucvl'];
  $username=$_SESSION['username'];
  
  // Check if the user is logged in
  if (!isset($username)) {
    header("Location: index.php"); 
    exit();
  }

  //Check page load criteria
  if(!isset($value)){
    header("Location: admindashboard.php");
    exit();
  }

  if(isset($_POST['btnback'])){
      if($value==1){
        header("Location: manageemployees.php");
      }elseif($value==2){
        header("Location: manageinstruments.php");
      }elseif($value==3){
        header("Location: managepackages.php");
      }elseif($value==4){
        header("Location: managereservations.php");
      }else{
        header("Location: admindashboard.php");
      }
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
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #3f3e3e;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #3f3e3e;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body>
        <div class="card">
            <div style="border-radius:300px; height:200px; width:200px; background: #858585ae; margin:0 auto;">
                <i class="checkmark">✓</i>
            </div>
            <h1>Success</h1> 
            <p>Request has been completed!</p>
        </div>
        <div class="mt-5">
            <form method="POST" action="#">
              <button class="btn btn-dark py-2 pl-5 pr-5 " type="submit" name="btnback">Go Back</button>
            </form>
        </div>
    </body>
</html>