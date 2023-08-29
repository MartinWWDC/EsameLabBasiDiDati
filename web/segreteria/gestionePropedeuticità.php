<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Propedeuticità</title>
    <!-- Includi i file CSS di Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>


<body>
    <?php include './components/checkD.php' ?>
    <?php include '../public_components/header.php' ?>
    <?php
    require  '../public_components/utility.php';
    session_start();
    $sql = 'select * from get_propedeuticità($1)';
    $params = array($_GET['idIns']);
    $result = launchSQL($sql, $params, "get_propedeuticità");
    

    ?>
    <div class="container-fluid">
        <div class="row">
            <?php include './components/sidebar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="pt-3 pb-2 mb-3">
                    <h2>Gestione Propedeuticità</h2>
                </div>
                <div class="col">
                    <div class="my-3 p-3 bg-white rounded box-shadow">
                        <h6 class="border-bottom border-gray pb-2 mb-0">Studenti</h6>

                        <?php
                        while ($row = pg_fetch_row($result)) {
                            //echo var_dump($row);
                            echo '<div class="media text-muted pt-3">
                            <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <strong class="text-gray-dark">' . $row[1] . '</strong>
                                    <div>
                                    
                                        <form action="./removeProp.php?idIns='.$_GET['idIns'].'&idProp='.$row[0].'" method="POST">
                                      
                                        <input type="submit" id="assegna" class="btn btn-danger" value="Rimuovi">
                                        </form>
                                    </div>
                                </div>
                                <span class="d-block">' . $row[7] . ' ' . $row[8] . '</span>
                            </div>

                        </div>';
                        }

                        ?>




                    </div>
                </div>
            </main>
        </div>
</body>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>