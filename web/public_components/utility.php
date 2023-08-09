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

        echo "An error occurred in preparing the query.\n";
        echo pg_last_error($cn); // Stampa l'errore PostgreSQL
       exit;
   }

   $result = pg_execute($cn, $name, $params);


   if (!$result) {
       echo "An error occurred in executing the query.\n";
       echo pg_last_error($cn); // Stampa l'errore PostgreSQL

       exit;

   }
}
?>