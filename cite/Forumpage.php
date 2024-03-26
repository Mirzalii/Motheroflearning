<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Комментарии</title>
<style>
  .comments-container {
    width: 88%;
    margin: auto;
  }
  .comment {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    overflow: hidden;
  }
  .user-avatar {
    float: left;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
  }
  .user-info {
    overflow: hidden;
  }
  .username {
    float: left;
    margin-right: 10px;
  }
  .timestamp {
    float: left;
    color: #999;
  }
  .comment-text {
    clear: both;
    margin-top: 10px;
  }
</style>
</head>
<body>

<div class="comments-container">
  <!-- Предполагается, что комментарии будут вставлены здесь -->
  <?php
// Подключаемся к базе данных
$mysqli = new mysqli('localhost', 'root', '', 'mofl');

// Проверяем соединение
if ($mysqli->connect_error) {
    die('Ошибка подключения: ' . $mysqli->connect_error);
}

// Создаем SQL запрос для выборки комментариев
$query = "SELECT * FROM comments ORDER BY timestamp DESC";

// Выполняем запрос и получаем результат
$result = $mysqli->query($query);

// Проверяем наличие комментариев
if ($result->num_rows > 0) {
    // Выводим данные каждого комментария
    while($row = $result->fetch_assoc()) {
        echo "<div class='comment'>";
        echo "<img src='" . $row['profile_pic'] . "' alt='Аватар' class='user-avatar'>";
        echo "<div class='user-info'>";
        echo "<div class='username'>" . $row['username'] . "</div>";
        echo "<div class='timestamp'>" . $row['timestamp'] . "</div>";
        echo "</div>";
        echo "<div class='comment-text'>" . $row['comment'] . "</div>";
        echo "</div>";
    }
} else {
    echo "Комментариев пока нет.";
}

// Закрываем соединение
$mysqli->close();
?>

  <div class="comment">
    <img src="path_to_user_avatar.jpg" alt="Аватар" class="user-avatar">
    <div class="user-info">
      <div class="username">Имя пользователя</div>
      <div class="timestamp">Дата комментария</div>
    </div>
    <div class="comment-text">Текст комментария</div>
  </div>
  <!-- Конец комментария -->
</div>

</body>
</html>
