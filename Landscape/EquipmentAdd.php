<?php
    // receive all input values from the form
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

    if(isset($_POST['save']))
    {
    
        $ENumber = $_POST['ENumber'];
        $EName = $_POST['EName'];
        $Quantity = $_POST['Quantity'];
        $InitialValuePerPiece = $_POST['InitialValuePerPiece'];
        
        

        $sql_query= "INSERT INTO EquipmentInfo(ENumber, EName, Quantity, InitialValuePerPiece) VALUES('$ENumber','$EName','$Quantity', '$InitialValuePerPiece')";


        if(mysqli_query($db, $sql_query))
        {
            echo '<script type="text/javascript">'; 
            echo 'alert("Equipment successfully added");'; 
            echo 'window.location.href = "LRS_AdminHomepart2.php";';
            echo '</script>';
        }
        else
        {
            echo "Error : ".$sql." ". mysqli_error($db);
        }
        mysqli_close($db);


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

    <title>Add Equipment</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Landscape Related Services</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            
        <li class="nav-item">
        <a class="nav-link" href="LRS_AdminHome.php">Work Roster Details</a>
        </li>
      
      <li class="nav-item">
        <a class="nav-link" href="WorkRosterAdd.php">Work Allocation</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="LRS_EquipmentDetails.php">Equipment Details</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Add Equipment<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
          </ul>
        </div>
      </nav>

<div class="container mt-4">
<h3>Add Equipment</h3>
<hr>
<hr>
<!-- HTML form -->
<form action=" " method="post">
  <!-- empID -->
  <div class="form-group">
      <label for="inputEName">Equipment Number</label>
      <input type="text" class="form-control" name="ENumber" id="inputENumber" placeholder="Equipment Number">
    </div>
    <div class="form-group">
      <label for="inputEName">Equipment Name</label>
      <input type="text" class="form-control" name="EName" id="inputEName" placeholder="Equipment Name">
    </div>
  <div class="form-group">
    <label for="inputQuantity">Quantity</label>
    <input type="text" class="form-control" name="Quantity" id="inputQuantity" placeholder="Quantity">
  </div>
  <div class="form-group">
    <label for="inputInitialValuePerPiece">Price per Unit Value of Product</label>
    <input type="text" class="form-control" name="InitialValuePerPiece" id="inputInitialValuePerPiece" placeholder="Price">
  </div>
  
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary" name="save">Add Equipment</button>
</form>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
