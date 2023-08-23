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
                            <h1 class="jumbotron-heading">Creazione Nuovo Studente</h1>
                        </div>
                    </section>
                    <div class="album py-5 bg-light">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="POST" action="studente.php">
                                                <div class="form-group">
                                                    <label>Nome Studente</label>
                                                    <input type="text" class="form-control" name="nome" aria-describedby="emailHelp" placeholder="Inserisci il nome">
                                                </div>
                                                <div class="form-group">
                                                    <label>Cognome Studente</label>
                                                    <input type="text" class="form-control" name="cognome" aria-describedby="emailHelp" placeholder="Inserisci il cognome">
                                                </div>
                                                <div class="form-group">
                                                    <label>Data Nasciata</label>
                                                    <input type="date" class="form-control" name="dataN" aria-describedby="emailHelp" placeholder="Enter email">
                                                </div>
                                                <div class="form-group">
                                                    <label>Corso di laurea</label>
                                                    <select class="form-select-input" name="laurea">
                                                        <?php
                                                        $SQL = 'select * from "corsoDiLaurea"';
                                                        $params = array();
                                                        $result = launchSQL($SQL, $params, "get_insegnamento");
                                                        while ($row = pg_fetch_row($result)) {
                                                            echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                                        }

                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                                </div>
                                                <div class="form-group">
                                                    <label>Conferma Password</label>
                                                    <input type="password" class="form-control" name="paswordConfirmation" placeholder="Password">
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");

        form.addEventListener("submit", function(event) {
            const password = document.getElementById("password").value;
            const passwordConfirmation = document.getElementById("passwordConfirmation").value;
            const nome = document.getElementById("nome").value;
            const cognome = document.getElementById("cognome").value;
            const dataN = document.getElementById("dataN").value;
            const insegnamento = document.getElementById("insegnamento").value;

            if (password !== passwordConfirmation) {
                event.preventDefault(); // Evita l'invio del form
                alert("Le password non corrispondono.");
            } else if (!nome || !cognome || !dataN || !insegnamento) {
                event.preventDefault(); // Evita l'invio del form
                alert("Compilare tutti i campi richiesti.");
            }
        });
    });
</script>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>