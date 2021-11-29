<?php
// Include config.php
require_once "config.php";
session_start();

// Declare variables
$hrsWorked = $StaffID = $ShiftID = $KeyDate = $HoursAllocated = "";
// When POST request is made to register,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  $hrsWorked = trim($_POST["HoursWorked"]);
  $StaffID = trim($_POST["StaffID"]);
  $ShiftID = trim($_POST["ShiftID"]);
  $KeyDate = trim($_POST["KeyDate"]);

  $q = " UPDATE shiftdetails SET HoursWorked = '$hrsWorked' WHERE StaffID = '$StaffID' AND KeyDate = '$KeyDate' AND ShiftID = '$ShiftID' ";
  mysqli_query($conn, $q);
  $query = "SELECT * FROM shiftdetails WHERE StaffID = '$StaffID' AND KeyDate = '$KeyDate' AND ShiftID = '$ShiftID' ";
  $results = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($results);
  if (mysqli_num_rows($results) == 1) {
    echo '<script type="text/javascript">'; 
    echo 'alert("Hours Worked Successfully updated");'; 
    echo 'window.location.href = "admin_scheduler.php";';
    echo '</script>';
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
<h3>Update Staff Working Hourse</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-row">
  <div class="form-group col-md-4">
    <label for="inputStaffID4">Staff ID</label>
    <input type="text" class="form-control" name="StaffID" id="inputStaffID4" value="<?php echo trim($_GET["StaffID"]); ?>" readonly>
  </div>
  <div class="form-group col-md-4">
    <label for="inputShiftID4">Shift ID</label>
    <input type="text" class="form-control" name="ShiftID" id="ShiftID" value="<?php echo trim($_GET["ShiftID"]); ?>" readonly>
  </div>
  <div class="form-group col-md-4">
    <label for="inputKeyDate4">Scheduled Date</label>
    <input type="text" class="form-control" name="KeyDate" id="KeyDate" value="<?php echo trim($_GET["KeyDate"]); ?>" readonly>
  </div>
</div>
 <div class="form-row"> 
  <!-- EmpName -->
  <div class="form-group col-md-4">
    <label for="inputName">Staff Name</label>
    <input type="text" class="form-control" name="Name" id="inputName" value="<?php echo trim($_GET["Name"]); ?>" readonly>
  </div>
    <!-- DoJ -->
    <div class="form-group col-md-4">
      <label for="inputHoursAllocated">Hours Alloted</label>
      <input type="text" class="form-control" name="HoursAllocated" id="inputHoursAllocated" value="<?php echo trim($_GET["HoursAllocated"]); ?>" readonly>
    </div>
    <div class="form-group col-md-4">
      <label for="inputHoursWorked">Hours Worked</label>
      <input type="text" class="form-control" name="HoursWorked" id="inputHoursWorked" value="<?php echo trim($_GET["HoursWorked"]); ?>" >
    </div>
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary">Update Details</button>
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
