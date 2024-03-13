<?php
// Подключение к базе данных
$servername = "localhost"; // Имя сервера базы данных
$username = "username"; // Имя пользователя базы данных
$password = "password"; // Пароль пользователя базы данных
$dbname = "mofl"; // Имя базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $mofl);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL-запрос для выборки первых 6 записей из таблицы fanarts
$sql = "SELECT * FROM fanarts LIMIT 6";

// Выполнение запроса
$result = $conn->query($sql);

// Проверка наличия результатов
if ($result->num_rows > 0) {
    // Создание массива для хранения результатов
    $fanarts = array();

    // Заполнение массива результатами
    while($row = $result->fetch_assoc()) {
        $fanarts[] = $row;
    }

    // Вывод результатов в формате JSON
    echo json_encode($fanarts);
} else {
    echo "0 results";
}

// Закрытие подключения
$conn->close();
?>
