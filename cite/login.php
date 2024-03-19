<?php
session_start(); // Начинаем сессию

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
    $password = $_POST['password'];

    // Подготавливаем SQL запрос для выборки данных пользователя
    $query = "SELECT id, password FROM users WHERE username = '$username'";

    // Выполняем запрос и проверяем результат
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Устанавливаем данные пользователя в сессию
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header("Location: index.php"); // Перенаправляем на страницу приветствия
        } else {
            echo "Неверный пароль!";
        }
    } else {
        echo "Пользователь не найден!";
    }

    // Закрываем соединение
    $db->close();
}
?>
