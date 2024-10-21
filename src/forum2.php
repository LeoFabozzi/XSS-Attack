<?php
// Inizializza la sessione con il flag HttpOnly
session_start(['cookie_httponly' => true]); 
require_once('db.php');

// Gestione del form per inviare un messaggio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizzazione dell'input
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
    $userId = $_SESSION['id']; 

    
    $stmt = $connessione->prepare("INSERT INTO forum_posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $userId, $title, $content);
    $result = $stmt->execute();

    if ($result) {
        echo "Messaggio inviato con successo!";
        echo "User ID: " . $_SESSION['id'];
        echo "Username: " . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
    } else {
        echo "Errore nell'inserimento: " . $connessione->error;
    }
}

// Recupera i messaggi dal database
$posts = $connessione->query("SELECT forum_posts.*, users.username FROM forum_posts JOIN users ON forum_posts.user_id = users.id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 20px; }
        h1, h2 { color: #333; }
        form { background: #fff; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-bottom: 20px; }
        input[type="text"], textarea { width: 70%; padding: 8px; margin: 5px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #4CAF50; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer;margin-right: 2000px;}
        button:hover { background-color: #45a049; }
        ul { list-style-type: none; padding: 0; }
        li { background: #fff; padding: 10px; margin: 10px 0; border-radius: 4px; border: 1px solid #ddd; }
        a { color: #337ab7; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Benvenuto nel Forum <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?></h1>
    <form method="POST" action="forum2.php">
        <input type="text" name="title" placeholder="Titolo" required>
        <textarea name="content" placeholder="Contenuto" required></textarea>
        <button type="submit">Invia</button>
    </form>

    <h2>Messaggi Recenti:</h2>
    <ul>
        <?php while ($row = $posts->fetch_assoc()): ?>
            <li>
                <strong><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></strong> 
                (da <?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?>)
                <p><?php echo htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8'); ?></p>
            </li>
        <?php endwhile; ?>
    </ul>

    <a href="logout2.php">Logout</a>
</body>
</html>