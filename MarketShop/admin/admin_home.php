<?php
require_once (dirname(__FILE__)."/../config.php");
session_start();
// Check if the employee is already logged in
// If not, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
  header("location: admin_login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Market Shop related services</title>
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

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Shop Details</h2>
                        <a href="admin_shopCreate.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Shop</a>
                    </div>
                    <hr>
                    <?php
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM shop";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Shop ID</th>";
                                        echo "<th>Shop Name</th>";
                                        echo "<th>Owner Name</th>";
                                        echo "<th>Actions</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['SID'] . "</td>";
                                        echo "<td>" . $row['SName'] . "</td>";
                                        echo "<td>" . $row['OwnerName'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="admin_shopRead.php?SID='. $row['SID'] .'" class="mr-3" title="View Shop" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="admin_shopUpdate.php?SID='. $row['SID'] .'" class="mr-3" title="Update Shop" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="admin_shopDelete.php?SID='. $row['SID'] .'" title="Delete Shop" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No shops were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>