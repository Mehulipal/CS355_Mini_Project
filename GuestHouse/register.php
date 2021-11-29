<?php
// Include config.php
require_once "config.php";

// Declare variables
$empID = $passwd = $confirm_passwd = "";
$empID_err = $passwd_err = $confirm_passwd_err = $email_err = $mobileNo_err = "";
$empName = $DoJ = $salary = $department = $mobileNo = $email = $designation = "";

// When POST request is made to register,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  // Check if empID is empty
  if(empty(trim($_POST["empID"])))
  {
    $empID_err = "Employee ID cannot be blank";
  }
  else
  {
    // Prepare mysqli query to check if empID already exists in database 
    $sql = "SELECT EmpID FROM emp WHERE EmpID = ?";
    $stmt = mysqli_prepare($conn, $sql);
       
    if($stmt)
    {
      mysqli_stmt_bind_param($stmt, "s", $param_empID);

      // Set the value of param_empID
      $param_empID = trim($_POST['empID']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt))
      {
        mysqli_stmt_store_result($stmt);

        // If empID already exists in database, set empID error
        if(mysqli_stmt_num_rows($stmt) == 1)
        {
          $empID_err = "This Employee ID already exists"; 
        }
        // Otherwise, set variable $empID
        else
        {
          $empID = trim($_POST['empID']);
        }
      }
      // Incase mysqli query fails to execute, show alert 
      else
      {
        echo '<script>alert("Something went wrong4")</script>';
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
  elseif(strlen(trim($_POST['passwd'])) < 3)
  {
    $passwd_err = "Password cannot be less than 3 characters";
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
  if(empty(trim($_POST["email"])))
  {
    $email_err = "Email cannot be blank";
  }
  else
  {
    // Prepare mysqli query to check if email already exists in database
    $sql = "SELECT EmpID FROM emp WHERE Email = ?";
    $stmt = mysqli_prepare($conn, $sql);
  
    if($stmt)
    {
      mysqli_stmt_bind_param($stmt, "s", $param_email);

      // Set the value of param email
      $param_email = trim($_POST['email']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt))
      {
        mysqli_stmt_store_result($stmt);

        // If email already exists in database, set email error
        if(mysqli_stmt_num_rows($stmt) == 1)
        {
          $email_err = "This Email ID already exists"; 
        }
        // Otherwise, set variable $email
        else
        {
          $email = trim($_POST['email']);
        }
      }
      // Incase mysqli query fails to execute, show alert
      else
      {
        echo '<script>alert("Something went wrong3")</script>';
      }
    }
    mysqli_stmt_close($stmt);
  }

  // Check if mobileNo is empty
  if(empty(trim($_POST["mobileNo"])))
  {
    $mobileNo_err = "Mobile Number cannot be blank";
  }
  else
  {
    // Prepare mysqli query to check if mobileNo already exists in database
    $sql = "SELECT EmpID FROM emp WHERE PhoneNo = ?";
    $stmt = mysqli_prepare($conn, $sql);
  
    if($stmt)
    {
      mysqli_stmt_bind_param($stmt, "i", $param_mobileNo);

      // Set the value of param mobileNo
      $param_mobileNo = trim($_POST['mobileNo']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt))
      {
        mysqli_stmt_store_result($stmt);

        // If mobileNo already exists in database, set mobileNo error
        if(mysqli_stmt_num_rows($stmt) == 1)
        {
          $mobileNo_err = "This Mobile Number already exists"; 
        }
        // Otherwise, set variable $mobileNo
        else
        {
          $mobileNo = trim($_POST['mobileNo']);
        }
      }
      // Incase mysqli query fails to execute, show alert
      else
      {
        echo '<script>alert("Something went wrong2")</script>';
      }
    }
    mysqli_stmt_close($stmt);
  }

  // Set the variables
  $empName = trim($_POST['empName']);
  $designation = trim($_POST['designation']);
  $department = trim($_POST['department']);

  // If there were no errors, go ahead and insert into the database
  if(empty($empID_err) && empty($passwd_err) && empty($confirm_passwd_err) && empty($email_err) && empty($mobileNo_err))
  {
    // Prepare mysqli query
    $sql = "INSERT INTO emp (EmpID, Name, Department, Designation, PhoneNo, Email, Password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
      mysqli_stmt_bind_param($stmt, "sssssss", $param_empID, $param_name, $param_department, $param_designation, $param_mobileNo, $param_email, $param_passwd);

      // Set these parameters
      $param_empID = $empID;
      $param_passwd = sha1($passwd);
      $param_name = $empName;
      $param_designation = $designation;
      $param_department = $department;
      $param_mobileNo = $mobileNo;
      $param_email = $email;

      // Try to execute the query
      // If it executes successfully, redirect to login page
      echo '<script>alert("Hiii!")</script>';
      if (mysqli_stmt_execute($stmt))
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Employee successfully registered");'; 
        echo 'window.location.href = "sk_login.php";';
        echo '</script>';
      }
      // Otherwise, show alert
      else
      {
        echo '<script>alert("Something went wrong1... cannot redirect!")</script>';
      }
    }
    mysqli_stmt_close($stmt);
  }
  // Incase of errors, registration fails and alerts are shown 
  else
  {
    if(!empty($empID_err))
    {
      echo "<script>alert('$empID_err');</script>";
    }
    else if(!empty($passwd_err))
    {
      echo "<script>alert('$passwd_err');</script>";
    }
    else if(!empty($mobileNo_err))
    {
      echo "<script>alert('$mobileNo_err');</script>";
    }
    else if(!empty($email_err))
    {
      echo "<script>alert('$email_err');</script>";
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
  <body style="background-color:lightsteelblue">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Login</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="admin_login.php">Login_as_Admin<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Register_as_User</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_login.php">Login_as_User</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>


<div class="container mt-4">
<h3>Please Register Here:</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="inputEmpID4">Employee ID</label>
    <input type="text" class="form-control" name="empID" id="inputEmpID4" placeholder="Employee ID">
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
    <label for="inputEmpName">Employee Name</label>
    <input type="text" class="form-control" name="empName" id="inputEmpName" placeholder="Please Enter Full Name">
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-4">
      <label for="inputDept">Department</label>
      <input type="text" class="form-control" name="department" id="inputDept">
    </div>
    <!-- salary -->
    <div class="form-group col-md-4">
      <label for="inputDesign">Designation</label>
      <input type="text" class="form-control" name="designation" id="inputDesign">
    </div>
  </div>
  <div class="form-row">
    <!-- mobileNo -->
    <div class="form-group col-md-6">
      <label for="inputMobile">Mobile Number</label>
      <input type="text" class="form-control" name="mobileNo" id="inputMobile" placeholder="Mobile No" title="Mobile no should be of 10 digits" pattern="[1-9]{1}[0-9]{9}">
    </div>
    <!-- email -->
    <div class="form-group col-md-6">
      <label for="inputEmail">Email</label>
      <input type="text" class="form-control" name="email" id="inputEmail" placeholder="Email" title="Invalid Email ID" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
    </div>
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary">Sign Up</button>
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
