<?php
session_start();

// Подключение к базе данных
$host = 'localhost'; // Адрес сервера базы данных
$dbname = 'mofl'; // Имя базы данных
$user = 'root'; // Имя пользователя базы данных
$pass = ''; // Пароль базы данных

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // Установка PDO error mode на исключение
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Не удалось подключиться к базе данных: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Проверка существует ли пользователь с такой электронной почтой
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Генерация уникального кода восстановления
        $reset_code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Сохранение кода восстановления в базе данных
        $stmt = $pdo->prepare("UPDATE users SET reset_code = :reset_code WHERE email = :email");
        $stmt->execute(['reset_code' => $reset_code, 'email' => $email]);

        // Сохранение email в сессии
        $_SESSION['email_for_reset'] = $email;

        // Отправка кода восстановления на email пользователя
        // Формирование тела письма
        $subject = 'Восстановление пароля';
        $body = "Ваш код восстановления: $reset_code";

        // Вызов Python скрипта для отправки письма
        $command = escapeshellcmd("python send_email.py " . escapeshellarg($email) . " " . escapeshellarg($subject) . " " . escapeshellarg($body));
$output = shell_exec($command);
        // Перенаправление на страницу ввода кода восстановления
        header("Location: verify_code.php");
        exit;
    } else {
        echo "Пользователь с такой электронной почтой не найден.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Восстановление пароля</title>
</head>
<body>
    <h2>Форма запроса восстановления пароля</h2>
    <form action="code.php" method="post">
        <label for="email">Введите вашу электронную почту:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Отправить код восстановления</button>
    </form>
</body>
</html>
