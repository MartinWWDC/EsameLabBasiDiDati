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
    <?php session_start();
    include './components/checkD.php'
    ?>
    <?php include '../public_components/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include 'components/sidebar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php

                require  '../public_components/utility.php';

                $sql = "SELECT *FROM docente WHERE email=$1";

                $id = $_SESSION["user"][0];

                $params = array($id);
                $result = launchSQL($sql, $params, "check_user");
                $prof = array();
                while ($row = pg_fetch_row($result)) {
                    //echo var_dump($row);
                    $prof = $row;
                }
                ?>

                <main role="main">


                    <section class="jumbotron text-center">
                        <div class="container">
                            <h1 class="jumbotron-heading">Benvenuto prof <?php echo $prof[3] ?></h1>
                        </div>
                    </section>

                    <div class="album py-5 bg-light">
                        <div class="container">

                            <div class="row">
                                    <?php

                                    $sql = 'select * from insegnamento i inner join "corsoDiLaurea" c on i."corsoDiAppartenenza"=c.id where responsabile=$1';
                                    $result = launchSQL($sql, $params, "get_insengamenti");
                                    while ($row = pg_fetch_row($result)) {

                                        echo '
                                        <div class="col-md-4">
                                            <div class="card mb-4 box-shadow">
                                                <div class="card-body">
                                                    
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Corso:</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Nome Insegnamento</th>
                                                                <td>'.$row[1].'</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Anno Consigliato</th>
                                                                <td>'.$row[2].'</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Laurea di appartenenza:</th>
                                                                <td colspan="2">'.$row[7].'</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">CFU:</th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <a type="button" class="btn btn-secondary" href="./appello?id='.$row[0].'">Gestisci Appelli</a>
                                                    <a type="button" class="btn btn-success href="./appello/creaApello.php">Crea Appello</a>

                                                </div>
                                            </div>
                                        </div>';



                                    }
                                    ?>

                                   
                                
                            </div>
                        </div>
                    </div>

        </div>

        </main>
    </div>
    </div>
</body>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>