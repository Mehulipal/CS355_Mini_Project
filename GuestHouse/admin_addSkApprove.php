<?php
// Include config.php
require_once "config.php";
session_start();

// Declare variables
$GuestID = $RoomNo = $GuestName = $EmpID = $AadharID = $Address = $Gender = $CheckInDT = $CheckOutDT = $BookingDate = $Contact = $PaymentBy = $RoomDesc = "";
$SkID_err = $SID_err = "";
// When POST request is made to register,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  // Check if empID is empty
  if(empty(trim($_POST["GuestID"])))
  {
    $SkID_err = "Guest ID cannot be blank";
  }
  else
  {
    // Prepare mysqli query to check if empID already exists in database 
    $sql = "SELECT GuestID FROM guestinfo WHERE GuestID = ?";
    $stmt = mysqli_prepare($conn, $sql);
       
    if($stmt)
    {
      mysqli_stmt_bind_param($stmt, "s", $param_GuestID);

      // Set the value of param_empID
      $param_GuestID = trim($_POST['GuestID']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt))
      {
        mysqli_stmt_store_result($stmt);

        // If empID already exists in database, set empID error
        if(mysqli_stmt_num_rows($stmt) == 1)
        {
          $SkID_err = "This Guest ID already exists"; 
        }
        // Otherwise, set variable $empID
        else
        {
          $GuestID = trim($_POST['GuestID']);
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


  // Check if email is empty
  if(empty(trim($_POST["RoomNo"])))
  {
    $SID_err = "RoomNo cannot be blank";
  }
  else
  {
    // Prepare mysqli query to check if email already exists in database
    $sql = "SELECT RoomNo FROM roominfo WHERE Availability = 1 AND RoomNo = ?";
    $stmt = mysqli_prepare($conn, $sql);
  
    if($stmt)
    {
      mysqli_stmt_bind_param($stmt, "s", $param_RoomNo);

      // Set the value of param email
      $param_RoomNo = trim($_POST['RoomNo']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt))
      {
        mysqli_stmt_store_result($stmt);

        // If email already exists in database, set email error
        if(mysqli_stmt_num_rows($stmt) == 0)
        {
          $SID_err = "This room is not available"; 
        }
        // Otherwise, set variable $email
        else
        {
          $RoomNo = trim($_POST['RoomNo']);
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
  $AadharID = trim($_POST['AadharID']);
  $Address = trim($_POST['Address']);
  $Gender = trim($_POST['Gender']);
  $CheckInDT = trim($_GET['CheckInDT']);
  $CheckOutDT = trim($_GET['CheckOutDT']);
  $BookingDate = trim($_GET['BookingDate']);
  $EmpID = trim($_POST['IndenterID']);
  $RoomDesc = trim($_GET['RoomDesc']);
  $PaymentBy = trim($_GET['PaymentBy']);
  $Contact = trim($_POST['Contact']);

  // If there were no errors, go ahead and insert into the database
    
  if(empty($SkID_err) && empty($SID_err))
  {
    $sql = "INSERT INTO guestinfo (GuestID, GuestName, EmpID, PhoneNo, AdhaarNo, Address, Gender, PayBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
      mysqli_stmt_bind_param($stmt, "ssssssss", $param_GuestID, $param_GuestName, $param_EmpID, $param_PhoneNo, $param_AadhaarNo, $param_Address, $param_Gender, $param_payBy);

      // Set these parameters
      $param_GuestID = $GuestID;
      $param_GuestName = $GuestName;
      $param_AadhaarNo = $AadharID;
      $param_Address = $Address;
      $param_Gender = $Gender;
      $param_PhoneNo = $Contact;
      $param_EmpID = $EmpID;
      $param_payBy = $PaymentBy;

      // Try to execute the query
      // If it executes successfully, redirect to login page
      if (mysqli_stmt_execute($stmt))
      {
        $sql2 = "INSERT INTO reserve (GuestID,RoomNo,ReservationStatus,CheckInDT,CheckOutDT,BookingDT) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt2 = mysqli_prepare($conn, $sql2);
        if ($stmt2)
        {
            mysqli_stmt_bind_param($stmt2, "ssssss", $param_GuestID, $param_RoomNo, $param_st,$param_cin,  $param_cout, $param_bookd );

            // Set these parameters
            $param_GuestID = $GuestID;
            $param_RoomNo = $RoomNo;
            $param_st = 1;
            $param_cin = $CheckInDT;
            $param_cout = $CheckOutDT;
            $param_bookd = $BookingDate;
      
            // Try to execute the query
            // If it executes successfully, redirect to login page
            if (mysqli_stmt_execute($stmt2))
            {
                $sql4 = "UPDATE roominfo SET Availability = 0 WHERE RoomNo = ? ";
                if($stmt4 = mysqli_prepare($conn, $sql4)){
                  mysqli_stmt_bind_param($stmt4, "s", $param_RoomNo);
                  $param_RoomNo = $RoomNo;
                  if(mysqli_stmt_execute($stmt4)){

                // Prepare a delete statement
                $sql3 = "DELETE FROM requesttable WHERE GuestName = ? AND AadhaarNo = ? AND Address = ? AND Gender = ? AND PhoneNo = ?";
    
                if($stmt3 = mysqli_prepare($conn, $sql3)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt3, "sssss", $param_GuestName, $param_AadhaarNo, $param_Address, $param_Gender, $param_PhoneNo);
        
                    // Set parameters
                    $param_GuestName = $GuestName;
                    $param_Gender = $Gender;
                    $param_AadhaarNo = $AadharID;
                    $param_Address = $Address;
                    $param_PhoneNo = $Contact;
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt3)){

                        echo '<script type="text/javascript">'; 
                        echo 'alert("Room successfully reserved");'; 
                        echo 'window.location.href = "admin_skReq.php";';
                        echo '</script>';
                    }
                }
            }}  
          }
        }        
      }
      // Otherwise, show alert
      else
      {
        echo '<script>alert("Something went wrong... cannot redirect!")</script>';
      }
      mysqli_stmt_close($stmt);
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
  <body style="background-color:paleturquoise">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="admin_home.php">Room_Booked_Details<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_skReq.php">Room_Booking_Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_RoomInfo.php">Room_Status(AV/NAV)</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_scheduler.php">Staff_Duty_Scheduler</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  <div class="navbar-collapse collapse">
  <ul class="navbar-nav ml-auto">
  <li class="nav-item active">
        <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome ". $_SESSION['AdmName']?></a>
      </li>
  </ul>
  </div>
  </div>
  </nav>

<div class="container mt-4">
<h3>Approve Reservation Request</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="inputEmpID4">Guest ID</label>
    <input type="text" class="form-control" name="GuestID" id="inputGuestID4" placeholder="Please enter Guest ID">
  </div>
  <div class="form-group">
    <label for="inputEmpID4">Room Number</label>
    <input type="Number" class="form-control" name="RoomNo" value="101" id="RoomNo">
  </div>
  
  <!-- EmpName -->
  <div class="form-group">
    <label for="inputEmpName">Guest Name</label>
    <input type="text" class="form-control" name="GuestName" id="inputGuestName" value="<?php echo trim($_GET["GuestName"]); ?>" readonly>
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-4">
      <label for="inputDoJ">Aadhar ID</label>
      <input type="text" class="form-control" name="AadharID" id="inputAadharID" value="<?php echo trim($_GET["AadhaarNo"]); ?>" readonly>
    </div>
    <!-- DoJ -->
    <div class="form-group col-md-4">
      <label for="inputDoJ">Address</label>
      <input type="text" class="form-control" name="Address" id="inputAddress" value="<?php echo trim($_GET["Address"]); ?>" readonly>
    </div>
    <!-- DoJ -->
    <div class="form-group col-md-4">
      <label for="inputDoJ">Gender</label>
      <input type="text" class="form-control" name="Gender" id="inputGender" value="<?php echo trim($_GET["Gender"]); ?>" readonly>
    </div>
  </div>
  <div class="form-row">
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">Contact</label>
      <input type="text" class="form-control" name="Contact" id="inputContact" value="<?php echo trim($_GET["PhoneNo"]); ?>" readonly>
    </div>
    <!-- email -->
    <div class="form-group col-md-6">
      <label for="inputEmail">Indenter ID</label>
      <input type="text" class="form-control" name="IndenterID" id="inputIndenterID" value="<?php echo trim($_GET["EmpID"]); ?>" readonly>
    </div>
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary">Approve Request</button>
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
