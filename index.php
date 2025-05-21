<?php
require 'config.php';
session_start();

// Recupera i ricordi dal database
$stmtRicordi = $pdo->query("SELECT r.id_ricordo, r.titolo, r.testo, u.username, r.data_evento, r.file_path,
    (SELECT COUNT(*) FROM likes WHERE id_ricordo = r.id_ricordo) AS likes
    FROM ricordi r JOIN utenti u ON r.id_utente = u.id_utente ORDER BY r.data_evento DESC");

$ricordi = $stmtRicordi->fetchAll();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>MemoriaLink - Ricordi e Commenti</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="hero">
        <h1>🌠 MemoriesMy</h1>
        <p>Benvenuto nel tuo spazio personale, dove i tuoi ricordi prendono vita.</p>
    </header>

    <nav class="navbar">
        <a href="index.php">🏠 Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php">👤 Profilo</a>
            <a href="logout.php" class="btn-secondary">🚪 Logout</a>
        <?php endif; ?>
    </nav>

   <?php if (!isset($_SESSION['user_id'])): ?>
    <section class="auth-options">
        <a href="login.php" class="btn-primary">🚀 ACCEDI AL TUO MONDO</a>
        <p class="small-text"><a href="register.php">Non sei ancora registrato? Registrati ora!</a></p>
    </section>
<?php endif; ?>


    <section class="recent-memories">
        <h2>📖 Ricordi Condivisi</h2>
        <?php foreach ($ricordi as $r): ?>
            <div class="memory-card">
                <h3><?= htmlspecialchars($r['titolo']) ?></h3>
                <p><strong>Di:</strong> <?= htmlspecialchars($r['username']) ?></p>
                <p><?= htmlspecialchars($r['testo']) ?></p>
                <p><em>Data evento:</em> <?= htmlspecialchars($r['data_evento']) ?></p>

                <?php if (!empty($r['file_path'])): ?>
                    <p><a href="<?= htmlspecialchars($r['file_path']) ?>" target="_blank">📄 Visualizza il ricordo</a></p>
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
