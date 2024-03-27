<?php
// Настройки подключения к базе данных
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Пустой пароль для локальной базы данных
define('DB_NAME', 'mofl');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Проверяем соединение
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Путь к корневой директории вашего сайта
define('BASE_URL', 'http://localhost/index.php'); // Используйте localhost, если вы работаете локально
?>
