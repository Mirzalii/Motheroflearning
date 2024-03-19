<?php
session_start();

// Подключение к базе данных
$host = 'localhost';
$db = 'mofl';
$user = 'root';
$pass = '';

// Создание подключения
$conn = new mysqli($host, $user, $pass, $db);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Получение данных пользователя
$user_id = $_SESSION['user_id'];
$query = "SELECT username, email, profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Закрытие подключения
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
</head>
<body>
    <h1>Профиль пользователя</h1>
    <p>Имя пользователя: <?php echo htmlspecialchars($user['username']); ?></p>
    <p>Электронная почта: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Фото профиля:</p>
    <?php if ($user['profile_pic']): ?>
        <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Фото профиля">
    <?php endif; ?>
    <a href="profile_edit.php">Редактировать профиль</a>
</body>
</html>
