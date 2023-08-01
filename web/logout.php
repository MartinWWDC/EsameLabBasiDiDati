<?php
// Avvia la sessione
session_start();

// Rimuovi i dati dell'utente dalla sessione
unset($_SESSION['user']);

// Termina la sessione
session_destroy();

// Reindirizza l'utente alla pagina di login dopo il logout
header('Location: index.html');
exit;
?>
