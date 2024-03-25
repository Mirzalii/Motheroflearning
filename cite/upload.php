<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Проверка, является ли файл изображением
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        // Попытка загрузить файл
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "Файл ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " был загружен.";

            // Подключение к базе данных
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "mofl";

            // Создание соединения
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Проверка соединения
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL-запрос для вставки пути к изображению в базу данных
            $sql = "INSERT INTO fanarts (img) VALUES ('" . $target_file . "')";

            if ($conn->query($sql) === TRUE) {
                echo         header('Location: fanarts.php');;
            } else {
                echo "Ошибка: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "Извините, при загрузке вашего файла произошла ошибка.";
        }
    } else {
        echo "Файл не является изображением.";
    }
}
?>