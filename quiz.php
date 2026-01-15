<?php
require 'includes/config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

// Définir de variable js
echo '<script>const USER_ID = ' . json_encode($_SESSION['user_id'] ?? null) . ';</script>';

$levels = ['débutant', 'intermédiaire', 'expert'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>TUNIQUIZ</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="quiz-interface">
    <div class="level-selector">
    <h2>Choisissez votre niveau :</h2>
    <div class="level-buttons">
    
        <button 
            class="level-btn" 
            data-level="débutant"
            data-testid="level-debutant"
        >
        <div class="original">débutant</div>
  <div class="letters">
    
    <span>d</span>
    <span>é</span>
    <span>b</span>
    <span>u</span>
    <span>t</span>
    <span>a</span>
    <span>n</span>
    <span>t</span>
  </div>
        </button>
        <br>
        <br>
        <button 
            class="level-btn" 
            data-level="intermédiaire"
            data-testid="level-intermediaire"
        >
        <div class="original">Intermédiaire</div>
  <div class="letters">
    
    <span>I</span>
    <span>n</span>
    <span>t</span>
    <span>e</span>
    <span>r</span>
    <span>m</span>
    <span>é</span>
    <span>d</span>
    <span>i</span>
    <span>a</span>
    <span>i</span>
    <span>r</span>
    <span>e</span>
  </div>
        </button>
        <br>
        <br>
        <button 
            class="level-btn" 
            data-level="expert"
            data-testid="level-expert"
        >
        <div class="original">Expert</div>
  <div class="letters">
    
    <span>E</span>
    <span>x</span>
    <span>p</span>
    <span>e</span>
    <span>r</span>
    <span>t</span>
      </div>
        </button>
        </div>
    </div>
</div>

        <div class="quiz-area" style="display:none;">
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <div class="question-container"></div>
            <div class="options-container"></div>
            <button class="next-btn">Question suivante</button>
        </div>

        <div class="score-container" style="display:none;"></div>
    </div>

    <script src="js/quiz.js"></script>
</body>
</html>