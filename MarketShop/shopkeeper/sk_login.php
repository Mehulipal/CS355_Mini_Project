<?php
//This script will handle login
session_start();

// Check if the employee is already logged in
if(isset($_SESSION['skID']))
{
  header("location: sk_home.php");
  exit;
}
// Include config.php
require_once (dirname(__FILE__)."/../config.php");

// Declare variables
$skID = $passwd = "";
$err = "";

// If POST request method is made for login...
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  // Check if empID or password is empty 
  if(empty(trim($_POST['skID'])) || empty(trim($_POST['passwd'])))
  {
    $err = "Please enter ShopkeeperID & Password";
  }
  // Otherwise, set variables $empID and $passwd
  else
  {
    $skID = trim($_POST['skID']);
    $passwd = trim($_POST['passwd']);
  }

  // If there are no errors, continue to login
  if(empty($err))
  {
    // Prepare mysqli query to select the employee details
    $sql = "SELECT * FROM shopkeeper WHERE SkID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_skID);
    $param_skID = $skID;
      
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt))
    {
      mysqli_stmt_store_result($stmt);

      // If empID exists in database, continue to login
      if(mysqli_stmt_num_rows($stmt) == 1)
      {
        mysqli_stmt_bind_result($stmt, $SkID, $hashed_passwd, $SkName, $AadharID, $Address, $Gender, $SecurityPassExp, $Contact);
        if(mysqli_stmt_fetch($stmt))
        {
          // Check if password is correct
          if(!strcmp(sha1($passwd), $hashed_passwd))
          {
            // Prepare mysqli query to select the employee details
            $sql2 = "SELECT * FROM shop WHERE SID = (SELECT SID FROM association WHERE SkID = ?)";
            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "s", $param_skID2);
            $param_skID2 = $skID;
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_store_result($stmt2);
            mysqli_stmt_bind_result($stmt2, $SID, $SName, $OwnerName, $Contact2, $Location, $Area, $LP_StartDate, $LP_ExpiryDate, $LicensePeriod, $ExtensionPeriod);
            mysqli_stmt_fetch($stmt2);
            
            // This means the password is corrct. Allow employee to login...
            session_start();
            // Set the session variables
            $_SESSION["SkID"] = $SkID;
            $_SESSION["passwd"] = $hashed_passwd;
            $_SESSION["SkName"] = $SkName;
            $_SESSION["AadharID"] = $AadharID;
            $_SESSION["Address"] = $Address;
            $_SESSION["Gender"] = $Gender;
            $_SESSION["SecurityPassExp"] = $SecurityPassExp;
            $_SESSION["Contact"] = $Contact;
            $_SESSION["loggedin"] = true;
            $_SESSION["SID"] = $SID;
            $_SESSION["SName"] = $SName;
            $_SESSION["OwnerName"] = $OwnerName;
            $_SESSION["Contact2"] = $Contact2;
            $_SESSION["Location"] = $Location;
            $_SESSION["Area"] = $Area;
            $_SESSION["LP_StartDate"] = $LP_StartDate;
            $_SESSION["LP_ExpiryDate"] = $LP_ExpiryDate;
            $_SESSION["LicensePeriod"] = $LicensePeriod;
            $_SESSION["ExtensionPeriod"] = $ExtensionPeriod;
            
            //Redirect employee to profile page
            header("location: sk_home.php");                         
          }
          // If password is incorrect, login fails
          else
          {
            echo '<script>alert("Incorrect password... try again!")</script>';
          }
        }
      }
      // If empID doesn't exist in database, login fails
      // Employee needs to register first
      else
      {
        echo '<script>alert("Shopkeeper does not exist")</script>';
      }
    }
    // Incase mysqli query fails to execute, show alert 
    else
    {
      echo '<script>alert("Something went wrong... cannot redirect!")</script>';
    }
  }    
  // Incase of error, login fails and alert is shown
  else
  {
    echo "<script>alert('$err');</script>";
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Market Shop related services</title>
  </head>
  <body style="background-color:darkkhaki">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Login</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="../admin/admin_login.php">Login_as_Admin</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Login_as_Shopkeeper<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../feedback.php">Feedback</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3>Login as Shopkeeper:</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="exampleInputID">Shopkeeper ID</label>
    <input type="text" name="skID" class="form-control" id="exampleInputID" aria-describedby="skIDhelp" placeholder="Enter Shopkeeper ID">
  </div>
  <!-- passwd -->
  <div class="form-group">
    <label for="exampleInputPassword">Password</label>
    <input type="password" name="passwd" class="form-control" id="exampleInputPassword" placeholder="Enter Password">
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary">Submit</button>
</form>



</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
