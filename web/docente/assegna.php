<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assegna</title>
    <!-- Includi i file CSS di Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>


<body>
    <?php session_start();
    include './components/checkD.php'
    ?>
    <?php include './public_components/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include 'components/sidebar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <?php
                require  '../public_components/utility.php';

                session_start();
                $corso = $_GET['corso'];
                $data = $_GET['dataA'];
                $voto = $_POST['voto'];
                $student = $_GET['studentID'];
                echo $voto . "  ";
                echo $data . "   ";
                echo $corso . "   ";
                echo $student;
                $sql = 'UPDATE sostiene SET voto=$1 where "data"=$2 and id_corso=$3 and id_studente=$4';

                $sql = 'SELECT add_voto($1, $4, $3, $2)';
                $params = array($voto, $data, $corso, $student);

                $result = launchSQL($sql, $params, "set_voto");

                header("Location: assegnaVoto.php?corso=" . $corso . "&dataA=" . $data);
                exit;
                ?>

            </main>
        </div>
    </div>
</body>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>