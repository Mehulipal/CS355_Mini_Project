<?php
// Include config.php
require_once (dirname(__FILE__)."/../config.php");
session_start();
// Declare variables
$SID = "";
$SID_err = "";
$SkName = $AadharID = $Address = $Gender = $Contact = "";

// When POST request is made to register,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  if(empty(trim($_POST["SID"])))
  {
    $SID_err = "Shop ID cannot be blank";
  }
  else
  {
    // Prepare mysqli query to check if empID already exists in database 
    $sql = "SELECT SID FROM shop WHERE SID = ?";
    $stmt = mysqli_prepare($conn, $sql);
     
  if($stmt)
  {
    mysqli_stmt_bind_param($stmt, "s", $param_SID);

    // Set the value of param_empID
    $param_SID = trim($_POST['SID']);

    // Try to execute this statement
    if(mysqli_stmt_execute($stmt))
    {
      mysqli_stmt_store_result($stmt);

      // If empID already exists in database, set empID error
      if(mysqli_stmt_num_rows($stmt) == 0)
      {
        $SID_err = "This shop does not exist"; 
      }
      // Otherwise, set variable $empID
      else
      {
        $SID = trim($_POST['SID']);
      }
    }
    // Incase mysqli query fails to execute, show alert 
    else
    {
      echo '<script>alert("Something went wrong")</script>';
    }
  }
  mysqli_stmt_close($stmt);
}

  // Set the variables
  $SkName = trim($_POST['SkName']);
  $AadharID = trim($_POST['AadharID']);
  $Address = trim($_POST['Address']);
  $Gender = trim($_POST['Gender']);
  $Contact = trim($_POST['Contact']);

  // If there were no errors, go ahead and insert into the database
  if(empty($SID_err))
  {
    // Prepare mysqli query
    $sql = "INSERT INTO request_add_sk (_SkName, _AadharID, _Address, _Gender, _Contact, _SID) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
      mysqli_stmt_bind_param($stmt, "sssssi", $param_SkName, $param_AadharID, $param_Address, $param_Gender, $param_Contact, $param_SID);

      // Set these parameters
      $param_SkName = $SkName;
      $param_AadharID = $AadharID;
      $param_Address = $Address;
      $param_Gender = $Gender;
      $param_Contact = $Contact;
      $param_SID = $SID;

      // Try to execute the query
      // If it executes successfully, redirect to login page
      if (mysqli_stmt_execute($stmt))
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Request to add shopkeeper sent successfully");'; 
        echo 'window.location.href = "sk_home.php";';
        echo '</script>';
      }
      // Otherwise, show alert
      else
      {
        echo '<script>alert("Something went wrong... cannot redirect!")</script>';
      }
    }
    else{
      echo "Hi";
    }
    //mysqli_stmt_close($stmt);
  }
  // Incase of errors, registration fails and alerts are shown 
  else
  {
    if(!empty($SID_err))
    {
      echo "<script>alert('$SID_err');</script>";
    }
  }
  mysqli_close($conn);
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
  <body style="background-color:cadetblue">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Shopkeeper</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="sk_home.php">Profile</a>
      </li>  
      <li class="nav-item">
        <a class="nav-link" href="sk_myShop.php">My_Shop</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Add_Shopkeeper<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_rentStat.php">Rent_Status</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_elecBillStat.php">Electricity_Bill_Status</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../logout.php">Logout</a>
      </li>
    </ul>
  <div class="navbar-collapse collapse">
  <ul class="navbar-nav ml-auto">
  <li class="nav-item active">
        <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome ". $_SESSION['SkName']?></a>
      </li>
  </ul>
  </div>
  </div>
  </nav>
  

<div class="container mt-4">
<h3>Enter New Shopkeeper Details:</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <div class="form-group">
    <label for="inputEmpName">Shop ID</label>
    <input type="text" class="form-control" name="SID" id="inputSID" placeholder="Please enter Shop ID">
  </div>
  <!-- empName -->
  <div class="form-group">
    <label for="inputEmpName">Shopkeeper Name</label>
    <input type="text" class="form-control" name="SkName" id="inputSkName" placeholder="Please enter Shopkeeper Name">
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-4">
      <label for="inputDoJ">Aadhar ID</label>
      <input type="text" class="form-control" name="AadharID" id="inputAadharID" placeholder="Aadhar ID (12 digits)">
    </div>
    <!-- salary -->
    <div class="form-group col-md-4">
      <label for="inputSalary">Address</label>
      <input type="text" class="form-control" name="Address" id="inputAddress" placeholder="Address">
    </div>
    <!-- department -->
    <div class="form-group col-md-4">
      <label for="inputDept">Gender</label>
      <input type="text" class="form-control" name="Gender" id="inputGender" placeholder="Gender (M/F)">
    </div>
  </div>
  <!-- email -->
  <div class="form-group">
    <label for="inputEmail">Contact</label>
    <input type="text" class="form-control" name="Contact" id="inputContact" placeholder="Contact (10 digits)">
  </div>
  <!-- Update button -->
  <button type="submit" class="btn btn-primary">Request to Add</button>
  </form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
