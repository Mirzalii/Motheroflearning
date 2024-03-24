<?php
// Проверка наличия параметра email в запросе
if (!isset($_GET['email']) || empty($_GET['email'])) {
    die('Ошибка: отсутствует адрес электронной почты.');
}

$email = $_GET['email'];

// Обработка отправленного нового пароля
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_password'])) {
    // Хеширование нового пароля
    $new_password_hashed = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Подключение к базе данных
    $host = 'localhost'; // Адрес сервера базы данных
    $dbname = 'mofl'; // Имя базы данных
    $user = 'root'; // Имя пользователя базы данных
    $pass = ''; // Пароль базы данных

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        // Установка PDO error mode на исключение
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Обновление пароля в базе данных
        $stmt = $pdo->prepare("UPDATE users SET password = :new_password WHERE email = :email");
        $stmt->execute(['new_password' => $new_password_hashed, 'email' => $email]);

        echo "Пароль успешно изменён.";
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Смена пароля</title>
</head>
<body>
    <h2>Смена пароля</h2>
    <form action="" method="post">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <label for="new_password">Новый пароль:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit">Изменить пароль</button>
    </form>
</body>
</html>
