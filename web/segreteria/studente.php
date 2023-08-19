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
                //TODO update cellulare
                require  '../public_components/utility.php';
                session_start();
                echo var_dump($_POST);
                $nome = $_POST["nome"];
                $cognome = $_POST["cognome"];
                $insegnamento = $_POST["insegnamento"];
                $password = $_POST["password"];
                $email = $nome . '.' . $cognome . '@studente.com';
                $matricola = $nome[0] . $cognome[0] . random_int(0, 1000);
                $params = array($matricola, $email, $password, $nome, $cognome, 0,);
                echo var_dump($params);
                $SQL = "select * from create_docente($1,$2, $3, $4, $5,$6)";
                $result = launchSQL($SQL, $params, "create");

                header("Location: index.php");
                ?>


            </main>
        </div>
    </div>
</body>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>