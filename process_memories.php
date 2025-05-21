<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $titolo = trim($_POST['titolo']);
    $testo = trim($_POST['testo']);
    $data_evento = $_POST['data_evento'];
    $id_utente = $_SESSION['user_id'];

    $file_path = '';

    // Creazione automatica della cartella "uploads" se non esiste
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

   if (!empty($_FILES['file']['name'])) {
    $file_name = time() . "_" . basename($_FILES['file']['name']);
    $file_path = "uploads/" . $file_name;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
        echo "✅ File salvato in: " . $file_path; // DEBUG
    } else {
        echo "❌ Errore nel caricamento del file.";
        exit();
    }
}

    $stmt = $pdo->prepare("INSERT INTO ricordi (id_utente, titolo, testo, data_evento, file_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_utente, $titolo, $testo, $data_evento, $file_path]);

    header("Location: memories.php");
    exit();
}
?>
