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
            <?php include 'components/sidebar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php
                session_start();
                require  '../public_components/utility.php';
                ?>

                <main role="main">


                    <section class="jumbotron text-center">
                        <div class="container">
                            <h1 class="jumbotron-heading"><?php echo $studente[3] . "  " . $studente[4] . " si desidera effetture la rinuncia agli studi?" ?></h1>
                        </div>
                    </section>
                    <div class="album py-5 bg-light">
                        <div class="container">

                            <div class="row">
                                <main class="form-signin w-100 m-auto">
                                    <form action="rinuncia.php" method="post">
                                        
                                        <button class="btn btn-primary w-100 py-2" type="submit">Rinuncia agli studi</button>
                                    </form>
                                </main>




                            </div>
                        </div>

                </main>


        </div>

        </main>

    </div>
    </div>
</body>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>