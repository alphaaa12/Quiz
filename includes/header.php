<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Quiz PHP' ?></title>
<link rel="stylesheet" href="css/style.css?v=1.0">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">TUNIQUIZ</a>
            <div class="nav-links">
                <?php if(isLoggedIn()): ?>
                    <a href="quiz.php" <?= $current_page === 'quiz.php' ? 'class="active"' : '' ?>>Quiz</a>
                    <a href="history.php" <?= $current_page === 'history.php' ? 'class="active"' : '' ?>>Historique</a>
                    <a href="logout.php">Déconnexion</a>
                <?php else: ?>
                    <a href="login.php" <?= $current_page === 'login.php' ? 'class="active"' : '' ?>>Connexion</a>
                    <a href="register.php" <?= $current_page === 'register.php' ? 'class="active"' : '' ?>>Inscription</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>