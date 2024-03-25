<?php
session_start();
// Подключаем файл конфигурации из папки logic
require_once 'logic/database.php';

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
// Обработка отправленной формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    // Обновление имени пользователя
    if (!empty($_POST['username'])) {
        $new_username = $_POST['username'];
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->execute([$new_username, $user_id]);
    }

    // Обновление электронной почты
    if (!empty($_POST['email'])) {
        $new_email = $_POST['email'];
        $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->execute([$new_email, $user_id]);
    }

    // Обновление пароля
    if (!empty($_POST['password'])) {
        $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$new_password, $user_id]);
    }

       // Обработка загрузки фотографии
       if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
        // Загрузка файла и получение нового пути
        $uploadDir = '/path/to/uploads/'; // Укажите путь к директории для загрузки
        $fileName = time() . '_' . basename($_FILES['profile_pic']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadFile)) {
            // Файл успешно загружен, обновляем профиль пользователя
            $stmt = $pdo->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
            $stmt->execute([$fileName, $user_id]);

            // Перенаправление на страницу профиля или вывод сообщения об успехе
            // header('Location: profile.php');
            echo 'Фотография профиля обновлена!';
        } else {
            // Ошибка загрузки файла
            echo 'Произошла ошибка при загрузке файла.';
        }
    }
    // Перенаправление на страницу профиля
    header('Location: profile.php');
    exit;
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
