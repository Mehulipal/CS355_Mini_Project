<?php

session_start();
// Check if the user is already logged in
// If not, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
  header("location: sk_login.php");
}
// If POST request is made,
// redirect to employee verification page 
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  header("location: sk_updateProfile.php");
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
  <body style="background-color:palevioletred">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Shopkeeper</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Profile<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_myShop.php">My_Shop</a>
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
<h3>Profile</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <div class="form-group">
    <label for="inputEmpID4">Shopkeeper ID</label>
    <input type="text" class="form-control" name="skID" id="inputSkID4" value="<?php echo $_SESSION['SkID']?>" readonly>
  </div>
  <div class="form-group">
    <label for="inputEmpName">Shopkeeper Name</label>
    <input type="text" class="form-control" name="skName" id="inputSkName" value="<?php echo $_SESSION['SkName']?>" readonly>
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputDoJ">Aadhar ID</label>
      <input type="text" class="form-control" name="aadharID" id="inputAadharID" value="<?php echo $_SESSION['AadharID']?>" readonly>
    </div>
    <div class="form-group col-md-4">
      <label for="inputSalary">Address</label>
      <input type="text" class="form-control" name="address" id="inputAddress" value="<?php echo $_SESSION['Address']?>" readonly>
    </div>
    <div class="form-group col-md-4">
      <label for="inputDept">Gender</label>
      <input type="text" class="form-control" name="gender" id="inputGender" value="<?php echo $_SESSION['Gender']?>" readonly>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputMobile">Security Pass Expiry Date</label>
      <input type="text" class="form-control" name="securityPassExp" id="inputSecurityPassExp" value="<?php echo $_SESSION['SecurityPassExp']?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail">Contact</label>
      <input type="text" class="form-control" name="contact" id="inputContact" value="<?php echo $_SESSION['Contact']?>" readonly>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Update Profile</button>
  </form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
