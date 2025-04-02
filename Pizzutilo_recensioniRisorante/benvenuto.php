<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: paginalogin.html");
    exit();
}

include 'connessione.php';
$username = $_SESSION["username"];

// Recupera i dati dell'utente dal database
$sql = "SELECT * FROM utente WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvenuto</title>
</head>
<style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('./images/restaurant-background.jpg') no-repeat center center/cover;
            text-align: center;
            color: #fff;
        }
        .welcome-container {
            background: rgba(0, 0, 0, 0.5);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        .welcome-container h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color:rgb(137, 130, 235);
            text-transform: uppercase;
        }
        .welcome-container ul {
            list-style-type: none;
            padding: 0;
        }
        .welcome-container ul li {
            font-size: 18px;
            margin: 10px 0;
        }
        .logout-btn {
            background:rgb(49, 60, 212);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }
        .logout-btn:hover {
            background:rgb(75, 53, 197);
        }
    </style>
<body>
    <div class="welcome-container">
        <h1>Benvenuto  <?php echo htmlspecialchars($user['nome']); ?>!</h1>
        <p>Sei stato registrato con successo! Ecco i tuoi dettagli:</p>
        <ul>
            <li><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></li>
            <li><strong>Nome:</strong> <?php echo htmlspecialchars($user['nome']); ?></li>
            <li><strong>Cognome:</strong> <?php echo htmlspecialchars($user['cognome']); ?></li>
            <li><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
            <li><strong>Data Registrazione:</strong> <?php echo htmlspecialchars($user['dataregistrazione']); ?></li>
        </ul>
        <a href="scriptLogout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
