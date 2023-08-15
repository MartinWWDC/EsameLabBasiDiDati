<?php
require  '../public_components/utility.php';
session_start();
//echo var_dump($_POST);
$nome=$_POST["nome"];
$cognome=$_POST["cognome"];
$dataN=$_POST["dataN"];
$insegnamento=$_POST["insegnamento"];
$password=$_POST["password"];
$passwordC=$_POST["paswordConfirmation"]; 
$email=$nome.'.'.$cognome.'@docente.com';
$params=array($email,$password,$nome,$cognome,$dataN,$insegnamento);
echo var_dump($params);
$SQL="select * from create_docente($1,$2, $3, $4, $5,$6)";
$result=launchSQL($SQL,$params,"create");

header("Location: index.php");
?>
