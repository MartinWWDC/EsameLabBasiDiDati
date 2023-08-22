<?php

require  '../public_components/utility.php';


$SQL='INSERT INTO "corsoDiLaurea"(nome,durata,anno,"desc") VALUES ($1, $2,$3,$4)';
$result=array($_POST['nome'],$_POST['durata'],$_POST['anno'],$_POST['descrizione']);
echo var_dump($result);
$result=launchSQL($SQL,$result,"insert");
header("Location: listLauree.php"); 
?>