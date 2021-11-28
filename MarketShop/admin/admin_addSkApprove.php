<?php
// Include config.php
require_once (dirname(__FILE__)."/../config.php");
session_start();

// Declare variables
$SID = $SkID = $passwd = $confirm_passwd = $SkName = $AadharID = $Address = $Gender = $SecurityPassExp = $Contact = "";
$SID_err = $SkID_err = $passwd_err = $confirm_passwd_err = "";

// When POST request is made to register,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  // Check if empID is empty
  if(empty(trim($_POST["SkID"])))
  {
    $SkID_err = "Shopkeeper ID cannot be blank";
  }
  else
  {
    // Prepare mysqli query to check if empID already exists in database 
    $sql = "SELECT SkID FROM shopkeeper WHERE SkID = ?";
    $stmt = mysqli_prepare($conn, $sql);
       
    if($stmt)
    {
      mysqli_stmt_bind_param($stmt, "s", $param_SkID);

      // Set the value of param_empID
      $param_SkID = trim($_POST['SkID']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt))
      {
        mysqli_stmt_store_result($stmt);

        // If empID already exists in database, set empID error
        if(mysqli_stmt_num_rows($stmt) == 1)
        {
          $SkID_err = "This Shopkeeper ID already exists"; 
        }
        // Otherwise, set variable $empID
        else
        {
          $SkID = trim($_POST['SkID']);
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

  // Check for password
  // Check if password is empty
  if(empty(trim($_POST['passwd'])))
  {
    $passwd_err = "Password cannot be blank";
  }
  // Check if password is less than 5 characters
  elseif(strlen(trim($_POST['passwd'])) < 5)
  {
    $passwd_err = "Password cannot be less than 5 characters";
  }
  // Otherwise, set variable $passwd
  else
  {
    $passwd = trim($_POST['passwd']);
  }

  // Check for confirm password field
  // If password doesn't match confirm password, set password error
  if(trim($_POST['passwd']) !=  trim($_POST['confirm_passwd']))
  {
    $passwd_err = "Passwords should match";
  }

  // Check if email is empty
  if(empty(trim($_POST["SID"])))
  {
    $SID_err = "Shop ID cannot be blank";
  }
  else
  {
    // Prepare mysqli query to check if email already exists in database
    $sql = "SELECT SID FROM shop WHERE SID = ?";
    $stmt = mysqli_prepare($conn, $sql);
  
    if($stmt)
    {
      mysqli_stmt_bind_param($stmt, "s", $param_SID);

      // Set the value of param email
      $param_SID = trim($_POST['SID']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt))
      {
        mysqli_stmt_store_result($stmt);

        // If email already exists in database, set email error
        if(mysqli_stmt_num_rows($stmt) == 0)
        {
          $SID_err = "This shop does not exist"; 
        }
        // Otherwise, set variable $email
        else
        {
          $SID = trim($_POST['SID']);
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
  $SkName = trim($_POST['SkName']);
  $AadharID = trim($_POST['AadharID']);
  $Address = trim($_POST['Address']);
  $Gender = trim($_POST['Gender']);
  $SecurityPassExp = trim($_POST['SecurityPassExp']);
  $Contact = trim($_POST['Contact']);

  // If there were no errors, go ahead and insert into the database
  if(empty($SkID_err) && empty($passwd_err) && empty($confirm_passwd_err) && empty($SID_err))
  {
    // Prepare mysqli query
    $sql = "INSERT INTO shopkeeper (SkID, Password, SkName, AadharID, Address, Gender, SecurityPassExp, Contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
      mysqli_stmt_bind_param($stmt, "isssssss", $param_SkID, $param_Password, $param_SkName, $param_AadharID, $param_Address, $param_Gender, $param_SecurityPassExp, $param_Contact);

      // Set these parameters
      $param_SkID = $SkID;
      $param_Password = sha1($passwd);
      $param_SkName = $SkName;
      $param_AadharID = $AadharID;
      $param_Address = $Address;
      $param_Gender = $Gender;
      $param_SecurityPassExp = $SecurityPassExp;
      $param_Contact = $Contact;

      // Try to execute the query
      // If it executes successfully, redirect to login page
      if (mysqli_stmt_execute($stmt))
      {
        $sql2 = "INSERT INTO association (SID, SkID) VALUES (?, ?)";
        $stmt2 = mysqli_prepare($conn, $sql2);
        if ($stmt2)
        {
            mysqli_stmt_bind_param($stmt2, "ii", $param_SID, $param_SkID);

            // Set these parameters
            $param_SID = $SID;
            $param_SkID = $SkID;
      
            // Try to execute the query
            // If it executes successfully, redirect to login page
            if (mysqli_stmt_execute($stmt2))
            {
                // Prepare a delete statement
                $sql3 = "DELETE FROM request_add_sk WHERE _SkName = ? AND _AadharID = ? AND _Address = ? AND _Gender = ? AND _Contact = ? AND _SID = ?";
    
                if($stmt3 = mysqli_prepare($conn, $sql3)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt3, "sssssi", $param_SkName, $param_AadharID, $param_Address, $param_Gender, $param_Contact, $param_SID);
        
                    // Set parameters
                    $param_SkName = $SkName;
                    $param_AadharID = $AadharID;
                    $param_Address = $Address;
                    $param_Gender = $Gender;
                    $param_Contact = $Contact;
                    $param_SID = $SID;
        
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt3)){

                        echo '<script type="text/javascript">'; 
                        echo 'alert("Shopkeeper successfully added");'; 
                        echo 'window.location.href = "admin_skReq.php";';
                        echo '</script>';
                    }
                }
            }
        }        
      }
      // Otherwise, show alert
      else
      {
        echo '<script>alert("Something went wrong... cannot redirect!")</script>';
      }
    }
    mysqli_stmt_close($stmt);
  }
  // Incase of errors, registration fails and alerts are shown 
  else
  {
    if(!empty($SkID_err))
    {
      echo "<script>alert('$SkID_err');</script>";
    }
    else if(!empty($passwd_err))
    {
      echo "<script>alert('$passwd_err');</script>";
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

    <title>Market Shop related services</title>
  </head>
  <body style="background-color:paleturquoise">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="admin_home.php">Shop_Details</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Add_Shopkeeper_Requests<span class="sr-only">(current)</span></a>
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
<h3>Approve Add Shopkeeper Request</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="inputEmpID4">Shopkeeper ID</label>
    <input type="text" class="form-control" name="SkID" id="inputSkID4" placeholder="Please enter Shopkeeper ID">
  </div>
  <div class="form-group">
    <label for="inputEmpID4">Security Pass Expiry Date</label>
    <input type="date" class="form-control" name="SecurityPassExp" id="inputSecurityPassExp">
  </div>
  <div class="form-row">  
    <!-- passwd -->
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" name="passwd" id="inputPassword4" placeholder="Password">
    </div>
    <!-- confirm passwd -->
    <div class="form-group col-md-6">
      <label for="inputPassword4">Confirm Password</label>
      <input type="password" class="form-control" name="confirm_passwd" id="inputPassword" placeholder="Confirm Password">
    </div>
  </div>
  <!-- EmpName -->
  <div class="form-group">
    <label for="inputEmpName">Shopkeeper Name</label>
    <input type="text" class="form-control" name="SkName" id="inputSkName" value="<?php echo trim($_GET["SkName"]); ?>" readonly>
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-4">
      <label for="inputDoJ">Aadhar ID</label>
      <input type="text" class="form-control" name="AadharID" id="inputAadharID" value="<?php echo trim($_GET["AadharID"]); ?>" readonly>
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
      <input type="text" class="form-control" name="Contact" id="inputContact" value="<?php echo trim($_GET["Contact"]); ?>" readonly>
    </div>
    <!-- email -->
    <div class="form-group col-md-6">
      <label for="inputEmail">Shop ID</label>
      <input type="text" class="form-control" name="SID" id="inputSID" value="<?php echo trim($_GET["SID"]); ?>" readonly>
    </div>
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary">Add Shopkeeper</button>
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
