<?php
session_start();
$_SESSION["m"]=100;
echo $_SESSION["m"];
header("Location: pag1.php");
exit;


?>