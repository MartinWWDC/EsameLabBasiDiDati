<?php
    session_start();
    require  '../public_components/utility.php';
    $sql='DELETE from "Studente" where matricola=$1';
    $params=array($_GET['matricola']);
    echo var_dump($params);
    $result=launchSQL($sql,$params,"deleteS");
    header("Location: listStudenti.php")
  ?>