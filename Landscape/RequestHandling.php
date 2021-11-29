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
    
       
        $LID = $_POST['LID'];
        $RequesterName = $_POST['RequesterName'];
        $Job = $_POST['Job'];
        $DateOfRequest = $_POST['DateOfRequest'];
        $StatusMsg = "Ongoing";
        

        $sql_query= "INSERT INTO RequestHandling(LID, RequesterName, Job, DateOfRequest, StatusMsg) VALUES('$LID', '$RequesterName', '$Job', '$DateOfRequest', '$StatusMsg')";


        if(mysqli_query($db, $sql_query))
        {
            echo "Registration is successful!";
        }
        else
        {
            echo "Error : ".$sql." ". mysqli_error($db);
        }
        mysqli_close($db);


    }

?>