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
            width: 1500px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 50px;
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
  <a class="navbar-brand" href="#">Shopkeeper</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
      <li class="nav-item">
        <a class="nav-link" href="sk_home.php">Profile</a>
      <li class="nav-item">
        <a class="nav-link" href="sk_myShop.php">My_Shop</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_addSk.php">Add_Shopkeeper</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="sk_rentStat.php">Rent_Status</a>
      </li>
      </li>
        <a class="nav-link" href="#">Electricity_Bill_Status<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../logout.php">Logout</a>
      </li>
    </ul>
  <div class="navbar-collapse collapse">
  <ul class="navbar-nav ml-auto">
  <li class="nav-item active">
        <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome ". $_SESSION['SkName']?></a>
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
                        <h2 class="pull-left">Annual Electricity Bill Status</h2>
                        <a href="sk_payElecBill.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Pay Electricity Bill</a>
                    </div>
                    <hr>
                    <?php
                    
                    // Attempt select query execution
                    $SkID = $_SESSION['SkID'];
                    $sql = "SELECT * FROM annual_elec_bill WHERE SID = (SELECT SID FROM association WHERE SkID = $SkID)";
                    if($result = mysqli_query($conn, $sql)){
                        
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Academic Yr</th>";
                                        echo "<th>Shop ID</th>";
                                        echo "<th>Jan</th>";
                                        echo "<th>Feb</th>";
                                        echo "<th>Mar</th>";
                                        echo "<th>Apr</th>";
                                        echo "<th>May</th>";
                                        echo "<th>Jun</th>";
                                        echo "<th>Jul</th>";
                                        echo "<th>Aug</th>";
                                        echo "<th>Sep</th>";
                                        echo "<th>Oct</th>";
                                        echo "<th>Nov</th>";
                                        echo "<th>Dec</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['AcademicYr'] . "</td>";
                                        echo "<td>" . $row['SID'] . "</td>";
                                        if($row['JanStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['FebStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['MarStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['AprStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['MayStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['JunStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['JulStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['AugStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['SepStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['OctStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['NovStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                        if($row['DecStat'] == 1)
                                          echo "<td>Paid</td>";
                                        else
                                          echo "<td>Unpaid</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
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