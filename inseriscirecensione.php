<?php
session_start();
include 'connessione.php';

if (!isset($_SESSION['username'])) {
    header("Location: paginaLogin.html");
    exit();
}

$idUtente = $_SESSION['id'];
$codiceRistorante = $_POST['codiceristorante'];
$voto = intval($_POST['voto']);

// Controlla se recensione già esistente per questo utente e ristorante
$sql = "SELECT * FROM recensione WHERE idutente = ? AND codiceristorante = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $idUtente, $codiceRistorante);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['review_message'] = "Impossibile aggiungere la recensione (già esistente).";
    header("Location: benvenuto.php");
    exit();
}

// Inserisci recensione
$sql = "INSERT INTO recensione (voto, dataRecensione, idutente, codiceristorante) VALUES (?, CURDATE(), ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $voto, $idUtente, $codiceRistorante);
if ($stmt->execute()) {
    $_SESSION['review_message'] = "Recensione inserita con successo.";
} else {
    $_SESSION['review_message'] = "Impossibile aggiungere la recensione.";
}
header("Location: benvenuto.php");
exit();
?>
