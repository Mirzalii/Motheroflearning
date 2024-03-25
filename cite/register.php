<?php
// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Подключаемся к базе данных
    $db = new mysqli('localhost', 'root', '', 'mofl');

    // Проверяем подключение
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Получаем данные из формы
    $username = $db->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хешируем пароль
    $email = $db->real_escape_string($_POST['email']);

    // Подготавливаем SQL запрос для вставки данных
    $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";

    // Выполняем запрос и проверяем результат
    if ($db->query($query) === TRUE) {
        echo     header('Location: index.php');
        exit;
    } else {
        echo "Ошибка: " . $db->error;
    }

    // Закрываем соединение
    $db->close();
}
?>
