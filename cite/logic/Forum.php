<?php
// Стартуем сессию
session_start();

// Подключаемся к базе данных
$mysqli = new mysqli('localhost', 'root', '', 'mofl');

// Проверяем соединение
if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

// Предполагаем, что имя пользователя и ссылка на аватар уже сохранены в сессии
$username = $mysqli->real_escape_string($_SESSION['username']);
$profile_pic = $mysqli->real_escape_string($_SESSION['profile_pic']);

// Получаем комментарий из формы и очищаем его
$comment = $mysqli->real_escape_string($_POST['comment']);

// Получаем текущее время
$timestamp = date('Y-m-d H:i:s');

// Создаем SQL запрос для вставки данных
$query = "INSERT INTO comments (username, profile_pic, comment, timestamp) VALUES ('$username', '$profile_pic', '$comment', '$timestamp')";

// Выполняем запрос
if ($mysqli->query($query) === TRUE) {
    echo "Комментарий успешно добавлен";
} else {
    echo "Ошибка: " . $query . "<br>" . $mysqli->error;
}

// Закрываем соединение
$mysqli->close();
?>
