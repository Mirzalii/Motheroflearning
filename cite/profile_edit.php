<?php
session_start();
// Подключаем файл конфигурации из папки logic
require_once 'logic/database.php';

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, email, profile_pic FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

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
            $stmt = $pdo->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
            $stmt->execute([$uploadFile, $user_id]);
         
        } else {
            // Ошибка загрузки файла
            echo 'Произошла ошибка при загрузке файла.';
        }
    }
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
        session_destroy();
    
        // Перенаправление на страницу входа
        header('Location: index.php');
        exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование профиля</title>
    <link rel="stylesheet" href="css/profile_edit.css">
</head>
<body>
    <div class="profile-edit">
        <h1>Редактирование профиля</h1>
        <form action="profile_edit.php" method="post" enctype="multipart/form-data">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"><br>

        <label for="email">Электронная почта:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br>

        <label for="password">Новый пароль (оставьте пустым, если не хотите менять):</label>
        <input type="password" id="password" name="password"><br>

            <label for="profile_pic">Фото профиля (оставьте пустым, если не хотите менять):</label>
            <input type="file" id="profile_pic" name="profile_pic">
            <div class="butt"> <button type="button" onclick="document.getElementById('profile_pic').click();">Выберите файл</button> <!-- Кнопка для загрузки файла --></div>

            <div class="butt"><input type="submit" value="Сохранить изменения"></div>
        </form>
    </div>
</body>
</html>