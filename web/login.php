<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php
    session_start();

    // Parametri di connessione al database
    $host = 'localhost';
    $dbname = 'esami'; // Rimuovi eventuali spazi inutili qui
    $user = 'postgres';
    $password = 't';
    $str = "host={$host} port=5432 dbname={$dbname} user={$user} password={$password}";

    $cn = pg_connect($str);
    pg_query($cn, "set SEARCH_PATH TO esami");

    try {
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Connessione al database fallita: ' . $e->getMessage());
    }

    // Verifica se sono stati inviati i dati del modulo
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            
            $email = $_POST['email'];
            $password = $_POST['password'];
            $type = $_POST['type'];
            
            // Usa i parametri nella query per evitare SQL injection
            $sql = 'SELECT * FROM "'.$type.'" WHERE email = $1 AND pass = $2';
            $params = array($email, $password);
            echo $sql;
            echo var_dump($params);
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
            echo var_dump($result);


            if (!$result) {
                echo "An error occurred in executing the query.\n";
                exit;

            }

            while ($row = pg_fetch_row($result)) {
                $_SESSION["user"] = $row;
                $_SESSION["type"]= $type;
                
                echo "testo";
                echo var_dump($_SESSION);
                if ($type == 'Studente') {
                    header('Location: studente/');

                } 
                if ($type == 'docente') {
                    header('Location: docente/');

                }
                if ($type == 'segreteria') {
                    header('Location: segreteria/');

                }
                exit();


            }
            header('Location: index.html');

        } catch (PDOException $e) {
            // Errore nella query
            echo 'Errore nella query: ' . $e->getMessage();
        }
    }
    ?>
</body>
</html>
