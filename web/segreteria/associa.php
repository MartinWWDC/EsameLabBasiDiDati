<?php
session_start();
require  '../public_components/utility.php';

$email=$_POST['email'];
echo $email;
$sql="UPDATE insegnamento SET responsabile=$1 where id=$2";
$params=array($email,$_POST['insegnamento']);

$result=launchSQL($sql,$params,"update");
header("Location: index.php")


?>