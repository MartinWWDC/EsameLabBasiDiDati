
<?php
            require  '../public_components/utility.php';
            session_start();
            $params = array($_POST["password"],$_SESSION['user'][0]);
            echo var_dump($params);
            $sql = 'UPDATE docente SET "pass"=$1 where email=$2';
        
            $result = launchSQL($sql, $params, "get_insegnamenti");
            echo "done";
            header("Location: ../logout.php")
?>