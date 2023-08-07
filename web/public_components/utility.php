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
   return $result;

}
/*
$sql = "SELECT *FROM docente WHERE email=$1";

$id = 'docente@example.com';

$params=array($id);
$result=launchSQL($sql,$params);
while ($row = pg_fetch_row($result)) {
    echo "testo";
    echo var_dump($row);
    
    exit;

}
*/

/*


    // Verifica se sono stati inviati i dati del modulo
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            
            $email = $_POST['email'];
            $password = $_POST['password'];
            $type = $_POST['type'];
            
            // Usa i parametri nella query per evitare SQL injection
            $sql = 'SELECT * FROM "'.$type.'" WHERE email = $1 AND pass = $2';
            $params = array($email, $password);

            // Prepara e esegui la query con pg_prepare e pg_execute
            $result = pg_prepare($cn, "check_user", $sql);
            if (!$result) {
                echo $email."\n".$password."\n".$type."\n";
                echo pg_last_error($connection)."\n";
                echo "An error occurred in preparing the query.\n";

                exit;
            }

            $result = pg_execute($cn, "check_user", $params);
            echo "sa".$type;


            if (!$result) {
                echo "An error occurred in executing the query.\n";
                exit;

            }
           
            while ($row = pg_fetch_row($result)) {
                echo "testo";
                echo var_dump($row);
                $_SESSION['user'] = $row;
                $_SESSION['type']= $type;
                $_SESSION['db']=$cn;
                if ($type == 'Studente') {
                    header('Location: studente/');
                } else {
                    header('Location: docente/');
                }
                exit;

            }
        } catch (PDOException $e) {
            // Errore nella query
            echo 'Errore nella query: ' . $e->getMessage();
        }
    }
*/
?>