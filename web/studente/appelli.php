<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Appelli</title>
    <!-- Includi i file CSS di Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>


<body>
    <?php include './components/checkD.php' ?>
    <?php include '../public_components/header.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php include 'components/sidebar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php
                session_start();
                require  '../public_components/utility.php';



                $studente = $_SESSION["user"];
                $sql = 'select * from "corsoDiLaurea" where id=$1';
                $params = array($studente[6]);
                $result = launchSQL($sql, $params, "get_nomeLaurea");
                $nomeLaurea = "";
                while ($row = pg_fetch_row($result)) {
                    $nomeLaurea = $row[1];
                }

                $sql = 'select * from insegnamento where "corsoDiAppartenenza"=$1 order by "annoConsigliato"';
                $result = launchSQL($sql, $params, "get_insengamenti");

                //echo var_dump($studente);
                ?>

                <main role="main">


                    <section class="jumbotron text-center">
                        <div class="container">
                            <h1 class="jumbotron-heading">Appelli: <?php echo $studente[3] . "  " . $studente[4] ?></h1>
                            <?php echo $nomeLaurea; ?>
                        </div>
                    </section>
                    <div class="album py-5 bg-light">
                        <div class="container">
                            <div class="my-3 p-3 bg-white rounded box-shadow">
                                <h6 class="border-bottom border-gray pb-2 mb-0">Appelli disponibili:</h6>
                                <?php

                                $todayTimeStamp = date("Y-m-d") . ' 01:00:00';
                                $sql = 'SELECT *
                                FROM appello a
                                INNER JOIN insegnamento i ON a.corso = i.id
                                LEFT JOIN sostiene s ON s.id_corso = a.corso AND s.data = a."dataA" AND s.id_studente = $3
                                WHERE a."dataA" >= $1
                                    AND i."corsoDiAppartenenza" = $2
                                    AND s.id_studente IS NULL
                                ';
                                $params = array($todayTimeStamp, $_SESSION['user'][6], $_SESSION['user'][0]);
                                $result = launchSQL($sql, $params, "get_appelli");
                                while ($row = pg_fetch_row($result)) {
                                    //echo var_dump($row);
                                    echo ' 
                                <div class="media text-muted pt-3">
                                    <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <strong class="text-gray-dark">' . $row[0] . '  ' . $row[4] . '</strong>
                                            <a href="./iscrivi.php?dataA=' . $row[0] . '&corso=' . $row[2] . '" class="btn btn-primary">iscriviti</a>
                                        </div>
                                        <span class="d-block">Luogo: ' . $row[1] . '</span>
                                    </div>
                                </div>';
                                }
                                ?>

                            </div>


                        <div class="my-3 p-3 bg-white rounded box-shadow">
                            <h6 class="border-bottom border-gray pb-2 mb-0">Appelli a cui si è iscritti:</h6>

                            <?php
                            $sql = 'SELECT *
                          FROM appello a
                          INNER JOIN insegnamento i ON a.corso = i.id
                          INNER JOIN sostiene s ON s.id_corso = a.corso AND s.data = a."dataA" AND s.id_studente = $1';

                            $params = array($_SESSION['user'][0]);
                            $result = launchSQL($sql, $params, "fullI");
                            while ($row = pg_fetch_row($result)) {
                                //echo var_dump($row);
                                $vote="";
                                if(!is_null($row[12])){
                                    $vote=$row[12];
                                    
                                }
                                echo ' 
                                <div class="media text-muted pt-3">
                                    <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <strong class="text-gray-dark">' . $row[0] . '  ' . $row[4] . '</strong>
                                            '.$vote.'
                                        </div>
                                        <span class="d-block">' . $row[1] . '</span>    
                                    </div>
                                </div>';
                            }


                            ?>
                        </div>
                    </div>

                </main>


        </div>

        </main>

    </div>
    </div>
</body>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>