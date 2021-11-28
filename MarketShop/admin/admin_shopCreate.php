<?php
// Include config.php
require_once (dirname(__FILE__)."/../config.php");

// Declare variables
$SID = "";
$SID_err = "";
$SName = $OwnerName = $Contact = $Location = $Area = $LP_StartDate = $LP_ExpiryDate = $LicensePeriod = $ExtensionPeriod = "";

// When POST request is made to register,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  // Check if empID is empty
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
        if(mysqli_stmt_num_rows($stmt) == 1)
        {
          $SID_err = "This Shop ID already exists"; 
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
  $SName = trim($_POST["SName"]);
  $OwnerName = trim($_POST["OwnerName"]);
  $Contact = trim($_POST["Contact"]);
  $Location = trim($_POST["Location"]);
  $Area = trim($_POST["Area"]);
  $LP_StartDate = trim($_POST["LP_StartDate"]);
  $LP_ExpiryDate = trim($_POST["LP_ExpiryDate"]);
  $LicensePeriod = trim($_POST["LicensePeriod"]);
  $ExpiryPeriod = trim($_POST["ExtensionPeriod"]);

  // If there were no errors, go ahead and insert into the database
  if(empty($SID_err))
  {
    // Prepare mysqli query
    $sql = "INSERT INTO shop (SID, SName, OwnerName, Contact, Location, Area, LP_StartDate, LP_ExpiryDate, LicensePeriod, ExtensionPeriod) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
      mysqli_stmt_bind_param($stmt, "issssissii", $param_SID, $param_SName, $param_OwnerName, $param_Contact, $param_Location, $param_Area, $param_LP_StartDate, $param_LP_ExpiryDate, $param_LicensePeriod, $param_ExpiryPeriod);

      // Set these parameters
      $param_SID = $SID;
      $param_SName = $SName;
      $param_OwnerName = $OwnerName;
      $param_Contact = $Contact;
      $param_Location = $Location;
      $param_Area = $Area;
      $param_LP_StartDate = $LP_StartDate;
      $param_LP_ExpiryDate = $LP_ExpiryDate;
      $param_LicensePeriod = $LicensePeriod;
      $param_ExpiryPeriod = $ExpiryPeriod;

      // Try to execute the query
      // If it executes successfully, redirect to login page
      if (mysqli_stmt_execute($stmt))
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Shop successfully registered");'; 
        echo 'window.location.href = "admin_home.php";';
        echo '</script>';
      }
      // Otherwise, show alert
      else
      {
        echo '<script>alert("Something went wrong... cannot redirect!")</script>';
      }
    }
    mysqli_stmt_close($stmt);
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
  <body style="background-color:paleturquoise">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Shop_Details<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_skReq.php">Add_Shopkeeper_Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_rentReq.php">Rent_Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_elecBillReq.php">Electricity_Bill_Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
<h3>Enter New Shop Details:</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="inputEmpID4">Shop ID</label>
    <input type="text" class="form-control" name="SID" id="inputSID4" placeholder="Please enter Shop ID">
  </div>
  <!-- empName -->
  <div class="form-group">
    <label for="inputEmpName">Shop Name</label>
    <input type="text" class="form-control" name="SName" id="inputSName" placeholder="Please enter Shop Name">
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-6">
      <label for="inputDoJ">Owner Name</label>
      <input type="text" class="form-control" name="OwnerName" id="inputOwnerName" placeholder="Owner Name">
    </div>
    <!-- salary -->
    <div class="form-group col-md-6">
      <label for="inputSalary">Contact</label>
      <input type="text" class="form-control" name="Contact" id="inputContact" placeholder="Contact (10 digits)">
    </div>
  </div>
  <div class="form-row">
    <!-- department -->
    <div class="form-group col-md-6">
      <label for="inputDept">Location</label>
      <input type="text" class="form-control" name="Location" id="inputLocation" placeholder="Location">
    </div>
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">Area</label>
      <input type="text" class="form-control" name="Area" id="inputArea" placeholder="Area (in sq feet)">
    </div>
  </div>
  <div class="form-row">
    <!-- department -->
    <div class="form-group col-md-6">
      <label for="inputDept">License Period Start Date</label>
      <input type="date" class="form-control" name="LP_StartDate" id="inputlpStartDate">
    </div>
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">License Period Expiry Date</label>
      <input type="date" class="form-control" name="LP_ExpiryDate" id="inputlpExpiryDate">
    </div>
  </div>
  <div class="form-row">
    <!-- department -->
    <div class="form-group col-md-6">
      <label for="inputDept">Licence Period</label>
      <input type="text" class="form-control" name="LicensePeriod" id="inputLicensePeriod" placeholder="Licence Period">
    </div>
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">Extension Period</label>
      <input type="text" class="form-control" name="ExtensionPeriod" id="inputExtensionPeriod" placeholder="Extension Period">
    </div>
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary">Add Shop</button>
  </form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
