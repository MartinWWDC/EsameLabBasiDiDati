<?php
//TODO update cellulare
require  '../public_components/utility.php';
session_start();
echo var_dump($_POST);
$nome=$_POST["nome"];
$cognome=$_POST["cognome"];
$insegnamento=$_POST["insegnamento"];
$password=$_POST["password"];
$email=$nome.'.'.$cognome.'@studente.com';
$matricola=$nome[0].$cognome[0].random_int(0,1000);
$params=array($matricola,$email,$password,$nome,$cognome,0,);
echo var_dump($params);
$SQL="select * from create_docente($1,$2, $3, $4, $5,$6)";
$result=launchSQL($SQL,$params,"create");

header("Location: index.php");
?>
