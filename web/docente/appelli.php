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



    ?>
    <div class="container-fluid">
        <div class="row">
            <?php include './components/sidebar.php' ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="pt-3 pb-2 mb-3">
                    <h2>Gestione Appelli</h2>
                </div>
                <div class="col">

             
                <?php
                //session_start();
                 function genAppelliMateria(string $id){

                    $sql = 'select * from appello a inner join insegnamento i on a.corso=i.id where a.corso=$1 order by a."dataA"';
                    $params = array($id);
                    $result = launchSQL($sql, $params, "get_appello".rand());
                    
                    
    
                    $c=0;
                        
                        while ($row = pg_fetch_row($result)) {
                            //echo var_dump($row);
                            if($c==0){
                                echo '<div class="my-3 p-3 bg-body rounded shadow-sm">
                                <h6 class="border-bottom pb-2 mb-0">'.$row[4].'</h6>';
                          
                            }
                            echo  '<div class="d-flex text-body-secondary pt-3">
                            <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
                                <div class="d-flex justify-content-between">
                                    <strong class="text-gray-dark">'.$row[0].'</strong>
                                    <a href="./assegnaVoto.php?corso='.$row[2].'&dataA='.$row[0].'" class="btn btn-primary">Assegna Voti</a>
    
                                    <a href="./editAppello.php?corso='.$row[2].'&dataA='.$row[0].'" class="btn btn-secondary">Edit</a>
                                </div>
                                <span class="d-block">'.$row[1].'</span>
                            </div>
                        </div>';
                        $c++;
                        }
                        echo '</div>
                        </div>';
                       
                        
                     
                 }
                

                $id = $_GET['id'];

                if ($id==''){
                    
                    $sql = 'select id from insegnamento where responsabile=$1';
                    $id=$_SESSION['user'][0];
                    
                    $params = array($id);
                    $result = launchSQL($sql, $params, "get_insegnamenti");
                    while ($row = pg_fetch_row($result)) {
                        genAppelliMateria($row[0]);  
                    }
                }else{
                   genAppelliMateria($id);
                }
                    
                ?>
   
                </div>
            </main>
    </div>
</body>
<!-- Includi i file JavaScript di Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>