<?php
session_start();
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "Errore sconosciuto.";
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Errore</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="error-container">
        <h2>Errore</h2>
        <p><?php echo htmlspecialchars($error_message); ?></p>
        <a href="paginaRegistrazione.html">Vai alla pagina di registrazione</a><br>
        <a href="paginaLogin.html">Torna alla pagina di Login</a>
    </div>
</body>
</html>
