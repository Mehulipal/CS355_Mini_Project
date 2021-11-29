<?php
// Process delete operation after confirmation
if(isset($_POST["RoomNo"]) && !empty($_POST["RoomNo"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "UPDATE roominfo SET Availability = 1 WHERE RoomNo = ?";
    $sql2 = "UPDATE reserve SET ReservationStatus = 0 WHERE RoomNo =?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        if($stmt2 = mysqli_prepare($conn, $sql2)){

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_RoomNo);
        mysqli_stmt_bind_param($stmt2,"s", $param_RoomNo);
        // Set parameters
        $param_RoomNo = trim($_POST["RoomNo"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt) and mysqli_stmt_execute($stmt2)){
            // Records deleted successfully. Redirect to landing page
            header("location: admin_home.php");
            exit();
        } else{
            echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
        }
    }}
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["RoomNo"]))){
        echo '<script>alert("Could not delete shop")</script>';
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
                    <h2 class="mt-5 mb-3">Delete Room</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="RoomNo" value="<?php echo trim($_GET["RoomNo"]); ?>"/>
                            <p>Are you sure you want to make this room empty/available?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="admin_home.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>