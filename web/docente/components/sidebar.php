<?php 
session_start();
?>

<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">                <!-- Logo e nome della dashboard -->
    <div class="position-sticky">
        <div class="text-center">
            <h3>Dashboard</h3>
        </div>
     </div>

                <!-- Links della sidebar -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/EsameLabBasiDiDati/web/docente/">Dashboard</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/EsameLabBasiDiDati/web/docente/appello/">Appelli</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/EsameLabBasiDiDati/web/docente/appello/creaAppello.php">Crea Appello</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Rapporti</a>
                    </li>
                    <!-- Aggiungi altri link per le diverse sezioni della tua dashboard -->
                </ul>
            </nav>
