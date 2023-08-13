<?php
    session_start();
    require  '../public_components/utility.php';

    $sql='INSERT INTO sostiene VALUES ($1,$2,$3,$4)';
    
    $params=array($_GET['corso'],$_GET['dataA'],$_SESSION['user'][0],NULL);
    echo var_dump($params);
    $result=launchSQL($sql,$params,"iscrivi");
    header("Location: ./appelli.php");
?>