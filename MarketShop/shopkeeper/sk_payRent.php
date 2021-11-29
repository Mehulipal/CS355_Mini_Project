<?php
// Include config.php
require_once (dirname(__FILE__)."/../config.php");
session_start();
// Declare variables
$SID = $Month = $Year = "";
$SID_err = $Month_err = $Year_err = "";
$PayeeName = $Amount = "";

// When POST request is made,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  // Check if SID is empty
  if(empty(trim($_POST["SID"])))
  {
    $SID_err = "Shop ID cannot be blank";
  }
  // Check if Month is empty
  else if(empty(trim($_POST["Month"])))
  {
    $Month_err = "Paying for which month field cannot be blank";
  }
  // Check if Year is empty
  else if(empty(trim($_POST["Year"])))
  {
    $Year_err = "Paying for which year field cannot be blank";
  }
  else
  {
  // Prepare mysqli query to check if SID exists in database 
  $sql = "SELECT SID FROM shop WHERE SID = ?";
  $stmt = mysqli_prepare($conn, $sql);
     
  if($stmt)
  {
    mysqli_stmt_bind_param($stmt, "s", $param_SID);

    // Set the value of param_SID
    $param_SID = trim($_POST['SID']);

    // Try to execute this statement
    if(mysqli_stmt_execute($stmt))
    {
      mysqli_stmt_store_result($stmt);

      // If SID does not exist in database, set SID error
      if(mysqli_stmt_num_rows($stmt) == 0)
      {
        $SID_err = "This shop does not exist"; 
      }
      // Otherwise, set variable $empID, $Month, $Year
      else
      {
        $SID = trim($_POST['SID']);
        $Month = trim($_POST['Month']);
        $Year = trim($_POST['Year']);
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
  $PayeeName = trim($_POST['PayeeName']);
  $Amount = trim($_POST['Amount']);
  
  // If there were no errors, go ahead and
  // insert rent payment details into the database
  // The request to approve the payment is now sent to ADMIN
  if(empty($SID_err) && empty($Month_err) && empty($Year_err))
  {
    // Prepare mysqli query
    $sql = "INSERT INTO request_rent (SID, PayForWhichMonth, PayForWhichYear, PayeeName, Amount, SkID_requester) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
      mysqli_stmt_bind_param($stmt, "iiisii", $param_SID, $param_Month, $param_Year, $param_PayeeName, $param_Amount, $param_SkID);

      // Set these parameters
      $param_SID = $SID;
      $param_Month = $Month;
      $param_Year = $Year;
      $param_PayeeName = $PayeeName;
      $param_Amount = $Amount;
      $param_SkID = $_SESSION['SkID'];
      
      // Try to execute the query
      // If it executes successfully, redirect
      if (mysqli_stmt_execute($stmt))
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Request to review & update payment sent successfully");'; 
        echo 'window.location.href = "sk_rentStat.php";';
        echo '</script>';
      }
      // Otherwise, show alert
      else
      {
        echo '<script>alert("You have already paid rent for this month!")</script>';
      }
    }
  }
  // Incase of errors, registration fails and alerts are shown 
  else
  {
    if(!empty($SkID_err))
    {
      echo "<script>alert('$SkID_err');</script>";
    }
    else if(!empty($SID_err))
    {
      echo "<script>alert('$SID_err');</script>";
    }
    else if(!empty($passwd_err))
    {
      echo "<script>alert('$passwd_err');</script>";
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
  <body style="background-color:thistle">
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
      <li class="nav-item">
        <a class="nav-link" href="sk_addSk.php">Add_Shopkeeper</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Rent_Status<span class="sr-only">(current)</span></a>
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
<h3>Rent Payment Details:</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <div class="form-group">
    <label for="inputEmpID4">Shop ID</label>
    <input type="text" class="form-control" name="SID" id="inputSID4" value="<?php echo $_SESSION['SID']?>" readonly>
  </div>
  <div class="form-row">  
    <div class="form-group col-md-6">
      <label for="inputPassword4">Paying for which month?</label>
      <input type="text" class="form-control" name="Month" id="inputMonth" placeholder="Jan:1, Feb:2, Mar:3,..">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Paying for which year?</label>
      <input type="text" class="form-control" name="Year" id="inputYear" placeholder="YYYY">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputMobile">Payee Name</label>
      <input type="text" class="form-control" name="PayeeName" id="inputPayeeName" value="<?php echo $_SESSION['SkName']?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="inputEmail">Amount</label>
      <input type="text" class="form-control" name="Amount" id="inputAmount" placeholder="Please enter amount paid">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Claim Payment</button>
  </form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
