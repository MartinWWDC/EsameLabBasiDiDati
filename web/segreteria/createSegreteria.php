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
                
                $SQL='insert into segreteria values($1,$2,$3)';
                $email='root'.random_int(0,100).'@segreteria.com';
                $password='a';
                $params=array($email,$password,'FALSE');
                //echo var_dump($params);
                $result=launchSQL($SQL,$params,"create_segreteria");
               
                ?>

                <main role="main">


                    <section class="jumbotron text-center">
                        <div class="container">
                            <h1 class="jumbotron-heading">Nuovo Account segreteria creato!</h1>
                            con email e password:
                            <?php echo '<h2>'.$email.'</h2></br><h2>'.$password.'</h2> '; ?>
                        </div>
                    </section>
                    

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