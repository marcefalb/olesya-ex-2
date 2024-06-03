<?php
include 'boot.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверим, не занято ли имя пользователя
    $stmt = pdo()->prepare("SELECT * FROM users WHERE login = :username");
    $stmt->execute(['username' => $username]);
    if ($stmt->rowCount() > 0) {
        flash('Это имя пользователя уже занято.');
        header('Location: register.php');
        exit;
    }

    // Добавим пользователя в базу
    $stmt = pdo()->prepare("INSERT INTO users (login, password) VALUES (:username, :password)");
    $stmt->execute([
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>
    <?php if ($msg = get_flash_message()): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Логин:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>