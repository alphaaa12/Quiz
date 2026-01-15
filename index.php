<?php
 require 'includes/config.php';

// verifier est ce que connecte
if (isLoggedIn()) {
    redirect('quiz.php');
}

$pageTitle = "Accueil - Quiz PHP";
?>
<?php include 'includes/header.php'; ?>

<div class="hero">
    <div class="hero-content">
        <h1>Testez vos connaissances en PHP</h1>
        <p>Améliorez vos compétences en PHP grâce à nos quiz interactifs et progressifs !</p>
        
        <div class="cta-buttons">
            <?php if (!isLoggedIn()): ?>
                <a href="register.php" class="btn btn-primary">Commencer maintenant</a>
                <a href="login.php" class="btn btn-secondary">Se connecter</a>
            <?php else: ?>
                <a href="quiz.php" class="btn btn-primary">Continuer le quiz</a>
                <a href="history.php" class="btn btn-secondary">Voir l'historique</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="features">
    <div class="feature-card">
        <h3>📚 Quiz par niveau</h3>
        <p>3 niveaux de difficulté adaptés à votre progression</p>
    </div>
    
    <div class="feature-card">
        <h3>⚡ Corrections instantanées</h3>
        <p>Apprenez de vos erreurs grâce aux explications détaillées</p>
    </div>
    
    <div class="feature-card">
        <h3>📈 Suivi de progression</h3>
        <p>Consultez vos statistiques et améliorez vos performances</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
