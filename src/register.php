<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conferma_pass = $_POST['conferma_password'];

    if ($conferma_pass == $password) {
        // Query non sicura, vulnerabile a SQL Injection
        $sql_insert = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        
        if ($connessione->query($sql_insert)) {
            echo "Nuovo utente registrato";
            header("Location: index.php");
            exit;
        } else {
            echo "Errore: " . $sql_insert . "<br>" . $connessione->error;
        }
    } else {
        echo "Le due password non coincidono, riprova";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Register</h1>
    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password: </label>
        <input type="password" id="password" name="password" required>
        <label for="conferma_password">Conferma Password: </label>
        <input type="password" id="conferma_password" name="conferma_password" required>
        <button type="submit">Registrati</button>
    </form>
</body>
</html>

