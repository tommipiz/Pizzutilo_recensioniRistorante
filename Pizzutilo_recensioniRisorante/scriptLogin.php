<?php
    include 'connessione.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script Login</title>
</head>
<body>
<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT id, username, password, nome FROM utente WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['nome'] = $row['nome'];
                header("Location: benvenuto.php");
                exit();
            } else {
                $_SESSION['errore'] = "Password errata.";
                header("Location: errore_loginReg.php");
                exit();
            }
        } else {
            $_SESSION['errore'] = "Username non esistente.";
            header("Location: errore_loginReg.php");
            exit();
        }
    }
?>
    
</body>
</html>