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
            <?php include 'components/sidebar.php';
            require  '../public_components/utility.php';
            ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <?php
                $id = $_GET["idIns"];
                //echo $id;


                $SQL = "UPDATE insegnamento set responsabile=$1 where id=$2";
                $result = array(NULL, $id);

                $result = launchSQL($SQL, $result, "remove_res");
                //header("Location: index.php");


                ?>

            </main>
        </div>
    </div>
</body>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>