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
            <a class="nav-link" href="/EsameLabBasiDiDati/web/studente/">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/EsameLabBasiDiDati/web/studente/appelli.php">Appelli</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/EsameLabBasiDiDati/web/studente/carriera.php">Carriera</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/EsameLabBasiDiDati/web/studente/ritiro.php">Ritiro</a>
        </li>
    </ul>
</nav>