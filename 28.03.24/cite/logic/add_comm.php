<?php
session_start();
require_once 'config.php';
require_once 'database.php';

$loggedIn = isset($_SESSION['username']);

if ($loggedIn) {
    $username = $_SESSION['username'];
    $mysqli = new mysqli('localhost', 'root', '', 'mofl');

    if ($mysqli->connect_error) {
        die('Ошибка подключения: ' . $mysqli->connect_error);
    }

    // Получаем путь к фотографии профиля из таблицы users
    $sql = "SELECT role, profile_pic FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    $profilePic = $user['profile_pic']; // Путь к фото профиля

    // Обработка отправки формы комментария
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
        $comment = $mysqli->real_escape_string($_POST['comment']);
        date_default_timezone_set('Asia/Karachi'); // Установка временной зоны GMT+5
        $timestamp = date('Y-m-d H:i:s'); // Получаем текущую дату и время по часовому поясу GMT+5
        

        // Вставляем данные комментария в таблицу comments
        $insertQuery = "INSERT INTO comments (username, profile_pic, comment, timestamp) VALUES ('$username', '$profilePic', '$comment', '$timestamp')";
        if ($mysqli->query($insertQuery)) {
            echo header('Location: ../forumpage.php');
        } else {
            echo "Ошибка: " . $mysqli->error;
        }
    }
}
?>
