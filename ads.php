<?php
require 'boot.php';

header('Content-Type: application/json');

if (!isset($_SESSION['is_auth'])) {
    echo json_encode(['success' => false]);
    exit;
}

$stmt = pdo()->query("SELECT * FROM ads ORDER BY id DESC");
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'ads' => $ads]);
exit;
?>