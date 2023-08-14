<?php
session_start();

if (empty($_SESSION["user"]) ||$_SESSION["type"]!="segreteria"){
    echo "erro :(";
    echo var_dump($_SESSION["user"]);
    //header('Location: ../');

}



?>