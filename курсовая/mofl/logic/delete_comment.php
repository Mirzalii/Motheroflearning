<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'mofl');

// Проверка подключения
if ($mysqli->connect_error) {
    die('Ошибка подключения: ' . $mysqli->connect_error);
}

// Проверка отправки формы и наличия ID комментария
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment_id'])) {
    $comment_id = $_POST['comment_id'];

    // Подготовка запроса на удаление комментария
    $stmt = $mysqli->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->bind_param('i', $comment_id); // 'i' указывает на тип параметра - integer

    // Выполнение запроса
    if ($stmt->execute()) {
        // Если комментарий успешно удален, перенаправляем на страницу с комментариями
        header('Location: ../forumpage.php');
    } else {
        // Если произошла ошибка, выводим сообщение
        echo "Произошла ошибка при удалении комментария.";
    }

    // Закрытие запроса
    $stmt->close();
} else {
    // Если форма не была отправлена или ID комментария отсутствует, перенаправляем на страницу с комментариями
    header('Location: ../forumpage.php');
}
?>
