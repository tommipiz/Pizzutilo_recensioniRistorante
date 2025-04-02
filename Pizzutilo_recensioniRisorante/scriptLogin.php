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
      $username = trim($_POST["username"]);
      $password = trim($_POST["password"]);
  
  
      $sql = "SELECT * FROM utente WHERE username = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();
  
      if ($result->num_rows == 1) {
          $row = $result->fetch_assoc();
          
          if (password_verify($password, $row["password"])) {
              $_SESSION["username"] = $row["username"];
              header("Location: benvenuto.php");
              exit();
          } else {
              $_SESSION['error_message'] = "Password errata.";
              header("Location: errore_loginReg.php");
              exit();
          }
      } else {
          $_SESSION['error_message'] = "Username non esistente.";
          header("Location: errore_loginReg.php");
          exit();
      }
  } 
  ?>
    
</body>
</html>