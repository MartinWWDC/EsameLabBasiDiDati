<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Includi i file CSS di Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <?php include '../components/checkD.php' ?>
    <?php include '../public_components/header.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php include 'components/sidebar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php
                session_start();
                require  '../public_components/utility.php';
                ?>

                <main role="main">
                    <section class="jumbotron text-center">
                        <div class="container">
                            <h1 class="jumbotron-heading">Lista Studenti</h1>
                        </div>
                    </section>
                    <div class="album py-5 bg-light">
                        <div class="container">

                            <div class="row">
                                <?php
                                $SQL = 'select * from "Studente" s inner join "corsoDiLaurea" c on s."idLaurea"=c.id';
                                $params = array();
                                $result = launchSQL($SQL, $params, "get_studenti");
                                
                                while ($row = pg_fetch_row($result)) {

                                    //echo var_dump($row);
                                    echo '
                                            	<div class="col-md-4">
                                    <div class="card mb-4 box-shadow">
                                        <div class="card-body">

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Studente:</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                    <tr>
                                                        <th scope="row">Nome Insegnamente</th>
                                                        <td>' . $row[3] .'  '. $row[4] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Data Nascita</th>
                                                        <td>' . $row[6] . '</td>
                                                    </tr>
                                                    <tr>
                                                    <th scope="row">CFU</th>
                                                    <td>' . $row[5] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Laurea :</th>
                                                        <td colspan="2">' . $row[9] . '</td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                            <a type="button" class="btn btn-warning" href="./archiviaArc.php?matricola='.$row[0].'">Archivia</a>

                                        </div>
                                    </div>
                                </div>';
                                }
                                ?>
                            </div>
                        </div>

                </main>

            </main>

        </div>
    </div>
</body>

<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>