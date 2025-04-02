<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvenuto</title>
</head>
<body>
    <h2>Benvenuto <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h2>
    <a href="scriptLogout.php">Logout</a>   
</body>
</html>