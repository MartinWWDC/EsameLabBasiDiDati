<?php
require  '../../public_components/utility.php';

session_start();
$corso = $_GET['corso'];
$data = $_GET['dataA'];
$voto = $_POST['voto'];
$student=$_GET['studentID'];
echo $voto."  ";
echo $data."   ";
echo $corso."   ";
echo $student;
$sql = 'UPDATE sostiene SET voto=$1 where "data"=$2 and id_corso=$3 and id_studente=$4';
$params=array($voto,$data,$corso,$student);

$result=launchSQL($sql,$params,"set_voto");

header("./assegnaVoto.php");
exit;
?>