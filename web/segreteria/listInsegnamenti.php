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
                            <h1 class="jumbotron-heading">Lista Insegnamenti</h1>
                        </div>
                    </section>
                    <div class="album py-5 bg-light">
                        <div class="container">

                            <div class="row">
                                <?php
                                $SQL = 'select * from insegnamento i left join docente d on i.responsabile=d.email inner join "corsoDiLaurea" cL on cL.id=i."corsoDiAppartenenza"';
                                $params = array();
                                $result = launchSQL($SQL, $params, "get_docenti");
                                
                                while ($row = pg_fetch_row($result)) {
                                    $associa='';
                                    if($row[5]==NULL){
                                        $associa='<a type="button" class="btn btn-success" href="./assegnaResponsabile.php?idIns='.$row[0].'">assegna responsabile</a>';
                                    }
                                    $sql = 'select * from get_propedeuticità($1)';
                                    $params = array($row[0]);
                                    $res = launchSQL($sql, $params, "get_prop" . random_int(0, 10000));
                                    $prop = "";
                                    while ($r = pg_fetch_row($res)) {
                                      $prop .= " " . $r[1];
                                    }
                                    //echo var_dump($row);
                                    echo '
                                            	<div class="col-md-4">
                                    <div class="card mb-4 box-shadow">
                                        <div class="card-body">

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Insegnamento:</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                    <tr>
                                                        <th scope="row">Nome Insegnamento</th>
                                                        <td>' . $row[1] .'</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Anno Consigliato</th>
                                                        <td>' . $row[2] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">CFU:</th>
                                                        <td colspan="2">' . $row[3] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Laurea di Partenza:</th>
                                                        <td colspan="2">' . $row[12] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Propedeuticità:</th>
                                                        <td colspan="2">' . $prop . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">responsabile:</th>
                                                        <td colspan="2">' . $row[8] . '<br />'.$row[9].'</td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                            <div>
                                            <a type="button" class="btn btn-secondary" href="./associaPropedeuticità.php?idIns='.$row[0].'">associa propedeuticità</a>
                                            <a type="button" class="btn btn-warning" href="./revocaResponsabile.php?idIns='.$row[0].'">revoca responsabile</a>
                                            <a type="button" class="btn btn-primary" href="./gestisiPropedeuticità.php?idIns='.$row[0].'">Gestisci propedeuticità</a>

                                            '.$associa.'

                                            </div>
      
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