<?php
require '../includes/config.php';

$level = filter_input(INPUT_GET, 'level', FILTER_SANITIZE_STRING);

try {
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE level = ? ORDER BY RAND() LIMIT 10");
    $stmt->execute([$level]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($questions);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données']);
}