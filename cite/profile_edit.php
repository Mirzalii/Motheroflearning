<?php
session_start();
require 'database.php'; // Подключите ваш файл database.php здесь

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email, profile_pic FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Проверка отправки формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Обработка загрузки фотографии
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
        // Загрузка файла и получение нового пути
        $uploadDir = 'uploads/'; // Укажите путь к директории для загрузки
        $fileName = time() . '_' . basename($_FILES['profile_pic']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadFile)) {
            // Файл успешно загружен, обновляем профиль пользователя
            $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
            $stmt->bind_param("si", $fileName, $user_id);
            $stmt->execute();

            // Перенаправление на страницу профиля или вывод сообщения об успехе
             header('Location: profile.php');
            echo 'Фотография профиля обновлена!';
        } else {
            // Ошибка загрузки файла
            echo 'Произошла ошибка при загрузке файла.';
        }
    }

    // Обновление других данных пользователя...
    // Код обработки формы будет здесь
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование профиля</title>
</head>
<body>
    <h1>Редактирование профиля</h1>
    <form action="profile_edit.php" method="post" enctype="multipart/form-data">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"><br>

        <label for="email">Электронная почта:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br>

        <label for="password">Новый пароль (оставьте пустым, если не хотите менять):</label>
        <input type="password" id="password" name="password"><br>

        <label for="profile_pic">Фото профиля (оставьте пустым, если не хотите менять):</label>
        <input type="file" id="profile_pic" name="profile_pic"><br>

        <input type="submit" value="Сохранить изменения">
    </form>
</body>
</html>
