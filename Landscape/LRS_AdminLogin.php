<?php
    
    $server_name="localhost";
    $username="root";
    $password="";
    $datbase_name="Landscape Related Services";

    $db = mysqli_connect($server_name, $username, $password, $datbase_name);

    if(!$db)
    {
        die("Connection Failed : ".mysqli_connection_error());
    }

    $admID = $_POST['admID'];
    $passwd = $_POST['passwd'];


    $sql = "SELECT admID, passwd FROM AdminDetails WHERE admID = '$admID' AND passwd = '$passwd'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result);
    /*$sql_query = "SELECT * FROM emp;"
    $res = mysqli_query($db, $sql);
    $arr = mysqli_fetch_array($res);*/
   

    if($row['admID']==$admID && $row['passwd']==$passwd)
    {
        echo "<b>Successfully logged in!</b>";
        session_start();
        $_SESSION["admID"] = $admID;
        $_SESSION["passwd"] = $passwd;
        $_SESSION["loggedin"] = true;
        header("location: LRS_AdminHome.php");
    }
    else{
        echo "Incorrect Login Details.";
    }


?>
