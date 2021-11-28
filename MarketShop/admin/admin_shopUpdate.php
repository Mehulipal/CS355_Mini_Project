<?php
// Include config file
require_once (dirname(__FILE__)."/../config.php");
session_start();

if(isset($_POST["SID"]) && !empty(trim($_POST["SID"]))){
 
    // Get hidden input value
    $SID = trim($_POST["SID"]);

    // Prepare mysqli query
    $sql = "UPDATE shop SET SName = ?, OwnerName = ?, Contact = ?, Location = ?, Area = ?, LP_StartDate = ?, LP_ExpiryDate = ?, LicensePeriod = ?, ExtensionPeriod = ? WHERE SID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssssissiii", $param_SName, $param_OwnerName, $param_Contact, $param_Location, $param_Area, $param_LP_StartDate, $param_LP_ExpiryDate, $param_LicensePeriod, $param_ExpiryPeriod, $param_SID);

    $param_SName = trim($_POST["SName"]);
    $param_OwnerName = trim($_POST["OwnerName"]);
    $param_Contact = trim($_POST["Contact"]);
    $param_Location = trim($_POST["Location"]);
    $param_Area = trim($_POST["Area"]);
    $param_LP_StartDate = trim($_POST["LP_StartDate"]);
    $param_LP_ExpiryDate = trim($_POST["LP_ExpiryDate"]);
    $param_LicensePeriod = trim($_POST["LicensePeriod"]);
    $param_ExpiryPeriod = trim($_POST["ExtensionPeriod"]);
    $param_SID = trim($_POST["SID"]);

    // Try to execute the query
    // If it executes successfully, redirect to profile page
    // where employee can view the UPDATED profile
    if (mysqli_stmt_execute($stmt))
    { 
      echo '<script type="text/javascript">'; 
      echo 'alert("Shop details updated successfully");'; 
      echo 'window.location.href = "admin_home.php";';
      echo '</script>';
    } 
    // Otherwise, show alert
    else 
    {
      echo '<script>alert("Could not update... try again!")</script>';
      echo  $conn->error;
    }
}
else{
    // Check existence of id parameter before processing further
    if(isset($_GET["SID"]) && !empty(trim($_GET["SID"]))){
        // Get URL parameter
        $SID =  trim($_GET["SID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM shop WHERE SID = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_SID);
            
            // Set parameters
            $param_SID = $SID;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $SID = $row["SID"];
                    $SName = $row["SName"];
                    $OwnerName = $row["OwnerName"];
                    $Contact = $row["Contact"];
                    $Location = $row["Location"];
                    $Area = $row["Area"];
                    $LP_StartDate = $row["LP_StartDate"];
                    $LP_ExpiryDate = $row["LP_ExpiryDate"];
                    $LicensePeriod = $row["LicensePeriod"];
                    $ExtensionPeriod = $row["ExtensionPeriod"];
                } else{
                    echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
                }
                
            } else{
                echo '<script>alert("Could not update shop details")</script>';
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($conn);
    }  else{
        echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
    }
}
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Market Shop related services</title>
  </head>
<body style="background-color:tan">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Shop_Details<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_skReq.php">Add_Shopkeeper_Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_rentReq.php">Rent_Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin_elecBillReq.php">Electricity_Bill_Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../logout.php">Logout</a>
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
<h3>Update Shop Details</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="inputEmpID4">Shop ID</label>
    <input type="text" class="form-control" name="SID" id="inputSID4" value="<?php echo $SID?>" readonly>
  </div>
  <!-- empName -->
  <div class="form-group">
    <label for="inputEmpName">Shop Name</label>
    <input type="text" class="form-control" name="SName" id="inputSName" value="<?php echo $SName?>">
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-6">
      <label for="inputDoJ">Owner Name</label>
      <input type="text" class="form-control" name="OwnerName" id="inputOwnerName" value="<?php echo $OwnerName?>">
    </div>
    <!-- salary -->
    <div class="form-group col-md-6">
      <label for="inputSalary">Contact</label>
      <input type="text" class="form-control" name="Contact" id="inputContact" value="<?php echo $Contact?>">
    </div>
  </div>
  <div class="form-row">
    <!-- department -->
    <div class="form-group col-md-6">
      <label for="inputDept">Location</label>
      <input type="text" class="form-control" name="Location" id="inputLocation" value="<?php echo $Location?>">
    </div>
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">Area</label>
      <input type="text" class="form-control" name="Area" id="inputArea" value="<?php echo $Area?>">
    </div>
  </div>
  <div class="form-row">
    <!-- department -->
    <div class="form-group col-md-6">
      <label for="inputDept">License Period Start Date</label>
      <input type="date" class="form-control" name="LP_StartDate" id="inputlpStartDate" value="<?php echo $LP_StartDate?>">
    </div>
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">License Period Expiry Date</label>
      <input type="date" class="form-control" name="LP_ExpiryDate" id="inputlpExpiryDate" value="<?php echo $LP_ExpiryDate?>">
    </div>
  </div>
  <div class="form-row">
    <!-- department -->
    <div class="form-group col-md-6">
      <label for="inputDept">Licence Period</label>
      <input type="text" class="form-control" name="LicensePeriod" id="inputLicensePeriod" value="<?php echo $LicensePeriod?>">
    </div>
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">Extension Period</label>
      <input type="text" class="form-control" name="ExtensionPeriod" id="inputExtensionPeriod" value="<?php echo $ExtensionPeriod?>">
    </div>
  </div>
  <!-- Update button -->
  <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>

</body>

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
