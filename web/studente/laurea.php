<?php
    require  '../public_components/utility.php';
    session_start();
    //echo var_dump($_POST);
    $params=array($_SESSION['user'][0]);
    //echo var_dump($params);
    $SQL = 'delete from "Studente" where matricola=$1';
    $result = launchSQL($SQL, $params, "laurea");


    header("Location: ./logout.php");
?>