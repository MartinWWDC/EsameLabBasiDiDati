<?php

require  '../public_components/utility.php';

echo var_dump($_POST);
$SQL="INSERT INTO insegnamento VALUES (nextval('insegnamento_id_seq'::regclass), $1, $2,$3,$4,$5,$6)";
$result=array($_POST['nomeIns'],$_POST['annoCons'],$_POST['CFU'],$_POST['corsoLa'],NULL,$_POST['desc']);

$result=launchSQL($SQL,$result,"insert");
header("Location: listInsegnamenti.php"); 
?>