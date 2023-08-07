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
<?php session_start(); include './components/checkD.php'
?>
<?php include '../public_components/header.php'; ?>

<div class="container-fluid">
    <div class="row">
    <?php include 'components/sidebar.php' ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <?php
 
    require  '../public_components/utility.php';
    
    $sql = "SELECT *FROM docente WHERE email=$1";

    $id = $_SESSION["user"][0];
    
    $params=array($id);
    $result=launchSQL($sql,$params);
    $prof=array();
    while ($row = pg_fetch_row($result)) {
        //echo var_dump($row);
        $prof=$row;
    
    }
    
    

?>

    
    <div class="pt-3 pb-2 mb-3">
            <h2>Benvenuto prof <?php echo $prof[3] ?></h2>
        </div>


    </div>
</div>
</body>
   <!-- Includi i file JavaScript di Bootstrap -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>