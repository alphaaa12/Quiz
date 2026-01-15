<?php
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
    http_response_code(403);
    die(json_encode(['error' => 'Accès non autorisé']));
}

// Vérifier l id et la session
$posted_user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
if ($posted_user_id !== $_SESSION['user_id']) {
    http_response_code(401);
    die(json_encode(['error' => 'Incohérence d\'identifiant utilisateur']));
}


$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
$score = filter_input(INPUT_POST, 'score', FILTER_VALIDATE_INT);
$level = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_STRING);

// Validation des données
if (!$user_id || !$score || !$level) {
    http_response_code(400);
    die(json_encode(['error' => 'Données invalides']));
}

try {
    $stmt = $pdo->prepare("INSERT INTO attempts (user_id, score, level) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $score, $level]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données']);
}