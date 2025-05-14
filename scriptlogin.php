<?php
session_start();
include 'connessione.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Verifica username
    $sql = "SELECT * FROM utente WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['error_message'] = "Username non trovato.";
        header("Location: errore_loginReg.php");
        exit();
    }

    $user = $result->fetch_assoc();
    // Verifica password
    if (password_verify($password, $user['password'])) {
        $_SESSION["username"] = $user["username"];
        $_SESSION["id"] = $user["id"];
        $_SESSION["admin"] = $user["admin"];
        // Redirect in base al ruolo
        if ($user["admin"]) {
            header("Location: pannelloadmin.php");
        } else {
            header("Location: benvenuto.php");
        }
        exit();
    } else {
        $_SESSION['error_message'] = "Password errata.";
        header("Location: errore_loginReg.php");
        exit();
    }
}
?>
