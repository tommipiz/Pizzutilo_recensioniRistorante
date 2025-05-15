<?php
session_start();
include 'connessione.php';

if (!isset($_SESSION['username'])) {
    header("Location: paginaLogin.html");
    exit();
}
if (!$_SESSION['admin']) {
    header("Location: benvenuto.php");
    exit();
}

$codice = trim($_POST['codice']);
$nome = trim($_POST['nome']);
$indirizzo = trim($_POST['indirizzo']);
$citta = trim($_POST['citta']);

// Controlla se il ristorante esiste già
$sql = "SELECT * FROM ristorante WHERE codice = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $codice);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $_SESSION['ristorante_message'] = "Ristorante con codice '$codice' già esistente.";
    header("Location: pannelloadmin.php");
    exit();
}

// Inserisci nuovo ristorante
$sql = "INSERT INTO ristorante (codice, nome, indirizzo, citta) VALUES ("$codice", "$nome", "$indirizzo", "$citta")";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $codice, $nome, $indirizzo, $citta);
if ($stmt->execute()) {
    $_SESSION['ristorante_message'] = "Ristorante inserito con successo.";
} else {
    $_SESSION['ristorante_message'] = "Errore durante l'inserimento del ristorante.";
}
header("Location: pannelloadmin.php");
exit();
?>
