<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Errore Login/Registrazione</title>
</head>
<body>
    <h1>Errore di Login/Registrazione</h1>
    <p>
        <?php
            session_start();
            if (isset($_SESSION['errore'])) {
                echo $_SESSION['errore'];
                unset($_SESSION['errore']);
            } else {
                echo "Si è verificato un errore sconosciuto.";
            }
        ?>
    </p>
    <a href="paginaLogin.html">Torna alla pagina di login</a>
    
</body>
</html>