<?php
    session_start();
    require  '../public_components/utility.php';
    $sql='DELETE from "propedeuticita" where id_insegnamento=$1 and id_insegnamento_propedeutico=$2';
    $params=array($_GET['idIns'],$_GET['idProp']);
    echo var_dump($params);
    $result=launchSQL($sql,$params,"deleteProp");
    header("Location: listInsegnamenti.php")
  ?>