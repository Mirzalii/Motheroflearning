<?php
session_start();
require_once 'logic/config.php';
require_once 'logic/database.php';

$loggedIn = isset($_SESSION['username']);

if ($loggedIn) {
    $username = $_SESSION['username'];
    $mysqli = new mysqli('localhost', 'root', '', 'mofl');

    if ($mysqli->connect_error) {
        die('Ошибка подключения: ' . $mysqli->connect_error);
    }

    $sql = "SELECT role, profile_pic FROM users WHERE username = '$username'";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    $role = $user['role'];
    $profilePic = $user['profile_pic'];
    $isAdmin = $role === 'admin';

    // Обработка отправки формы
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
        $comment = $mysqli->real_escape_string($_POST['comment']);
        

        // Вставляем данные комментария в таблицу
        $insertQuery = "INSERT INTO comments (username, profile_pic, comment, timestamp) VALUES ('$username', '$profilePic', '$comment', '$timestamp')";
        if ($mysqli->query($insertQuery)) {
            echo "Комментарий добавлен!";
        } else {
            echo "Ошибка: " . $mysqli->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Форум</title>
  <link rel="stylesheet" href="css/comm.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>

<!-- Навигационная панель -->
<nav id="navbar">
<a href="index.php" id="logo">Mother of Learning</a>
<div id="menu">
    <div id="gl">
      <a href="index.php">Главная страница</a>
      <a href="read.php">Начать читать</a>
      <a href="fanarts.php">Фан арты</a>
    </div>
    </div>
    <div id="auth">
    <?php if ($loggedIn): ?>
    <a href="profile.php" id="userProfileLink" style="display: flex; align-items: center; width: 6%; height: 5%; text-decoration: none;">
      <div id="profilePicContainer" style="flex-shrink: 0;">
        <img src="<?php echo $profilePic ?? 'img/slide1.jfif'; ?>" alt="Profile Picture" style="width: 100%; height: auto; border-radius: 50%;">
      </div>
      <span id="username" style="margin-left: 10px;"><?php echo htmlspecialchars($username); ?></span>
    </a>
  <?php else: ?>
    <button id="loginBtn">Войти</button>
<button id="registerBtn">Зарегистрироваться</button>
  <?php endif; ?>
  </div>
</nav>
<!-- Модальное окно входа -->
<div id="loginModal" class="modal">
  <div class="modal-content">
    <h2>Вход</h2>
    <!-- Форма входа -->
    <form id="loginForm" method="post" action="logic/login.php">
      <p><label for="loginUsername">Имя пользователя:</label></p>
      <input type="text" id="loginUsername" name="username" required>
      <p><label for="loginPassword">Пароль:</label></p>
      <input type="password" id="loginPassword" name="password" required>
      <input type="submit" value="Войти">
      <!-- Ссылка на страницу сброса пароля -->
      <p><a href="reset/code.php">Забыли пароль?</a></p>
    </form>
  </div>
</div>
<!-- Модальное окно регистрации -->
<div id="registerModal" class="modal">
  <div class="modal-content">

    <h2>Регистрация</h2>
    <!-- Форма регистрации -->
    <form id="registerForm" method="post" action="logic/register.php">
    <label for="username"><p>Имя пользователя:</p> </label>
      <input type="text" id="username" name="username" required>
     <p><label for="password">Пароль:</label></p> 
      <input type="password" id="password" name="password" required>
      <p><label for="email">Email:</label></p> 
      <input type="email" id="email" name="email">
      <input type="submit" value="Зарегистрироваться">
        </form>
  </div>
</div>

  <div class="comm">
    <div class="butt">
<!-- Кнопка для открытия модального окна -->
<button id="openModal">Написать комментарий</button>
</div>
<!-- Модальное окно -->
<div id="myModal" class="modal">
  <!-- Содержимое модального окна -->
  <div class="modal-content">
    <form action="logic/add_comm.php" method="post">
      <label for="comment">Комментарий:</label>
      <textarea id="comment" name="comment" required></textarea>
      <input type="submit" value="Отправить">
    </form>
  </div>
</div>
<?php
// Вывод комментариев из базы данных
// Вывод комментариев из базы данных
$query = "SELECT id, username, profile_pic, comment, timestamp FROM comments ORDER BY timestamp DESC";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='comment-card'>";
        echo "<div class='avatar-container'>";
        echo "<img src='" . $row['profile_pic'] . "' alt='Аватар' class='user-avatar'>";
        echo "</div>";
        echo "<div class='comment-content'>";
        echo "<div class='username'>" . $row['username'] . "</div>";
        echo "<div class='timestamp'>" . $row['timestamp'] . "</div>";
        echo "<div class='comment-text'>" . $row['comment'] . "</div>";
        // Кнопка удаления, доступная только администраторам
        if ($isAdmin) {
            echo "<div class='delete-button'>";
            echo "<form action='logic/delete_comment.php' method='POST'>";
            echo "<input type='hidden' name='comment_id' value='" . $row['id'] . "'>";
            echo "<input type='submit' value='Удалить'>";
            echo "</form>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "Комментариев пока нет.";
}

?>    

</div>

<script src="modal.js"></script>
<script>
// Получаем модальное окно
var modal = document.getElementById('myModal');

// Получаем кнопку, которая открывает модальное окно
var btn = document.getElementById('openModal');

// Когда пользователь нажимает на кнопку, откройте модальное окно
btn.onclick = function() {
  modal.style.display = 'block';
}

// Когда пользователь нажимает в любом месте за пределами модального окна, закройте его
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = 'none';
  }
}
</script>
</body>
</html>
