<?php
function launchSQL(string $sql, array $params,string $name){
    $host = 'localhost';
    $dbname = 'esami';
    $user = 'postgres';
    $password = 't';
    $str = "host={$host} port=5432 dbname={$dbname} user={$user} password={$password}";

    $cn = pg_connect($str);
    pg_query($cn, "set SEARCH_PATH TO esami");

   $result = pg_prepare($cn, $name, $sql);
   if (!$result) {

        echo "An error occurred in preparing the query \n".$name;
        echo pg_last_error($cn); // Stampa l'errore PostgreSQL
       exit;
   }

   $result = pg_execute($cn, $name, $params);


   if (!$result) {
        //echo "An error occurred in executing the query.\n".$name;
        //echo pg_last_error($cn); // Stampa l'errore PostgreSQL
        $queryErrorMessage = pg_last_error($cn); // Stampa l'errore PostgreSQL

        $startMarker = "ERROR:";
        $endMarker = "CONTEXT:";

        $startPos = strpos($queryErrorMessage, $startMarker);
        $endPos = strpos($queryErrorMessage, $endMarker);

        if ($startPos !== false && $endPos !== false) {
            $errorText = substr($queryErrorMessage, $startPos + strlen($startMarker), $endPos - $startPos - strlen($startMarker));
            $errorText = trim($errorText);
            echo $errorText;
        } else {
            echo "Error message format not recognized.";
        }

       exit;

   }
   return $result;

}
