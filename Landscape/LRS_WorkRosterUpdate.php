<?php
// Include config.php
$server_name="localhost";
$username="root";
$password="";
$datbase_name="Landscape Related Services";
// connect to the database
$conn = mysqli_connect($server_name, $username, $password, $datbase_name);

if(!$conn)
{
    die("Connection Failed : ".mysqli_connection_error());
}
session_start();

// Declare variables
$HoursDone = $GID = $Shift = $KeyDate = $HoursAlloted = $LID = "";
// When POST request is made to register,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{ 
  $KeyDate = trim($_POST["KeyDate"]);
  $GID = trim($_POST["GID"]);
  $HoursDone = trim($_POST["HoursDone"]);
  $HoursAlloted = trim($_POST["HoursAlloted"]);
  $Shift = trim($_POST["Shift"]);
  $LID = trim($_POST["LID"]);

  $q = " UPDATE WorkRosterAndRecord SET HoursWorked = '$HoursDone' WHERE GID = '$GID' AND KeyDate = '$KeyDate' AND Shift = '$Shift' AND LID = '$LID' ";
  mysqli_query($conn, $q);
  $query = "SELECT * FROM WorkRosterAndRecord WHERE GID = '$GID' AND KeyDate = '$KeyDate' AND Shift = '$Shift' AND LID = '$LID' ";
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
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Landscape Related services</title>
  </head>
<body style="background-color:tan">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Landscape Related Services : Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Update Hours Done<span class="sr-only">(current)</span></a>
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
<h3>Update Hours Done</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="inputKeyDate4">KeyDate</label>
    <input type="text" class="form-control" name="KeyDate" id="inputKeyDate4" value="<?php echo trim($_GET["KeyDate"]);?>" readonly>
  </div>
  <!-- empName -->
  <div class="form-group">
    <label for="inputGID">GID</label>
    <input type="text" class="form-control" name="GID" id="inputGID" value="<?php echo trim($_GET["GID"]);?>" readonly>
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-6">
      <label for="inputLID">LID</label>
      <input type="text" class="form-control" name="LID" id="inputLID" value="<?php echo trim($_GET["LID"]);?>" readonly>
    </div>
    <!-- salary -->
    <div class="form-group col-md-6">
      <label for="Shift">Shift</label>
      <input type="text" class="form-control" name="Shift" id="inputShift" value="<?php echo trim($_GET["Shift"]);?>" readonly>
    </div>
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-6">
      <label for="inputHoursAlloted">Hours Alloted</label>
      <input type="text" class="form-control" name="HoursAlloted" id="inputHoursAlloted" value="<?php echo trim($_GET["HoursAlloted"]);?>" readonly>
    </div>
    <!-- salary -->
    <div class="form-group col-md-6">
      <label for="HoursDone">Hours Done</label>
      <input type="text" class="form-control" name="HoursDone" id="inputHoursDone" value="<?php echo trim($_GET["$HoursDone"]);?>">
    </div>
  </div>

  <!-- Update button -->
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