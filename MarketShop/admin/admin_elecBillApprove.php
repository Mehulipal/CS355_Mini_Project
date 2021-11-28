<?php
// Process delete operation after confirmation
if(isset($_POST["SID"]) && !empty($_POST["SID"])){
    // Include config file
    require_once (dirname(__FILE__)."/../config.php");
    
    // Prepare an update statement
    if(trim($_POST["PayForWhichMonth"]) == 1)
        $sql = "UPDATE annual_elec_bill SET JanStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 2)
        $sql = "UPDATE annual_elec_bill SET FebStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 3)
        $sql = "UPDATE annual_elec_bill SET MarStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 4)
        $sql = "UPDATE annual_elec_bill SET AprStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 5)
        $sql = "UPDATE annual_elec_bill SET MayStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 6)
        $sql = "UPDATE annual_elec_bill SET JunStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 7)
        $sql = "UPDATE annual_elec_bill SET JulStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 8)
        $sql = "UPDATE annual_elec_bill SET AugStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 9)
        $sql = "UPDATE annual_elec_bill SET SepStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 10)
        $sql = "UPDATE annual_elec_bill SET OctStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 11)
        $sql = "UPDATE annual_elec_bill SET NovStat = 1 WHERE AcademicYr = ? AND SID = ?";
    else if(trim($_POST["PayForWhichMonth"]) == 12)
        $sql = "UPDATE annual_elec_bill SET DecStat = 1 WHERE AcademicYr = ? AND SID = ?";

    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $param_Year, $param_SID);
        
        // Set parameters
        $param_SID = trim($_POST["SID"]);
        $param_Year = trim($_POST["PayForWhichYear"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $sql2 = "DELETE FROM request_elec_bill WHERE SID = ? AND PayForWhichMonth = ? AND PayForWhichYear = ?";
    
            if($stmt2 = mysqli_prepare($conn, $sql2)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt2, "iii", $param_SID, $param_Month, $param_Year);
        
                // Set parameters
                $param_SID = trim($_POST["SID"]);
                $param_Month = trim($_POST["PayForWhichMonth"]);
                $param_Year = trim($_POST["PayForWhichYear"]);
        
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt2)){
                    // Records deleted successfully. Redirect to landing page
                    echo '<script type="text/javascript">'; 
                    echo 'alert("Electricity bill approved & updated successfully");'; 
                    echo 'window.location.href = "admin_elecBillReq.php";';
                    echo '</script>';
                } else{
                    echo '<script>alert("Could not approve request")</script>';    
                }
            } else{
                echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
            }
        }    
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt2);
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["SID"]))){
        echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Approve Electricity Bill Request</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="SID" value="<?php echo trim($_GET["SID"]); ?>"/>
                            <input type="hidden" name="PayForWhichMonth" value="<?php echo trim($_GET["PayForWhichMonth"]); ?>"/>
                            <input type="hidden" name="PayForWhichYear" value="<?php echo trim($_GET["PayForWhichYear"]); ?>"/>
                            <p>Are you sure you want to approve this request?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="admin_elecBillReq.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>