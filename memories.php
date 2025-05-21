<?php
require 'config.php';
session_start();

// Recupera i ricordi dal database con il conteggio dei like
$stmtRicordi = $pdo->query("SELECT r.id_ricordo, r.titolo, r.testo, u.username, r.data_evento, r.file_path,
    (SELECT COUNT(*) FROM likes WHERE id_ricordo = r.id_ricordo) AS likes
    FROM ricordi r JOIN utenti u ON r.id_utente = u.id_utente ORDER BY r.data_evento DESC");

$ricordi = $stmtRicordi->fetchAll();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>MemoriaLink - I tuoi Ricordi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="hero">
        <h1>📖 I tuoi Ricordi</h1>
        <p>Scopri i momenti più belli e condividi nuove esperienze!</p>
    </header>

    <nav class="navbar">
        <a href="index.php">🏠 Home</a>
        <a href="profile.php">👤 Profilo</a>
        <a href="logout.php" class="btn-secondary">🚪 Logout</a>
    </nav>

    <section class="recent-memories">
        <?php foreach ($ricordi as $r): ?>
            <div class="memory-card">
                <h3><?= htmlspecialchars($r['titolo']) ?></h3>
                <p><strong>Di:</strong> <?= htmlspecialchars($r['username']) ?></p>
                <p><?= htmlspecialchars($r['testo']) ?></p>
                <p><em>Data evento:</em> <?= htmlspecialchars($r['data_evento']) ?></p>

                <?php if (!empty($r['file_path'])): ?>
                    <p><a href="<?= htmlspecialchars($r['file_path']) ?>" target="_blank" download>📄 Scarica il file</a></p>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="likes.php" method="POST">
                        <input type="hidden" name="id_ricordo" value="<?= $r['id_ricordo'] ?>">
                        <button type="submit" class="btn-like">❤️ Mi Piace (<?= $r['likes'] ?>)</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </section>

</body>
</html>
