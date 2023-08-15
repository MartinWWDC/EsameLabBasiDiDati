<?php
session_start();

if (!empty($_SESSION["user"])) {
    if($_SESSION["type"]!="Studente"){
        echo "test";
        header('Location: ../docente/');

    }else{
        echo "test:".$_SESSION['user'];
        header('Location: ../');

    }
} else{
    header('Location: ../');

}

$userData = $_SESSION['user'];


?>