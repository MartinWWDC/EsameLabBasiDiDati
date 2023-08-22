<?php
session_start();
?>

<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar"> <!-- Logo e nome della dashboard -->
    <div class="position-sticky">
        <div class="text-center">
            <h3>Dashboard</h3>
        </div>
    </div>

    <!-- Links della sidebar -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="">Dashboard</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="./listLauree.php">Laure</a>
        </li><li class="nav-item">
            <a class="nav-link" href="./creaLauree.php">Crea Lauree</a>
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
            <a class="nav-link" href="./creaInsegnamento.php">Crea Insegnamento</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./listInsegnamenti.php">Insegnamenti</a>
        </li> 

        <li class="nav-item">
            <a class="nav-link" href="./editProf.php">Edit</a>
        </li>
        
    </ul>
</nav>