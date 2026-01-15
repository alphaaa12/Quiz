<?php
require 'includes/config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$stmt = $pdo->prepare("SELECT * FROM attempts WHERE user_id = ? ORDER BY attempt_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$attempts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title style="text-align: center;">Historique</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="history-container">
        <h2 style="text-align: center;">Votre historique de quiz intelligent</h2>
        
        <?php if(count($attempts) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Niveau</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($attempts as $attempt): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($attempt['attempt_date'])) ?></td>
                        <td><?= ucfirst($attempt['level']) ?></td>
                        <td><?= $attempt['score'] ?>/10</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center;">Aucun quiz complété pour le moment loser.</p>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>