<?php
require 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

$stmtRicordiPersonali = $pdo->prepare("SELECT titolo, testo, data_evento, file_path FROM ricordi WHERE id_utente = ? ORDER BY data_evento DESC");
$stmtRicordiPersonali->execute([$user_id]);
$ricordiPersonali = $stmtRicordiPersonali->fetchAll();

$stmtLikedMemories = $pdo->prepare("SELECT r.titolo, r.testo, r.data_evento, r.file_path, u.username
    FROM likes l JOIN ricordi r ON l.id_ricordo = r.id_ricordo
    JOIN utenti u ON r.id_utente = u.id_utente WHERE l.id_utente = ?");
$stmtLikedMemories->execute([$user_id]);
$likedMemories = $stmtLikedMemories->fetchAll();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Profilo di <?= htmlspecialchars($_SESSION['username']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="hero">
        <h1>👤 Profilo di <?= htmlspecialchars($_SESSION['username']) ?></h1>
        <p>I tuoi ricordi</p>
    </header>
<form action="logout.php" method="POST">
    <button type="submit" class="btn-primary">Logout</button>
</form>

 

    <section class="add-memory">
        <h2>📝 Aggiungi un Ricordo</h2>
        <form action="add_memory.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="titolo" placeholder="Titolo" required>
            <textarea name="testo" placeholder="Descrivi il tuo ricordo..." required></textarea>
            <input type="date" name="data_evento" required>
            <input type="file" name="file">
            <button type="submit" class="btn-primary">Salva Ricordo</button>
        </form>
    </section>

    <section class="personal-memories">
        <h2>🌟 I tuoi ricordi</h2>
        <?php foreach ($ricordiPersonali as $r): ?>
            <div class="memory-card">
                <h3><?= htmlspecialchars($r['titolo']) ?></h3>
                <p><?= htmlspecialchars($r['testo']) ?></p>
                <p><em>Data evento:</em> <?= htmlspecialchars($r['data_evento']) ?></p>
                <?php if (!empty($r['file_path'])): ?>
                    <p><a href="<?= htmlspecialchars($r['file_path']) ?>" target="_blank">📄 Visualizza il file</a></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>

    <form action="index.php" method="POST">
    <button type="submit" class="btn-primary">🔙 Tornare indietro</button>
</form>


    <section class="liked-memories">
        <h2>❤️ Ricordi a cui hai messo "Mi Piace"</h2>
        <?php foreach ($likedMemories as $r): ?>
            <div class="memory-card">
                <h3><?= htmlspecialchars($r['titolo']) ?></h3>
                <p><strong>Di:</strong> <?= htmlspecialchars($r['username']) ?></p>
                <p><?= htmlspecialchars($r['testo']) ?></p>
                <p><em>Data evento:</em> <?= htmlspecialchars($r['data_evento']) ?></p>
                <?php if (!empty($r['file_path'])): ?>
                    <p><a href="<?= htmlspecialchars($r['file_path']) ?>" target="_blank">📄 Visualizza il file</a></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>

</body>
</html>
