<?php
// Файл login.php
session_start(); // Начало сессии

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Подключение к базе данных
  $db = new mysqli('localhost', 'root', '', 'mofl');

  // Проверка подключения
  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
  }

  // Получение данных из формы
  $username = $db->real_escape_string($_POST['username']);
  $password = $_POST['password'];

  // Проверка учетных данных пользователя
  $query = "SELECT id, password FROM users WHERE username = '$username'";
  $result = $db->query($query);

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      // Установка данных пользователя в сессию
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $username;
      header("Location: index.php"); // Перенаправление на страницу приветствия
    } else {
      echo "Неверный пароль!";
    }
  } else {
    echo "Пользователь не найден!";
  }

  $db->close();
}
?>
