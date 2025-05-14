<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: paginaLogin.html");
    exit();
}
include 'connessione.php';

$username = $_SESSION['username'];
// Controlla se admin
$stmt = $conn->prepare("SELECT admin FROM utente WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
if (!$user['admin']) {
    header("Location: benvenuto.php");
    exit();
}

// Recupera ristoranti e numero di recensioni
$sql = "SELECT r.codice, r.nome, r.indirizzo, r.citta, COUNT(rec.idrecensione) AS numrec
        FROM ristorante r
        LEFT JOIN recensione rec ON r.codice = rec.codiceristorante
        GROUP BY r.codice, r.nome, r.indirizzo, r.citta";
$resultRistoranti = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="admin-container">
        <h1>Pannello Admin</h1>

        <?php if(isset($_SESSION['ristorante_message'])): ?>
            <p><?php echo $_SESSION['ristorante_message']; unset($_SESSION['ristorante_message']); ?></p>
        <?php endif; ?>

        <table>
            <tr>
                <th>Codice</th>
                <th>Nome</th>
                <th>Indirizzo</th>
                <th>Città</th>
                <th>Numero Recensioni</th>
            </tr>
            <?php while($row = $resultRistoranti->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['codice']); ?></td>
                <td><?php echo htmlspecialchars($row['nome']); ?></td>
                <td><?php echo htmlspecialchars($row['indirizzo']); ?></td>
                <td><?php echo htmlspecialchars($row['citta']); ?></td>
                <td><?php echo $row['numrec']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <h2>Aggiungi nuovo ristorante</h2>
        <form action="inserisciristorante.php" method="post">
            <input type="text" name="codice" placeholder="Codice (chiave primaria)" required>
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="text" name="indirizzo" placeholder="Indirizzo" required>
            <input type="text" name="citta" placeholder="Città" required>
            <input type="submit" value="Inserisci ristorante">
        </form>
    </div>
</body>
</html>
