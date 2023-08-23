<?php
session_start();
//echo var_dump($_SESSION);
if (!empty($_SESSION["user"])) {
    if($_SESSION["type"]!="Studente"){
        if($_SESSION["type"]=="docente"){
            header('Location: ../docente/');
        }else{
            echo "test:".$_SESSION['user'];
            header('Location: ../');
    
        }
        
    }
} else{
    echo "testO:".$_SESSION['user'];
    header('Location: ../');

}



?>