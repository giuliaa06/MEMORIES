<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_ricordo'])) {
    $id_ricordo = $_POST['id_ricordo'];
    $user_id = $_SESSION['user_id'];

    // Controlla se l'utente ha già messo "Mi Piace"
    $stmtCheck = $pdo->prepare("SELECT * FROM likes WHERE id_ricordo = ? AND id_utente = ?");
    $stmtCheck->execute([$id_ricordo, $user_id]);

    if ($stmtCheck->rowCount() == 0) {
        $stmtLike = $pdo->prepare("INSERT INTO likes (id_ricordo, id_utente) VALUES (?, ?)");
        $stmtLike->execute([$id_ricordo, $user_id]);
    }

    header("Location: memories.php");
    exit();
}
?>
