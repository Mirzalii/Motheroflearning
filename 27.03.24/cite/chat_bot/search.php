<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поиск по ранобэ</title>
</head>
<body>
    <h1>Поиск по ранобэ</h1>

    <!-- Форма поиска -->
    <form method="post">
        <input type="text" name="search_query" placeholder="Введите ключевые слова" required>
        <input type="submit" name="submit_search" value="Поиск">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_search'])) {
        // Параметры подключения к базе данных
        $servername = "localhost";
        $username = "root"; // Имя пользователя по умолчанию в XAMPP
        $password = ""; // Пароль по умолчанию в XAMPP
        $dbname = "mofl"; // Имя вашей базы данных

        // Создание соединения
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Проверка соединения
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Получение ключевых слов из формы поиска
        $search_query = $conn->real_escape_string($_POST['search_query']);

        // Поиск по ключевым словам в таблицах
        $sql = "SELECT 'Персонаж' as type, name, description, features FROM characters WHERE name LIKE '%$search_query%' OR description LIKE '%$search_query%' OR features LIKE '%$search_query%'
                UNION
                SELECT 'Событие' as type, chapter as name, description, NULL as features FROM events WHERE description LIKE '%$search_query%'
                UNION
                SELECT 'Существо' as type, name, description, features FROM magical_creatures WHERE name LIKE '%$search_query%' OR description LIKE '%$search_query%'
                UNION
                SELECT 'Артефакт' as type, name, description, NULL as features FROM artifacts WHERE name LIKE '%$search_query%' OR description LIKE '%$search_query%'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Вывод результатов поиска
            while($row = $result->fetch_assoc()) {
                echo "<p><strong>" . $row["type"] . ":</strong> " . $row["name"] . "<br>" . $row["description"];
                // Проверка наличия ключа 'features' перед выводом
                if (isset($row["features"]) && $row["features"] != NULL) {
                    echo "<br><strong>Особенности:</strong> " . $row["features"];
                }
                echo "</p>";
            }
        } else {
            echo "Результатов не найдено.";
        }

        // Закрытие соединения
        $conn->close();
    }
    ?>
</body>
</html>
