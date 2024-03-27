<?php
session_start();
// Подключаем файл конфигурации из папки logic
require_once 'logic/config.php';
require_once 'logic/database.php';
// Проверяем, вошел ли пользователь в систему
$loggedIn = isset($_SESSION['username']);

// Если пользователь вошел в систему, получаем его роль и фотографию профиля
if ($loggedIn) {
    // Получаем имя пользователя из сессии
    $username = $_SESSION['username'];

    // Получаем роль и фотографию профиля пользователя из базы данных
    $sql = "SELECT role, profile_pic FROM users WHERE username = '$username'";
    $result = mysqli_query($link, $sql);
    $user = mysqli_fetch_assoc($result);
    $role = $user['role'];
    $profilePic = $user['profile_pic'];

    // Проверяем, является ли пользователь администратором
    $isAdmin = $role === 'admin';
} else {
    $isAdmin = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список глав</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/read.css">
</head>
<body>
<!-- Навигационная панель -->
<nav id="navbar">
<a href="index.php" id="logo">Mother of Learning</a>
    <div id="menu">
    <div id="gl">
      <a href="index.php">Главная страница</a>
      <a href="fanarts.php">Фан арты</a>
      <a href="forumpage.php">Форум</a>
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
<div class="read">
<div class="read-content">
<?php
echo "<a href='chapter.php?id=1'>Начать читать</a>";
if (isset($_COOKIE["last_read_chapter"])) {
  echo " | ";
  echo "<a href='chapter.php?id=".$_COOKIE["last_read_chapter"]."'>Продолжить читать</a>";
}
?>
<!-- Кнопка для добавления глав, доступная только администраторам -->
<?php if ($isAdmin): ?>
    <a href="add_chapter.php">Добавить главу</a>
<?php endif; ?>
<?php
// Получаем список глав из базы данных
$sql = "SELECT * FROM chapters";
$result = mysqli_query($link, $sql);

if ($result->num_rows > 0) {
    // выводим данные каждой строки
    while($row = $result->fetch_assoc()) {
      echo "<div><a href='chapter.php?id=".$row["id"]."'>".$row["title"]."</a><br></div>";
    }
  } else {
    echo "0 results";
  }

// Закрываем соединение
mysqli_close($link);
?>
</div>
</div>
<!-- Footer -->
<footer>
  <p>Телефон: +7 (708) 379-31-01</p>
  <p>Email: sharuevvv@gmail.com</p>
  <p>Адрес: г. Алматы, ул. Жандосова 65</p>
</footer>
<script src="modal.js"></script>
</body>
</html>
