<?php
$servernameDB = "localhost";
$usernameDB = "root";
$passwordDB = "";      // Cambiare se necessario
$dbnameDB = "recensioni_ristoranti";  // Nome del database

mysqli_report(MYSQLI_REPORT_OFF);   // Disabilita eccezioni automatiche

// Creazione della connessione
$conn = new mysqli($servernameDB, $usernameDB, $passwordDB, $dbnameDB);
if ($conn->connect_error) {
    header("Location: errore.html");
    exit();
}
?>
