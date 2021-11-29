<?php
require_once "config.php";
session_start();
    if(isset($_POST['save']))
    {
    
       
        $KeyDate = $_POST['KeyDate'];
        $ShiftID = $_POST['ShiftID'];
        $StaffID = $_POST['StaffID'];
        $HoursAllocated = $_POST['HoursAllocated'];
        $HoursDone = 0;
        

        $sql_query= "INSERT INTO shiftDetails VALUES('$ShiftID', '$StaffID', '$KeyDate', '$HoursAllocated', '$HoursDone')";


        if(mysqli_query($conn, $sql_query))
        {
            echo '<script type="text/javascript">'; 
            echo 'alert("Staff Duty Scheduled successfully");'; 
            echo 'window.location.href = "admin_scheduler.php";';
            echo '</script>';
        }
        else
        {
            echo "Error : ".$sql." ". mysqli_error($conn);
        }
        mysqli_close($conn);


    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guest House related services</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 1000px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 250px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
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
<h3>Scheduler</h3>
<hr>
<hr>
<!-- HTML form -->
<form action=" " method="post">
  <!-- empID -->
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputKeyDate">Scheduled Date</label>
      <input type="date" class="form-control" name="KeyDate" id="inputKeyDate" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputShiftID">Shift</label>
      <input type="text" class="form-control" name="ShiftID" id="inputShiftID" placeholder="Enter 1/2/3(i.e. M/A/E)" required>
    </div>
    </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputStaffID">Staff ID</label>
      <input type="text" class="form-control" name="StaffID" id="inputStaffID" placeholder="Enter staff id" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputHoursAllocated">Hours Allocated</label>
      <input type="text" class="form-control" name="HoursAllocated" id="inputHoursAllocated" placeholder="Hours Allocated">
    </div>
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary" name="save">Submit Request</button>
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
