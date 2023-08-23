
<?php
require  '../public_components/utility.php';
session_start();
echo var_dump($_POST);
$params = array($_GET["id"],$_POST["insengamentoProp"]);
echo var_dump($params);
$sql = 'INSERT INTO propedeuticita VALUES ($1,$2)';

$result = launchSQL($sql, $params, "associa_propedeuticità");
echo "done";
header("Location: ./listInsegnamenti.php")
?>