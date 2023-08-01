<?php
session_start();

if (!empty($_SESSION["user"])) {
    if($_SESSION["type"]!="Studente"){
        echo "test";
        header('Location: ../docente/');

    }
} else{
    header('Location: ../');

}

$userData = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
</head>
<body>
    <h1>Welcome Studente</h1>
    <a href="../logout.php">Logout</a><br />
</body>
</html>
