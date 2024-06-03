<?php
include 'boot.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = pdo()->prepare("SELECT * FROM users WHERE login = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['is_auth'] = true;
        $_SESSION['login'] = $username;
        header('Location: index.php');
        exit;
    } else {
        flash('Неверный логин или пароль.');
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
</head>
<body>
    <h1>Авторизация</h1>
    <?php if ($msg = get_flash_message()): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Логин:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Войти</button>
    </form>
</body>
</html>