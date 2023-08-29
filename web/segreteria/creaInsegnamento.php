<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creazione Insegnamento</title>
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
                            <h1 class="jumbotron-heading">Creazione Nuovo Insegnamento</h1>
                        </div>
                    </section>
                    <div class="album py-5 bg-light">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="POST" action="corso.php">
                                                <div class="form-group">
                                                    <label>Nome Insegnamento</label>
                                                    <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Inserire Nome Insegnamento" name="nomeIns">
                                                </div>
                                                <div class="form-group">
                                                    <label>Anno Consigliato</label>
                                                    <input type="number" min="1" max="3" class="form-control" aria-describedby="emailHelp" placeholder="Enter anno consigliato" name="annoCons">
                                                </div>
                                                <div class="form-group">
                                                    <label>CFU</label>
                                                    <input type="number" min="1" class="form-control" aria-describedby="emailHelp" name="CFU">
                                                </div>
                                                <div class="form-group">
                                                    <label>Corso di laurea</label>
                                                    <select class="form-select-input" id="typeSelect" name="corsoLa">

                                                        <?php
                                                        $SQL = 'select * from "corsoDiLaurea"';
                                                        $params = array();
                                                        $result = launchSQL($SQL, $params, "get_insegnamenti");
                                                        while ($row = pg_fetch_row($result)) {
                                                            echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Descrizione</label>
                                                    <input type="text" class="form-control" name="desc">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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