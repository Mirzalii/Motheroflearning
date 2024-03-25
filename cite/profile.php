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

// Обработка нажатия кнопки выхода
if (isset($_POST['logout'])) {
    // Завершение сессии
    session_destroy();

    // Перенаправление на страницу входа
    header('Location: index.php');
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
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/main.css">

</head>
<body>
    <div class="profile">

            <div>
            <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Фото профиля">  
            </div>
            <div>
            <h1><?php echo htmlspecialchars($user['username']); ?></h1>   
            </div>
            <div>
            <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <div>
            <a href="profile_edit.php">Редактировать профиль</a>
            </div>
            <div>
            <a href="index.php">Главная страница</a>
            </div>
            <div>
        <!-- Форма выхода -->
        <form method="post">
        <input type="submit" name="logout" value="Выйти">
        </form>
</div>
    </div>
</body>
</html>
