<?php
session_start();
//echo var_dump($_SESSION); 




?>

<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar"> <!-- Logo e nome della dashboard -->
    <div class="position-sticky">
        <div class="text-center">
            <h3>Dashboard</h3>
        </div>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="./listLauree.php">Lauree</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./creaLauree.php">Crea Laurea</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="./listDocenti.php">Docenti</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./creaDocente.php">Crea Docenti</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./listStudenti.php">Studenti</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./creaStudente.php">Crea Studente</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./listStudentiarch.php">Archivio Studenti</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="./listInsegnamenti.php">Insegnamenti</a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" href="./creaInsegnamento.php">Crea Insegnamento</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./editProf.php">Edit</a>
        </li>
        <?php 
        
            if($_SESSION['user'][2]=='t'){
                echo    '<li class="nav-item">
                        <a class="nav-link" href="./createSegreteria.php">Crea Segreteria</a>
                        </li>';
            }
        ?>
        
    </ul>
</nav>