<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Landscape Related Services</title>
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
  <a class="navbar-brand" href="#">Landscape Related Services : Admin</a>
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
      <li class="nav-item active">
        <a class="nav-link" href="#">Equipment Details<span class="sr-only">(current)</span></a>
      </li>   
      <li class="nav-item">
        <a class="nav-link" href="EquipmentAdd.php">Add Equipment</a>
      </li>   
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  <div class="navbar-collapse collapse">
  <ul class="navbar-nav ml-auto">
  <li class="nav-item active">
        <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> <?php echo "Welcome ". $_SESSION['admID']?></a>
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
                        <h2 class="pull-left">Work Roster Details</h2>
                        <a href="EquipmentAdd.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Equipment</a>
                    </div>
                    <hr>
                    <?php
                    
                    // Attempt select query execution
                    $server_name="localhost";
                    $username="root";
                    $password="";
                    $datbase_name="Landscape Related Services";

                    $dbs = mysqli_connect($server_name, $username, $password, $datbase_name);
                    $sql = "SELECT * FROM EquipmentInfo";
                    if($result = mysqli_query($dbs, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ENumber</th>";
                                        echo "<th>Ename</th>";
                                        echo "<th>Quantity</th>";
                                        echo "<th>Price per Piece</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['ENumber'] . "</td>";
                                        echo "<td>" . $row['EName'] . "</td>";
                                        echo "<td>" . $row['Quantity'] . "</td>";
                                        echo "<td>" . $row['InitialValuePerPiece'] . "</td>";
                                        echo "<td>";
                                            //echo '<a href="LRSEquip_Read.php?SID='. $row['SID'] .'" class="mr-3" title="View Shop" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="LRS_EquipUpdate.php?ENumber='. $row['ENumber'] .'" class="mr-3" title="Update Equipment Quantity" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            //echo '<a href="admin_shopDelete.php?SID='. $row['SID'] .'" title="Delete Shop" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>Work Roster is Empty.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($dbs);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>