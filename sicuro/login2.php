<?php
require_once('db.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $sql_value="SELECT * FROM users WHERE username = '$username' AND password='$password'"; 
    if($result=$connessione->query($sql_value)){
        if($result->num_rows == 1){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            session_start(['cookie_httponly' => true]); 
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $row['id'];
            $_SESSION['loggato'] = true;
            
            // Effettua il reindirizzamento
            header("Location: forum2.php");
            exit;
        } else {
            echo "dati non trovati";
        }
    } else {
        echo "username o password errati";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Login Sicuro</h1>
<form method="post" action="login2.php">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <button type="submit">Login</button>
</form>

</body>
</html>