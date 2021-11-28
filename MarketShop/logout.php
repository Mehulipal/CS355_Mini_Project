<?php

session_start();
$_SESSION = array();
session_destroy();
header("location: admin/admin_login.php");

?>
