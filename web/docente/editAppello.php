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
    $sql = 'select * from appello a inner join sostiene s on s.id_corso=a.corso and s.data=a."dataA" where a."dataA"=$1 and a.corso=$2';
    $params = array($_GET['dataA'], $_GET['corso']);
    $result2 = launchSQL($sql, $params, "get_appello");
    $desc = "";
    $check = pg_num_rows($result2);
    //echo $check;
    if ($check==0){
        $sql = 'select * from appello a where a."dataA"=$1 and a.corso=$2';
        $params = array($_GET['dataA'], $_GET['corso']);
        $result2 = launchSQL($sql, $params, "get_appelloC");
        while ($row = pg_fetch_row($result2)) {
            //echo "c:".var_dump($row);
            $desc = $row[1];
        }

    }
    
    $data = substr($_GET["dataA"], 0, 10);
    $time = substr($_GET["dataA"], 11);
    $dis = "";
    if ($check != 0) {
        $dis = 'disabled';
    }
    //echo var_dump($data);
    //echo $time;

    ?>
    <div class="container-fluid">
        <div class="row">
            <?php include './components/sidebar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="pt-3 pb-2 mb-3">
                    <h2>Modifica Appello</h2>
                </div>
                <div class="card bg-light">
                    <article class="card-body mx-auto" style="max-width: 800px;">

                        <?php
                        if ($check != 0) {
                            echo "non è possibile modificare l'appello  in quando vi sono degli studenti già iscritti";
                        }
                        echo '<form action="update.php?corsoO=' . $_GET['corso'] . '&dataAO=' . $_GET['dataA'] . '" id="appelloForm" method="POST">'; ?>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                            </div>

                            <select class="form-control" name="corso" <?php echo $dis ?>>
                                <?php
                                $selected = $_GET['corso'];
                                while ($row = pg_fetch_row($result)) {
                                    //echo var_dump($row);
                                    if ($row[0] == $selected) {
                                        echo '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
                                    } else {
                                        echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                                    }
                                }

                                ?>

                            </select>
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                            </div>

                            <?php

                            echo '<input name="luogo" class="form-control" placeholder="Luogo" type="text" value="' . $desc . '"' . $dis . '>';
                            ?>
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-envelope">Data</i> </span>
                            </div>

                            <?php echo '<input name="dataA" class="form-control" placeholder="Data e ora" type="Date" onchange="formatDate()" value="' . $data . '" ' . $dis . '>';
                            ?>
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-envelope">Ora</i> </span>
                            </div>

                            <?php echo '<input name="oraA" class="form-control" placeholder="Data e ora " type="time" value="' . $time . '"' . $dis . '>'; ?>
                        </div>

                        <div class="form-group">
                            <button type="submit" value="sub" class="btn btn-primary btn-block" <?php echo $dis ?>> Aggiorna Appello </button>
                        </div>
                        </form>
                    </article>
                </div>
            </main>



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
            if (form.dataA.value <= currentDate) {
                //alert('Non può creare un appello per un giorno passato');
            }
        });
    });

    function formatDate() {
        var input = document.getElementById("myDateInput");
        var inputValue = input.value; // Formato: "yyyy-mm-dd"

        var parts = inputValue.split("-");
        var formattedDate = parts[2] + "/" + parts[1] + "/" + parts[0];

        input.value = formattedDate;
    }
</script>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>