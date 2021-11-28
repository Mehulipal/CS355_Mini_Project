<?php
// Include config.php
require_once "config.php";

// Declare variables
$SID = $CustomerName = $TotalAmount = $ItemsBought = $Score = "";
$SID_err = $Score_err = "";

// When POST request is made to register,
// perform the following actions
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  // Check if empID is empty
  if(empty(trim($_POST["SID"])))
  {
    $SID_err = "Shop ID cannot be blank";
  }
  else if(empty(trim($_POST["Score"])))
  {
    $Score_err = "Score cannot be blank";
  }
  else
  {
    // Prepare mysqli query to check if empID already exists in database 
    $sql = "SELECT SID FROM shop WHERE SID = ?";
    $stmt = mysqli_prepare($conn, $sql);
       
    if($stmt)
    {
      mysqli_stmt_bind_param($stmt, "s", $param_SID);

      // Set the value of param_empID
      $param_SID = trim($_POST['SID']);

      // Try to execute this statement
      if(mysqli_stmt_execute($stmt))
      {
        mysqli_stmt_store_result($stmt);

        // If empID already exists in database, set empID error
        if(mysqli_stmt_num_rows($stmt) == 0)
        {
          $SID_err = "This shop does not exist"; 
        }
        // Otherwise, set variable $empID
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

    if(trim($_POST["Score"]) >=1 && trim($_POST["Score"]) <= 5)
    {
        $Score = trim($_POST['Score']);
    }
    else
    {
        $Score_err = "Rating should be between 1 and 5";
    }
  }

  // Set the variables
  $CustomerName = trim($_POST['CustomerName']);
  $TotalAmount = trim($_POST['TotalAmount']);
  $ItemsBought = trim($_POST['ItemsBought']);
  
  // If there were no errors, go ahead and insert into the database
  if(empty($SID_err) && empty($Score_err))
  {
    // Prepare mysqli query
    $sql = "INSERT INTO feedback (SID, CustomerName, TotalAmount, ItemsBought, Score) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
      mysqli_stmt_bind_param($stmt, "isisi", $param_SID, $param_CustomerName, $param_TotalAmount, $param_ItemsBought, $param_Score);

      // Set these parameters
      $param_SID = $SID;
      $param_CustomerName = $CustomerName;
      $param_TotalAmount = $TotalAmount;
      $param_ItemsBought = $ItemsBought;
      $param_Score = $Score;
      
      // Try to execute the query
      // If it executes successfully, redirect to login page
      if (mysqli_stmt_execute($stmt))
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Your feedback submitted successfully!");'; 
        echo 'window.location.href = "admin_login.php";';
        echo '</script>';
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
    if(!empty($SID_err))
    {
      echo "<script>alert('$SID_err');</script>";
    }
    else if(!empty($Score_err))
    {
      echo "<script>alert('$Score_err');</script>";
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
  <body style="background-color:thistle">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Login</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="admin/admin_login.php">Login_as_Admin</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="shopkeeper/sk_login.php">Login_as_Shopkeeper</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Feedback<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
  </nav>

<div class="container mt-4">
<h3>Add Your Feedback</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="inputEmpID4">Shop ID</label>
    <input type="text" class="form-control" name="SID" id="inputSID4" placeholder="Please enter Shop ID">
  </div>
  <div class="form-group">
    <label for="inputEmpName">Rating</label>
    <input type="text" class="form-control" name="Score" id="inputScore" placeholder="Rate on a scale of 5">
  </div>
  <!-- passwd -->
  <div class="form-group">
      <label for="inputPassword4">Customer Name</label>
      <input type="text" class="form-control" name="CustomerName" id="inputCustomerName" placeholder="You may go anonymous too!">
    </div>
  <div class="form-row">  
    <!-- passwd -->
    <div class="form-group col-md-6">
      <label for="inputPassword4">Total Amount</label>
      <input type="text" class="form-control" name="TotalAmount" id="inputTotalAmount" placeholder="Amount (in rupees)">
    </div>
    <!-- confirm passwd -->
    <div class="form-group col-md-6">
      <label for="inputPassword4">Items Bought</label>
      <input type="text" class="form-control" name="ItemsBought" id="inputItemsBought" placeholder="Optional">
    </div>
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
