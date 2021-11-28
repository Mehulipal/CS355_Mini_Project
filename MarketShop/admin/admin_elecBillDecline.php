<?php
// Process delete operation after confirmation
if(isset($_POST["SID"]) && !empty($_POST["SID"])){
    // Include config file
    require_once (dirname(__FILE__)."/../config.php");
    
    // Prepare a delete statement
    $sql = "DELETE FROM request_elec_bill WHERE SID = ? AND PayForWhichMonth = ? AND PayForWhichYear = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "iii", $param_SID, $param_Month, $param_Year);
        
        // Set parameters
        $param_SID = trim($_POST["SID"]);
        $param_Month = trim($_POST["PayForWhichMonth"]);
        $param_Year = trim($_POST["PayForWhichYear"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: admin_elecBillReq.php");
            exit();
        } else{
            echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["SID"]))){
        echo '<script>alert("Could not delete request")</script>';
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
                    <h2 class="mt-5 mb-3">Decline Electricity Bill Request</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="SID" value="<?php echo trim($_GET["SID"]); ?>"/>
                            <input type="hidden" name="PayForWhichMonth" value="<?php echo trim($_GET["PayForWhichMonth"]); ?>"/>
                            <input type="hidden" name="PayForWhichYear" value="<?php echo trim($_GET["PayForWhichYear"]); ?>"/>
                            <p>Are you sure you want to decline this request?</p>
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