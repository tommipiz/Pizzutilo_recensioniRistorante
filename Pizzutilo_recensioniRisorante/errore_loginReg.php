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
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color:rgb(83, 85, 224);
            font-family: Arial, sans-serif;
        }
        .error-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .error-container h2 {
            color: red;
        }
        .error-container p {
            color: #333;
        }
        .error-container a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background:rgb(74, 71, 238);
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .error-container a:hover {
            background: #ff1e5a;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h2>Errore</h2>
        <p><?php echo htmlspecialchars($error_message); ?></p>
        <a href="paginaRegistrazione.html">Torna alla pagina di registrazione</a>
    </div>
</body>
</html>
