
<?php
require  '../public_components/utility.php';
session_start();
echo var_dump($_POST);
$params = array($_POST["docente"],$_GET["id"]);
echo var_dump($params);
$sql = 'UPDATE insegnamento SET "responsabile"=$1 where id=$2';

$result = launchSQL($sql, $params, "get_insegnamenti");
echo "done";
header("Location: ./listInsegnamenti.php")
?>