<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: paginaLogin.html");
    exit();
}

include 'connessione.php';
$username = $_SESSION["username"];

// Recupera dati utente
$sql = "SELECT * FROM utente WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Se admin, reindirizza al pannello admin
if ($user['admin']) {
    header("Location: pannelloadmin.php");
    exit();
}

// Recupera recensioni dell'utente
$stmtReviews = $conn->prepare("SELECT r.nome AS nomeristorante, r.indirizzo, rec.voto, rec.dataRecensione AS daterec FROM recensione rec JOIN ristorante r ON rec.codiceristorante = r.codice WHERE rec.idutente = ?");
$stmtReviews->bind_param("i", $user["id"]);
$stmtReviews->execute();
$resultReviews = $stmtReviews->get_result();
$numReviews = $resultReviews->num_rows;

// Recupera lista ristoranti per il form
$resultRistoranti = $conn->query("SELECT codice, nome FROM ristorante");
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvenuto</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="welcome-container">
        <h1>Benvenuto <?php echo htmlspecialchars($user['nome']); ?>!</h1>
        <ul>
            <li><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></li>
            <li><strong>Nome:</strong> <?php echo htmlspecialchars($user['nome']); ?></li>
            <li><strong>Cognome:</strong> <?php echo htmlspecialchars($user['cognome']); ?></li>
            <li><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
            <li><strong>Data Registrazione:</strong> <?php echo htmlspecialchars($user['dataregistrazione']); ?></li>
        </ul>
        <br><br>
        <a href="scriptlogout.php" class="logout-btn">Logout</a>
    </div>

    <div class="welcome-container">
        <h2>Le tue Recensioni</h2>
        <p><strong>Numero recensioni effettuate: <?php echo $numReviews; ?></strong></p>
        <?php if ($numReviews > 0): ?>
        <table>
            <tr>
                <th>Ristorante</th>
                <th>Indirizzo</th>
                <th>Voto</th>
                <th>Data</th>
            </tr>
            <?php while($row = $resultReviews->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nomeristorante']); ?></td>
                <td><?php echo htmlspecialchars($row['indirizzo']); ?></td>
                <td><?php echo $row['voto']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['daterec'])); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?><br>
        <p>Nessuna recensione effettuata</p>
        <?php endif; ?><br><br>

        <h2>Aggiungi nuova recensione</h2>
        <form action="inseriscirecensione.php" method="post">
            <select name="codiceristorante" required>
                <option value="" disabled selected>Seleziona ristorante</option>
                <option value="cantinone">Cantinone</option>
                <option value="boschetto">Boschetto</option>
                <option value="savatino">Savatino</option>
                <option value="settimo">Settimo</option>
            </select>
            <br><br>
            <fieldset>
                <legend>Voto</legend>
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <input type="radio" name="voto" value="<?php echo $i; ?>" required> <?php echo $i; ?>
                <?php endfor; ?>
            </fieldset><br>
            <input type="submit" value="Invia recensione">
        </form><br>
        <?php if(isset($_SESSION['review_message'])): ?>
            <p><?php echo $_SESSION['review_message']; unset($_SESSION['review_message']); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
