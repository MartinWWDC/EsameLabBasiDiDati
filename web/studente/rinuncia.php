<?php
    session_start();
    require  '../public_components/utility.php';
    $sql='DELETE from "Studente" where matricola=$1';
    $params=array($_SESSION['user'][0]);
    $result=launchSQL($sql,$params,"deleteS");
    header("Location: ../logout.php")
  ?>