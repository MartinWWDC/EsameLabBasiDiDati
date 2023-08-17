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
            <a class="nav-link" href="./docenti.php">Docenti</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./createDocente.php">Crea Docenti</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="">Studenti</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./creaCorso.php">Corsi</a>
        </li>
        
    </ul>
</nav>