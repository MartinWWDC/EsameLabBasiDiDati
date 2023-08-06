<?php
session_start();

if (!empty($_SESSION["user"])) {
    if($_SESSION["type"]!="Docente"){
        header('Location: ../studente/');

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
    <h1>Welcome Docente</h1>
    <a href="../logout.php">Logout</a><br />
</body>
</html>
