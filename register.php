<?php
require 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (email, password, nom, prenom) VALUES (?, ?, ?, ?)");
        $stmt->execute([$email, $password, $nom, $prenom]);
        $_SESSION['success'] = "Compte créé avec succès!";
        redirect('login.php');
    } catch (PDOException $e) {
        $error = "Cet email est déjà utilisé";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="auth-container">
        <h2>Inscription</h2>
        <?php 
        if(isset($error)) echo "<p class='error'>$error</p>";
        if(isset($_SESSION['success'])) {
            echo "<p class='success'>".$_SESSION['success']."</p>";
            unset($_SESSION['success']);
        }
        ?>
        <form method="POST">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" minlength="6" required>
            <button type="submit">S'inscrire</button>
        </form>
        <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
    </div>
</body>
</html>
