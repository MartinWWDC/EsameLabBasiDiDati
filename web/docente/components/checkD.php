<?php
session_start();
#echo var_dump($_SESSION);
if (!empty($_SESSION["user"])) {
    if($_SESSION["type"]!="docente"){
        header('Location: ../studente/');

    }
} else{
    echo "test:".$_SESSION['user'];
    #header('Location: ../');

}

$userData = $_SESSION['user'];


?>