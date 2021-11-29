<?php
// Include config file
$server_name="localhost";
$username="root";
$password="";
$datbase_name="Landscape Related Services";
// connect to the database
$db = mysqli_connect($server_name, $username, $password, $datbase_name);

if(!$db)
{
    die("Connection Failed : ".mysqli_connection_error());
}

session_start();

if(isset($_POST["ENumber"]) && !empty(trim($_POST["ENumber"]))){
 
    // Get hidden input value
    $ENumber = trim($_POST["ENumber"]);

    // Prepare mysqli query
    $sql = "UPDATE EquipmentInfo SET Quantity = ? WHERE ENumber = ?";
    $stmt = mysqli_prepare($db, $sql);

    mysqli_stmt_bind_param($stmt, "ii", $param_Quantity, $param_ENumber);

    $param_Quantity = trim($_POST["Quantity"]);
    $param_ENumber = trim($_POST["ENumber"]);


    // Try to execute the query
    // If it executes successfully, redirect to profile page
    // where employee can view the UPDATED profile
    if (mysqli_stmt_execute($stmt))
    { 
      echo '<script type="text/javascript">'; 
      echo 'alert("Shop details updated successfully");'; 
      echo 'window.location.href = "LRS_AdminHomepart2.php";';
      echo '</script>';
    } 
    // Otherwise, show alert
    else 
    {
      echo '<script>alert("Could not update... try again!")</script>';
      echo  $db->error;
    }
}
else{
    // Check existence of id parameter before processing further
    if(isset($_GET["ENumber"]) && !empty(trim($_GET["ENumber"]))){
        // Get URL parameter
        $ENumber =  trim($_GET["ENumber"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM EquipmentInfo WHERE ENumber = ?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_ENumber);
            
            // Set parameters
            $param_ENumber = $ENumber;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
            
                    $ENumber = $row["ENumber"];
                    $EName = $row["EName"];
                    $Quantity = $row["Quantity"];
                    $InitialValuePerPiece = $row["InitialValuePerPiece"];
                   
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
        mysqli_close($db);
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

    <title>Landscape Related Services</title>
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
        <a class="nav-link" href="#">Update Equipment Quantity<span class="sr-only">(current)</span></a>
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
<h3>Update Equipment Quantity</h3>
<hr>
<!-- HTML form -->
<form action="" method="post">
  <!-- empID -->
  <div class="form-group">
    <label for="inputENumber4">Equipment Number</label>
    <input type="text" class="form-control" name="ENumber" id="inputENumber4" value="<?php echo $ENumber?>" readonly>
  </div>
  <!-- empName -->
  <div class="form-group">
    <label for="inputEName">Equipment Name</label>
    <input type="text" class="form-control" name="EName" id="inputEName" value="<?php echo $EName?>" readonly>
  </div>
  <div class="form-row">
    <!-- DoJ -->
    <div class="form-group col-md-6">
      <label for="inputQuantity">Quantity</label>
      <input type="text" class="form-control" name="Quantity" id="inputQuantity" value="<?php echo $Quantity?>">
    </div>
    <!-- salary -->
    <div class="form-group col-md-6">
      <label for="inputInitialValuePerPrice">Price Per Unit Value of Product</label>
      <input type="text" class="form-control" name="InitialValuePerPrice" id="inputInitialValuePerPrice" value="<?php echo $InitialValuePerPiece?>" readonly>
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
