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
                            <h1 class="jumbotron-heading">Associa Insegnamento</h1>
                        </div>
                    </section>
                    <div class="album py-5 bg-light">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="POST" action="associa.php">
                                                <div class="form-group">
                                                    <label>Docente</label>
                                                    <input type="text" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email" value=<?php echo $_GET["email"]; ?> >
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Insegnamento</label>
                                                    <select class="form-select-input" name="insegnamento">
                                                        <?php
                                                        $SQL = "select * from insegnamento where responsabile is null";
                                                        $params = array();
                                                        $result = launchSQL($SQL, $params, "get_insegnamento");
                                                        while ($row = pg_fetch_row($result)) {
                                                            echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                                        }

                                                        ?>
                                                    </select>
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