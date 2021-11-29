<?php
//This script will handle login
session_start();

// Check if the employee is already logged in
if(isset($_SESSION['admID']))
{
  header("location: admin_home.php");
  exit;
}
// Include config.php
require_once "config.php";

// Declare variables
$admID = $passwd = "";
$err = "";

// If POST request method is made for login...
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  // Check if empID or password is empty 
  if(empty(trim($_POST['admID'])) || empty(trim($_POST['passwd'])))
  {
    $err = "Please enter AdminID & Password";
  }
  // Otherwise, set variables $empID and $passwd
  else
  {
    $admID = trim($_POST['admID']);
    $passwd = trim($_POST['passwd']);
  }

  // If there are no errors, continue to login
  if(empty($err))
  {
    // Prepare mysqli query to select the employee details
    $sql = "SELECT * FROM admin WHERE AdmID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $param_admID);
    $param_admID = $admID;
      
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt))
    {
      mysqli_stmt_store_result($stmt);

      // If empID exists in database, continue to login
      if(mysqli_stmt_num_rows($stmt) == 1)
      {
        mysqli_stmt_bind_result($stmt, $AdmID, $AdmName, $hashed_passwd, $Department, $email);
        if(mysqli_stmt_fetch($stmt))
        {
          // Check if password is correct
          if(!strcmp(sha1($passwd), $hashed_passwd))
          {
            // This means the password is corrct. Allow employee to login...
            session_start();
            // Set the session variables
            $_SESSION["AdmID"] = $AdmID;
            $_SESSION["passwd"] = $hashed_passwd;
            $_SESSION["AdmName"] = $AdmName;
            $_SESSION["loggedin"] = true;
            
            //Redirect employee to profile page
            header("location: admin_home.php");                          
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
        echo '<script>alert("Admin does not exist")</script>';
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

    <title>Guest House related services</title>
  </head>
  <body style="background-color:lightsteelblue">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Login</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Login_as_Admin<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Register_as_User</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_login.php">Login_as_User</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3>Login as Admin:</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="exampleInputID">Admin ID</label>
    <input type="text" name="admID" class="form-control" id="exampleInputID" aria-describedby="admIDhelp" placeholder="Enter Admin ID">
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
