<?php
require_once (dirname(__FILE__)."/../config.php");
session_start();
// Check if the employee is already logged in
// If not, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
  header("location: sk_login.php");
}
// Declare variables
$SkID = "";

// If POST request method is made to update...
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  // Set variable $SID
  $SkID = $_SESSION['SkID'];

    // Prepare mysqli query
    $sql = "UPDATE shopkeeper SET SkName = ?, AadharID = ?, Address = ?, Gender = ?, SecurityPassExp = ?, Contact = ? WHERE SkID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssssssi", $param_SkName, $param_AadharID, $param_Address, $param_Gender, $param_SecurityPassExp, $param_Contact, $param_SkID);

    // Set these parameters
    $param_SkName = trim($_POST['SkName']);
    $param_AadharID = trim($_POST['AadharID']);
    $param_Address = trim($_POST['Address']);
    $param_Gender = trim($_POST['Gender']);
    $param_SecurityPassExp = trim($_POST['SecurityPassExp']);
    $param_Contact = trim($_POST['Contact']);
    $param_SkID = trim($_POST['SkID']);

    // Try to execute the query
    // If it executes successfully, redirect to sk_home page
    // where user can view the UPDATED profile
    if (mysqli_stmt_execute($stmt))
    {
      $_SESSION['SkName'] = trim($_POST['SkName']);
      $_SESSION['AadharID'] = trim($_POST['AadharID']);
      $_SESSION['Address'] = trim($_POST['Address']);
      $_SESSION['Gender'] = trim($_POST['Gender']);
      $_SESSION['SecurityPassExp'] = trim($_POST['SecurityPassExp']);
      $_SESSION['Contact'] = trim($_POST['Contact']);
      
      echo '<script type="text/javascript">'; 
      echo 'alert("Profile updated successfully");'; 
      echo 'window.location.href = "sk_home.php";';
      echo '</script>';
    } 
    // Otherwise, show alert
    else 
    {
      echo '<script>alert("Could not update... try again!")</script>';
      echo  $conn->error;
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
  <body style="background-color:thistle">
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
<h3>Update Profile</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <div class="form-group">
    <label for="inputEmpID4">Shopkeeper ID</label>
    <input type="text" class="form-control" name="SkID" id="inputSkID4" value="<?php echo $_SESSION['SkID']?>" readonly>
  </div>
  <div class="form-group">
    <label for="inputEmpName">Shopkeeper Name</label>
    <input type="text" class="form-control" name="SkName" id="inputSkName" value="<?php echo $_SESSION['SkName']?>">
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="inputDoJ">Aadhar ID</label>
      <input type="text" class="form-control" name="AadharID" id="inputAadharID" value="<?php echo $_SESSION['AadharID']?>">
    </div>
    <div class="form-group col-md-4">
      <label for="inputSalary">Address</label>
      <input type="text" class="form-control" name="Address" id="inputAddress" value="<?php echo $_SESSION['Address']?>">
    </div>
    <div class="form-group col-md-4">
      <label for="inputDept">Gender</label>
      <input type="text" class="form-control" name="Gender" id="inputGender" value="<?php echo $_SESSION['Gender']?>">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputMobile">Security Pass Expiry Date</label>
      <input type="date" class="form-control" name="SecurityPassExp" id="inputSecurityPassExp" value="<?php echo $_SESSION['SecurityPassExp']?>">
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail">Contact</label>
      <input type="text" class="form-control" name="Contact" id="inputContact" value="<?php echo $_SESSION['Contact']?>" title="Mobile no should be of 10 digits" pattern="[1-9]{1}[0-9]{9}">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
