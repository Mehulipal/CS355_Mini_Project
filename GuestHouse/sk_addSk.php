<?php
// Include config.php
require_once "config.php";
session_start();
// Declare variables

$SID_err = "";
$GuestName = $AadharID = $Address = $Gender = $Contact = $checkOutDT = $checkInDT = $bookingDT = $payBy = $EmpID = $roomDesc =  "";

// When POST request is made to register,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  if(empty(trim($_POST["GuestName"])) || empty(trim($_POST["AadharID"])) || empty(trim($_POST["Contact"])) || empty(trim($_POST["Address"])) || empty(trim($_POST["Gender"])) || empty(trim($_POST["roomDesc"])) || empty(trim($_POST["payBy"])) || empty(trim($_POST["checkInDT"])) || empty(trim($_POST["checkOutDT"])))
  {
    $SID_err = "Any field cannot be blank";
  }
  else
  {
    // Prepare mysqli query to check if empID already exists in database 
    $sql = "SELECT AdhaarNo FROM guestinfo WHERE AdhaarNo = ?";
    $stmt = mysqli_prepare($conn, $sql);
     
  if($stmt)
  {
    mysqli_stmt_bind_param($stmt, "s", $param_AdhaarNo);

    // Set the value of param_empID
    $param_SID = trim($_POST['AadharID']);

    // Try to execute this statement
    if(mysqli_stmt_execute($stmt))
    {
      mysqli_stmt_store_result($stmt);

      // If empID already exists in database, set empID error
      if(mysqli_stmt_num_rows($stmt) > 0)
      {
        $SID_err = "This guest already exists"; 
      }
      // Otherwise, set variable $empID
      else
      {
        $SID = trim($_POST['AadharID']);
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
  $GuestName = trim($_POST['GuestName']);
  $EmpID = trim($_POST['EmpID']);
  $Gender = trim($_POST['Gender']);
  $AadharID = trim($_POST['AadharID']);
  $Address = trim($_POST['Address']);
  $Contact = trim($_POST['Contact']);
  $checkInDT = trim($_POST['checkInDT']);
  $checkOutDT = trim($_POST['checkOutDT']);
  $bookingDT = trim($_POST['bookingDT']);
  $roomDesc = trim($_POST['roomDesc']);
  $payBy = trim($_POST['payBy']);
  
  

  // If there were no errors, go ahead and insert into the database
  if(empty($SID_err))
  {
    // Prepare mysqli query
    $sql = "INSERT INTO requesttable (GuestName, EmpID, Gender, AadhaarNo, Address, PhoneNo, CheckInDT, CheckOutDT, BookingDate, RoomDesc, PaymentBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
      mysqli_stmt_bind_param($stmt, "sssssssssss", $param_GuestName, $param_EmpID, $param_Gender, $param_AadharID, $param_Address, $param_Contact, $param_cin, $param_cout, $param_bt, $param_roomDesc, $param_payBy);

      // Set these parameters
      $param_GuestName = $GuestName;
      $param_EmpID = $EmpID;
      $param_Gender = $Gender;
      $param_AadharID = $AadharID;
      $param_Address = $Address;
      $param_Contact = $Contact;
      $param_cin = $checkInDT;
      $param_cout = $checkOutDT;
      $param_bt = $bookingDT;
      $param_roomDesc = $roomDesc;
      $param_payBy = $payBy;

      // Try to execute the query
      // If it executes successfully, redirect to login page
      if (mysqli_stmt_execute($stmt))
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Request to reserve a room sent successfully");'; 
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

    <title>Guest House related services</title>
  </head>
  <body style="background-color:cadetblue">
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
        <a class="nav-link" href="#">Room Booking</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_foodBook.php">Food Booking</a>
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
<h3>Enter New Guest Details:</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <div class="form-group">
    <label for="inputEmpName">Guest Name </label>
    <input type="text" class="form-control" name="GuestName" id="inputGuestName" placeholder="Please enter GuestName" required>
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-4">
      <label for="inputDoJ">Aadhar ID</label>
      <input type="text" class="form-control" name="AadharID" id="inputAadharID" placeholder="Aadhar ID (12 digits)" required>
    </div>
    <!-- salary -->
    <div class="form-group col-md-4">
    <label for="inputEmail">Contact</label>
    <input type="text" class="form-control" name="Contact" id="inputContact" placeholder="Contact (10 digits)" required>
  </div>
    <!-- department -->
    <div class="form-group col-md-4">
      <label for="inputDept">Gender</label>
      <input type="text" class="form-control" name="Gender" id="inputGender" placeholder="Gender (M/F)" required>
    </div>
  </div>
  <!-- email -->
  <div class="form-group">
      <label for="inputSalary">Address</label>
      <input type="text" class="form-control" name="Address" id="inputAddress" placeholder="Address" required>
    </div>
<div class="form-row">
    <div class="form-group col-md-4">
    <label for="inputEmpName">Room Description</label>
    <select name="roomDesc" id="roomDesc" required>
          <option value="Please_Choose">Please Choose....</option>
          <option value="With_Attached_Bathroom">With Attached Bathroom</option>
          <option value="With_Non-Attached_Bathroom">With Non-Attached Bathroom</option>
    </select>
  </div>
    <div class="form-group col-md-4">
    <label for="payBy">Payment By</label>
        <select name="payBy" id="payBy" required>
          <option value="Please_Choose">Please Choose....</option>
          <option value="guest">Guest</option>
          <option value="indentor">Indentor</option>
          <option value="project_fund">Project Fund</option>
          <option value="institute">Institute</option>
        </select>
  </div>
  <div class="form-group col-md-4">
      <label for="inputDept">Indenter ID</label>
      <input type="text" class="form-control" name="EmpID" id="inputEmpID" value="<?php echo $_SESSION['EmpID']; ?>" readonly>
    </div>
</div>
<div class="form-row">
  <div class="form-group col-md-4">
        <label for="checkInDT">Check In Date and Time : <br></label>
        <input type="datetime-local" class="form-control" name="checkInDT" required>
      </div>
      <div class="form-group col-md-4">
        <label for="checkOutDT">Check Out Date and Time : <br></label>
        <input type="datetime-local" class="form-control" name="checkOutDT" required>
      </div>
      <div class="form-group col-md-4">
        <?php
                echo "<label for='bookingDT'>Booking Date : <br></label>";
                echo "<input type='date' name='bookingDT' min='2012-01-01' value='" . date('Y-m-d') . "' readonly />";
            ?>
      </div>
  </div>
  <!-- Update button -->
  <button type="submit" class="btn btn-primary">Request to reserve</button>
  </form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
