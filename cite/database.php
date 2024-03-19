<?php
require_once 'config.php';

// Попытка подключения к базе данных MySQL
$conn = new mysqli('localhost', 'root', '', 'mofl');

// Проверка подключения
if($conn->connect_error){
    die("ERROR: Не удалось подключиться. " . $conn->connect_error);
}
?>
