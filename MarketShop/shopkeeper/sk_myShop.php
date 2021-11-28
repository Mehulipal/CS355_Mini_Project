<?php

session_start();
// Check if the employee is already logged in
// If not, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
  header("location: sk_login.php");
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
  <body style="background-color:cornflowerblue">
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
      <li class="nav-item active">
        <a class="nav-link" href="#">My_Shop<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_addSk.php">Add_Shopkeeper</a>
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
<h3>My Shop</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="inputEmpID4">Shop ID</label>
    <input type="text" class="form-control" name="sID" id="inputSID4" value="<?php echo $_SESSION['SID']?>" readonly>
  </div>
  <!-- empName -->
  <div class="form-group">
    <label for="inputEmpName">Shop Name</label>
    <input type="text" class="form-control" name="sName" id="inputSName" value="<?php echo $_SESSION['SName']?>" readonly>
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-6">
      <label for="inputDoJ">Owner Name</label>
      <input type="text" class="form-control" name="ownerName" id="inputOwnerName" value="<?php echo $_SESSION['OwnerName']?>" readonly>
    </div>
    <!-- salary -->
    <div class="form-group col-md-6">
      <label for="inputSalary">Contact</label>
      <input type="text" class="form-control" name="contact" id="inputContact" value="<?php echo $_SESSION['Contact']?>" readonly>
    </div>
  </div>
  <div class="form-row">
    <!-- department -->
    <div class="form-group col-md-6">
      <label for="inputDept">Location</label>
      <input type="text" class="form-control" name="location" id="inputLocation" value="<?php echo $_SESSION['Location']?>" readonly>
    </div>
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">Area</label>
      <input type="text" class="form-control" name="area" id="inputArea" value="<?php echo $_SESSION['Area']?>" readonly>
    </div>
  </div>
  <div class="form-row">
    <!-- department -->
    <div class="form-group col-md-6">
      <label for="inputDept">License Period Start Date</label>
      <input type="text" class="form-control" name="lpStartDate" id="inputlpStartDate" value="<?php echo $_SESSION['LP_StartDate']?>" readonly>
    </div>
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">License Period Expiry Date</label>
      <input type="text" class="form-control" name="lpExpiryDate" id="inputlpExpiryDate" value="<?php echo $_SESSION['LP_ExpiryDate']?>" readonly>
    </div>
  </div>
  <div class="form-row">
    <!-- department -->
    <div class="form-group col-md-6">
      <label for="inputDept">Licence Period</label>
      <input type="text" class="form-control" name="licensePeriod" id="inputLicensePeriod" value="<?php echo $_SESSION['LicensePeriod']?>" readonly>
    </div>
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">Extension Period</label>
      <input type="text" class="form-control" name="extensionPeriod" id="inputExtensionPeriod" value="<?php echo $_SESSION['ExtensionPeriod']?>" readonly>
    </div>
  </div>
  </form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
