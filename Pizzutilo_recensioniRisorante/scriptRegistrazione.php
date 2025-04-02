<?php
    include 'connessione.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>script registrazione</title>
</head>
<body>
<?php
    session_start();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $nome = trim($_POST["nome"]);
        $cognome = trim($_POST["cognome"]);
        $email = trim($_POST["email"]);

        // Verifica se l'username esiste già
        $sql = "SELECT * FROM utente WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error_message'] = "Username già esistente!";
            header("Location: errore_loginReg.php");
            exit();
        }

        // Verifica se l'email esiste già
        $sql = "SELECT * FROM utente WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error_message'] = "Email già esistente!";
            header("Location: errore_loginReg.php");
            exit();
        }

        // Hash della password
        $passwordHash = hash("sha256", $password);

        // Inserisci l'utente nel database
        $sql = "INSERT INTO utente (username, password, nome, cognome, email, dataregistrazione) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $passwordHash, $nome, $cognome, $email);
        $stmt->execute();

        // Avvio la sessione per il login automatico
        $_SESSION["username"] = $username;
        header("Location: benvenuto.php");
        exit();
    }
?>
</body>
</html>