<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Загрузка информации о ранобэ</title>
</head>
<body>
    <h1>Загрузка информации о ранобэ</h1>

    <!-- Форма для персонажей -->
    <form method="post">
        <h2>Персонажи</h2>
        <input type="text" name="character_name" placeholder="Имя персонажа" required>
        <textarea name="character_description" placeholder="Описание персонажа" required></textarea>
        <textarea name="character_features" placeholder="Особенности"></textarea>
        <input type="submit" name="submit_character" value="Загрузить">
    </form>

    <!-- Форма для событий -->
    <form method="post">
        <h2>События</h2>
        <input type="number" name="event_chapter" placeholder="Глава" required>
        <textarea name="event_description" placeholder="Описание события" required></textarea>
        <input type="submit" name="submit_event" value="Загрузить">
    </form>

    <!-- Форма для магических существ -->
    <form method="post">
        <h2>Магические существа</h2>
        <input type="text" name="creature_name" placeholder="Имя существа" required>
        <textarea name="creature_description" placeholder="Описание существа" required></textarea>
        <textarea name="creature_features" placeholder="Особенности"></textarea>
        <input type="submit" name="submit_creature" value="Загрузить">
    </form>

    <!-- Форма для артефактов -->
    <form method="post">
        <h2>Артефакты</h2>
        <input type="text" name="artifact_name" placeholder="Имя артефакта" required>
        <textarea name="artifact_description" placeholder="Описание артефакта" required></textarea>
        <textarea name="artifact_powers" placeholder="Силы артефакта"></textarea>
        <input type="submit" name="submit_artifact" value="Загрузить">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Обработка данных формы для персонажей
        if (isset($_POST['submit_character'])) {
            $name = $conn->real_escape_string($_POST['character_name']);
            $description = $conn->real_escape_string($_POST['character_description']);
            $features = $conn->real_escape_string($_POST['character_features']);

            $sql = "INSERT INTO characters (name, description, features) VALUES ('$name', '$description', '$features')";
            if ($conn->query($sql) === TRUE) {
                echo "Новый персонаж успешно добавлен.";
            } else {
                echo "Ошибка: " . $sql . "<br>" . $conn->error;
            }
        }

        // Аналогично добавьте обработку данных для других форм

        // Закрытие соединения
        $conn->close();
    }
    ?>
</body>
</html>
