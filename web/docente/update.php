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
           
            <?php include './components/sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <?php
            require  '../public_components/utility.php';
            session_start();
            $corso = $_POST['corso'];
            $place = $_POST['luogo'];
            $day = $_POST['dataA'];
            $time = $_POST['oraA'];
            $dataA = $day . ' ' . $time;
            $dataA = str_replace('"', "'", $dataA);
            $params = array($place, $corso,$_GET['dataAO'],$_GET['corsoO']);
            //echo var_dump($params);
            $sql = 'UPDATE appello SET "dataA"='."'".$dataA."'".', "luogo"=$1, "corso"=$2 where "dataA"=$3 AND"corso"=$4';
            $result = launchSQL($sql, $params, "get_insegnamenti");
            echo "done";
            header("Location: ./appelli.php");

            ?>
            </main>
        </div>
    </div>

</body>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>