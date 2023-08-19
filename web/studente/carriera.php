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
                $params = array($studente[7]);
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
                            <h1 class="jumbotron-heading">Carriera: <?php echo $studente[3] . "  " . $studente[4] ?></h1>
                            <?php echo $nomeLaurea; ?>
                        </div>
                    </section>
                    <div class="album py-5 bg-light">
                        <div class="container">
                            <?php 
                            
                            $sql='SELECT * FROM get_carriera_valida($1)';
                            $params=array($_SESSION['user'][0]); 
                            $result=launchSQL($sql,$params,"get_carriera");
                            while ($row = pg_fetch_row($result)) {
                                //echo var_dump($row);
                                echo ' <div class="my-3 p-3 bg-white rounded box-shadow">
                                <h6 class="border-bottom border-gray pb-2 mb-0">Carriera Valida</h6>
                                <div class="media text-muted pt-3">
                                    <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <strong class="text-gray-dark">'.$row[1].'</strong>
                                            <button class="btn btn-light">'.$row[2].'</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>';
                            }
                            $sql='SELECT * FROM get_carriera($1)';
                            $params=array($_SESSION['user'][0]); 
                            $result=launchSQL($sql,$params,"get_carriera_full");
                            while ($row = pg_fetch_row($result)) {
                                //echo var_dump($row);
                                echo ' <div class="my-3 p-3 bg-white rounded box-shadow">
                                <h6 class="border-bottom border-gray pb-2 mb-0">Carriera Completa</h6>
                                <div class="media text-muted pt-3">
                                    <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                        <strong class="text-gray-dark">'.$row[1].'</strong>
                                        <strong class="text-gray-dark">'.$row[3].'</strong>
                                        <button class="btn btn-light">'.$row[2].'</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>';
                            }
                           
                            ?>
                           
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