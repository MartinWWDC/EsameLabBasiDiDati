<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testo</title>
</head>
<body>
<?php

    // Parametri di connessione al database
    $host = 'localhost';
    $dbname = 'esami ';
    $user = 'bdlab';
    $password = 'bdlab';
    $str= "host=".$host." port=5432 dbname=".$dbname."user=".$user." password=".$password;

    $cn= pg_connect($str);
    pg_query($cn,"set SEARCH_PATH TO esami");

    $params = array(
    	'111111'
    );
    $sql="SELECT * from get_carriera_valida($1)";

    $result = pg_prepare($cn, "check_user", $sql);
    $result = pg_execute($cn, "check_user", $params);
    //$result=pg_query($cn,"SELECT * from get_carriera_valida('111111')");
    
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }
      
    while ($row = pg_fetch_row($result)) {
        
        echo "Matricola: $row[0]  E-mail: $row[1]";
        echo "<br />\n";

    }
    ?>

 
</body>
</html>


