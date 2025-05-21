<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titolo = trim($_POST['titolo']);
    $testo = trim($_POST['testo']);
    $data_evento = $_POST['data_evento'];
    $user_id = $_SESSION['user_id'];
    $filePath = '';

    if (!empty($_FILES['file']['name'])) {
        $fileDir = 'uploads/';
        $filePath = $fileDir . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
    }

    $stmt = $pdo->prepare("INSERT INTO ricordi (id_utente, titolo, testo, data_evento, file_path) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $titolo, $testo, $data_evento, $filePath])) {
        header("Location: profile.php");
        exit();
    } else {
        echo "<p>Errore nell'aggiunta del ricordo.</p>";
    }
}
?>

<form action="add_memory.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="titolo" placeholder="Titolo" required>
    <textarea name="testo" placeholder="Descrivi il tuo ricordo..." required></textarea>
    <input type="date" name="data_evento" >
    <button type="submit" class="btn-primary">Salva Ricordo</button>
</form>
