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
    <?php
    require  '../public_components/utility.php';
    session_start();
    $sql = 'select * from insegnamento where responsabile=$1';
    $id = $_SESSION['user'][0];

    $params = array($id);
    $result = launchSQL($sql, $params, "get_insegnamenti");



    ?>
    <div class="container-fluid">
        <div class="row">
            <?php include './components/sidebar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="pt-3 pb-2 mb-3">
                    <h2>Creazione Appello</h2>
                </div>
                <div class="card bg-light">
                    <article class="card-body mx-auto" style="max-width: 800px;">
                        <form action='create.php' id='appelloForm' method="POST">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                                </div>
                                <select class="form-control" name="corso">
                                    <?php
                                    while ($row = pg_fetch_row($result)) {
                                        $selec="";
                                        if($row[0]==$_GET['id']){
                                            $selec="selected";
                                        }
                                        echo '<option value="' . $row[0] . '"'.$selec.'>' . $row[1] . '</option>';
                                    }

                                    ?>

                                </select>
                            </div>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="luogo" class="form-control" placeholder="Luogo" type="text">
                            </div>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-envelope">Data</i> </span>
                                </div>

                                <input name="dataA" class="form-control" placeholder="Data e ora" type="Date" onchange="formatDate()">
                            </div>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-envelope">Ora</i> </span>
                                </div>

                                <input name="oraA" class="form-control" placeholder="Data e ora " type="time">
                            </div>

                            <div class="form-group">
                                <button type="submit" value="sub" class="btn btn-primary btn-block"> Crea Appello </button>
                            </div>
                            <div>
                                ATTENZIONE: si potranno modificare le informazioni relative all'appelo solo se nessuno studente sarà iscritto altrimenti le informazioni non potranno essere modificate
                            </div>
                        </form>
                    </article>
                </div>



        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const date = new Date();

        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();
        const form = document.getElementById('appelloForm');
        form.addEventListener('submit', function(event) {
            let currentDate = `${day}-${month}-${year}`;
            if (!form.corso.value || !form.luogo.value || !form.dataA.value || !form.oraA.value) {
                event.preventDefault(); // Impedisce l'invio del modulo se i campi non sono completi
                alert('Completa tutti i campi prima di inviare il modulo.');
            }
           
        });
    });


</script>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>