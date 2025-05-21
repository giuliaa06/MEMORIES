<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO utenti (nome, email, username, password) VALUES (?, ?, ?, ?)");
    
    if ($stmt->execute([$nome, $email, $username, $password])) {
        header("Location: login.php");
        exit();
    } else {
        echo "<p>Errore nella registrazione. Riprova.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione - MemoriaLink</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <section class="form-container">
        <h2>Registrati su MemoriaLink</h2>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn-primary">Registrati</button>
        </form>
    </section>

</body>
</html>
