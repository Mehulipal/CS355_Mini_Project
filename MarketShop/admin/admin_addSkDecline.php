<?php
// Process delete operation after confirmation
if(isset($_POST["SID"]) && !empty($_POST["SID"])){
    // Include config file
    require_once (dirname(__FILE__)."/../config.php");
    
    // Prepare a delete statement
    $sql = "DELETE FROM request_add_sk WHERE _SkName = ? AND _AadharID = ? AND _Address = ? AND _Gender = ? AND _Contact = ? AND _SID = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sssssi", $param_SkName, $param_AadharID, $param_Address, $param_Gender, $param_Contact, $param_SID);
        
        // Set parameters
        $param_SkName = trim($_POST["SkName"]);
        $param_AadharID = trim($_POST["AadharID"]);
        $param_Address = trim($_POST["Address"]);
        $param_Gender = trim($_POST["Gender"]);
        $param_Contact = trim($_POST["Contact"]);
        $param_SID = trim($_POST["SID"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: admin_skReq.php");
            exit();
        } else{
            echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);
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
                    <h2 class="mt-5 mb-3">Decline Add Shopkeeper Request</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="SkName" value="<?php echo trim($_GET["SkName"]); ?>"/>
                            <input type="hidden" name="AadharID" value="<?php echo trim($_GET["AadharID"]); ?>"/>
                            <input type="hidden" name="Address" value="<?php echo trim($_GET["Address"]); ?>"/>
                            <input type="hidden" name="Gender" value="<?php echo trim($_GET["Gender"]); ?>"/>
                            <input type="hidden" name="Contact" value="<?php echo trim($_GET["Contact"]); ?>"/>
                            <input type="hidden" name="SID" value="<?php echo trim($_GET["SID"]); ?>"/>
                            <p>Are you sure you want to decline this request?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="admin_skReq.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>