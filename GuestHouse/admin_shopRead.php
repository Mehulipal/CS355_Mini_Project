<?php
 require_once "config.php";
 session_start();
// Check if the employee is already logged in
// If not, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
  header("location: admin_login.php");
}

// Check existence of id parameter before processing further
if(isset($_GET["GuestID"]) && !empty(trim($_GET["GuestID"]))){
   
    // Prepare a select statement
    $sql = "SELECT * FROM guestinfo WHERE GuestID = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_GuestID);
        
        // Set parameters
        $param_GuestID = trim($_GET["GuestID"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
    
            if(mysqli_stmt_num_rows($stmt) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                mysqli_stmt_bind_result($stmt, $GuestID, $GuestName, $EmpID, $PhoneNo, $AdhaarNo, $Address, $Gender, $PayBy);
                mysqli_stmt_fetch($stmt);
                
                // Retrieve individual field value
                $_SESSION["GuestID"] = $GuestID;
                $_SESSION["GuestName"] = $GuestName;
                $_SESSION["EmpID"] = $EmpID;
                $_SESSION["PhoneNo"] = $PhoneNo;
                $_SESSION["AdhaarNo"] = $AdhaarNo;
                $_SESSION["Address"] = $Address;
                $_SESSION["Gender"] = $Gender;
                $_SESSION["PayBy"] = $PayBy;
            } else{
                echo '<script>alert("Could not fetch guest details")</script>';
            }
            
        } else{
            echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
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

    <title>Guest house related services</title>
  </head>
  <body style="background-color:palevioletred">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Room_Booked_Details<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_skReq.php">Room_Booking_Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_skReq.php">Room_Status(AV/NAV)</a>
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
<h3>View Guest Details</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-row">
  <div class="form-group col-md-6">
    <label for="inputEmpID4">Guest ID</label>
    <input type="text" class="form-control" name="sID" id="inputSID4" value="<?php echo $_SESSION['GuestID']?>" readonly>
  </div>
  <!-- empName -->
  <div class="form-group col-md-6">
    <label for="inputEmpName">Guest Name</label>
    <input type="text" class="form-control" name="sName" id="inputSName" value="<?php echo $_SESSION['GuestName']?>" readonly>
  </div>
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-6">
      <label for="inputDoJ">Indenter Id</label>
      <input type="text" class="form-control" name="ownerName" id="inputOwnerName" value="<?php echo $_SESSION['EmpID']?>" readonly>
    </div>
    <!-- salary -->
    <div class="form-group col-md-6">
      <label for="inputSalary">Contact</label>
      <input type="text" class="form-control" name="contact" id="inputContact" value="<?php echo $_SESSION['PhoneNo']?>" readonly>
    </div>
  </div>
 
    <div class="form-group">
      <label for="inputDept">Adhaar Number</label>
      <input type="text" class="form-control" name="location" id="inputLocation" value="<?php echo $_SESSION['AdhaarNo']?>" readonly>
    </div>
    <!-- mobileNo -->
    <div class="form-group ">
      <label for="inputMobile">Address</label>
      <input type="text" class="form-control" name="area" id="inputArea" value="<?php echo $_SESSION['Address']?>" readonly>
    </div>
  <div class="form-row">
    <!-- department -->
    <div class="form-group col-md-6">
      <label for="inputDept">Gender</label>
      <input type="text" class="form-control" name="lpStartDate" id="inputlpStartDate" value="<?php echo $_SESSION['Gender']?>" readonly>
    </div> 
    <div class="form-group col-md-6">
      <label for="inputDept">Payment By</label>
      <input type="text" class="form-control" name="PayBy" id="inputpayby" value="<?php echo $_SESSION['PayBy']?>" readonly>
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
