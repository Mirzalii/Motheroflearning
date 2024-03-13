<?php
$servername = "localhost"; // Имя сервера базы данных (обычно localhost для локального сервера)
$username = "";             // Пустое имя пользователя
$password = "";             // Пустой пароль
$dbname = "mofl";           // Имя вашей базы данных

// Создание соединения с базой данных
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Проверка соединения
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

// Закрытие соединения
mysqli_close($conn);
?>
