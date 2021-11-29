<?php
// Include config.php
require_once "config.php";
session_start();
// Declare variables

$SID_err = "";
$FoodID = "";
$GuestID = $NoOfPlates = $FoodBkStatus = $ServingDate = $bookingDT = "";

// When POST request is made to register,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  if(empty(trim($_POST["GuestID"])) || empty(trim($_POST["MealType"])) || empty(trim($_POST["PlateNo"])) || empty(trim($_POST["ServingDate"])))
  {
    $SID_err = "Please fill all the blank";
  }
  else if(date("Y-m-d") != trim($_POST["ServingDate"])){
    $SID_err = "Food cannot be booked can be booked only on the day of serving";
  }
  else if(trim($_POST["MealType"]) == 'L' && date("H:i:s")<"10:00:00" ){
    $SID_err = "Lunch cannot be booked at this time";
  }
  else if(trim($_POST["MealType"]) == 'D' && date("H:i:s")<"17:00:00" ){
    $SID_err = "Dinner cannot be booked at this time";
  }
  else
  {
    $sql = "SELECT FoodID FROM fooddetails WHERE TypeOfMeal = ? AND Day = ? AND VegOrNon = ?";
    $stmt = mysqli_prepare($conn, $sql);
     
  if($stmt)
  {
    mysqli_stmt_bind_param($stmt, "sss", $param_MealType, $param_day, $param_vn);

    // Set the value of param_empID
    $param_MealType = trim($_POST['MealType']);
    $date = trim($_POST["ServingDate"]);
    function getWeekday($date) {
    return date('w', strtotime($date));
    }
    $param_day = getWeekday($date); // returns 4

    $param_vn = trim($_POST['vegOrNon']);
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt))
    {
      mysqli_stmt_store_result($stmt);

      // If empID already exists in database, set empID error
      if(mysqli_stmt_num_rows($stmt) == 0)
      {
        $SID_err = "This meal can not be order"; 
      }
      // Otherwise, set variable $empID
      else
      {
        $q5 = "SELECT * FROM fooddetails WHERE TypeOfMeal='$param_MealType' AND Day ='$param_day' AND VegOrNon = '$param_vn' ";
        $r5 = mysqli_query($conn, $q5);
        $u5 = mysqli_fetch_assoc($r5);
        $FoodID = $u5["FoodID"];
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
  $GuestID = trim($_POST['GuestID']);
  $NoOfPlates = trim($_POST['PlateNo']);
  $FoodBkStatus = 1;
  $ServingDate = trim($_POST['ServingDate']);
  $bookingDT = date('Y-m-d H:i:s', time());
  
  

  // If there were no errors, go ahead and insert into the database
  if(empty($SID_err))
  {
    // Prepare mysqli query
    $sql = "INSERT INTO foodbooking (FoodID, GuestID, NoOfPlates, FoodBkStatus, ServingDate, BookingDT) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
      mysqli_stmt_bind_param($stmt, "ssssss", $param_FoodID, $param_GuestID, $param_NoOfPlates, $param_FoodBkStatus, $param_ServingDate, $param_bookingDT);

      // Set these parameters
      $param_FoodID = $FoodID;
      $param_GuestID = $GuestID;
      $param_NoOfPlates = $NoOfPlates;
      $param_FoodBkStatus = $FoodBkStatus;
      $param_ServingDate = $ServingDate;
      $param_bookingDT = $bookingDT;

      // Try to execute the query
      // If it executes successfully, redirect to login page
      if (mysqli_stmt_execute($stmt))
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Food has been ordered successfully");'; 
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

    <title>Guest House related services</title>
  </head>
  <body style="background-color: pink">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="sk_home.php">User</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="sk_home.php">Guests<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_addSk.php">Room Booking</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Food Booking</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_myShop.php">Booking Status</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_payment.php">Payment Receipt</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  <div class="navbar-collapse collapse">
  <ul class="navbar-nav ml-auto">
  <li class="nav-item active">
        <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome ". $_SESSION['EmpName']?></a>
      </li>
  </ul>
  </div>
  </div>
  </nav>
  

<div class="container mt-4">
<h3>Order Meals for your guest:</h3>
<p>You can book your only lunch before 10 am of the day of serving and similarly order dinner before 5pm of the day of serving!!
</p>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <div class="form-row div class="form-row>
  <div class="form-group col-md-4">
    <label for="inputGuestID">GuestID </label>
    <input type="text" class="form-control" name="GuestID" id="inputGuestID" placeholder="Please enter GuestID" required>
  </div>
  <div class="form-group col-md-4">
    <label for="inputMealType">Type of Meal </label>
    <input type="text" class="form-control" name="MealType" id="inputMealType" placeholder="Enter L/B/D" required>
  </div>
</div>

<div class="form-row div class="form-row>
  <div class="form-group col-md-4">
    <label for="inputPlateNo">No. of Plates </label>
    <input type="Number" class="form-control" name="PlateNo" id="inputPlateNo" value="1" required>
  </div>
  <div class="form-group col-md-4">
    <label for="inputServingDate">Date Of Serving </label>
    <input type="date" class="form-control" name="ServingDate" id="inputServingDate" required>
  </div>
  <div class="form-group col-md-4">
    <label for="inputvegOrNon">Veg Or Non-Veg </label>
    <input type="text" class="form-control" name="vegOrNon" id="inputvegOrNon" placeholder="Enter V/N" required>
  </div>
</div>
  <!-- Update button -->
  <button type="submit" class="btn btn-primary">Order Meal</button>
  <br>
  <a style="font-size: 28px" href="https://drive.google.com/file/d/15VoNVwHqLwEekkq-g6_95CRylu6DxPmw/view?usp=sharing">Menu with rates</a>
  </form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
