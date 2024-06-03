<?php
include 'boot.php';

header('Content-Type: application/json');

if (!isset($_SESSION['is_auth'])) {
    echo json_encode(['success' => false]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad_text = $_POST['ad_text'];

    $stmt = pdo()->prepare("INSERT INTO ads (user, ad_text) VALUES (:user, :ad_text)");
    $stmt->execute([
        'user' => $_SESSION['login'],
        'ad_text' => $ad_text
    ]);

    echo json_encode(['success' => true, 'ad_text' => $ad_text]);
    exit;
}

echo json_encode(['success' => false]);
exit;
?>