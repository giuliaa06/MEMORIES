<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM utenti WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id_utente'];
        $_SESSION['username'] = $user['username'];
        header("Location: memories.php");
        exit();
    } else {
        echo "<p style='color: red; text-align: center;'>❌ Credenziali errate. Riprova.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login - MemoriaLink</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="hero">
        <h1>🔑 Accedi a MemoriaLink</h1>
        <p>Inserisci le tue credenziali per entrare nel tuo spazio personale.</p>
    </header>

    <section class="form-container">
        <form action="login.php" method="POST"> <!-- Corretta l'action -->
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn-primary">Accedi</button>
        </form>
        <p class="small-text"><a href="register.php">Non sei ancora registrato? Registrati ora!</a></p>
    </section>

</body>
</html>
