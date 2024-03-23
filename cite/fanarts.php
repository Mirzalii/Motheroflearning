

<?php
session_start();
require_once 'config.php';
require_once 'database.php';
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
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Главная страница</title>
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="css/fanarts.css">
</head>
<body>
<!-- Навигационная панель -->
<nav id="navbar">
    <a href="index.html" id="logo">Mother of Learning</a>
    <div id="menu">
       <a href="index.php">Главная страница</a>
      <a href="read.php">Начать читать</a>
    </div>
    <div id="auth">
    <?php if ($loggedIn): ?>
    <a href="profile.php" id="userProfileLink">
      <div id="profilePicContainer" >
        <img src="<?php echo $profilePic ?? 'img/slide1.jfif'; ?>" alt="Profile Picture" >
      </div>
      <span id="username" style="margin-left: 10px;"><?php echo htmlspecialchars($username); ?></span>
    </a>
  <?php else: ?>
    <button id="loginBtn">Войти</button>
<button id="registerBtn">Зарегистрироваться</button>
  <?php endif; ?>
  </div>
</nav>

<!-- Модальное окно -->
<div id="myModal" class="modal">
      <!-- Контент модального окна -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <form action="upload.php" method="post" enctype="multipart/form-data">
          <input type="file" name="fileToUpload" id="fileToUpload">
          <input type="submit" value="Загрузить Изображение" name="submit">
        </form>
      </div>
    </div>

<!-- Модальное окно входа -->
<div id="loginModal" class="modal">
  <div class="modal-content">

    <h2>Вход</h2>
    <!-- Форма входа -->
    <form id="loginForm" method="post" action="login.php">
    <p> <label for="loginUsername">Имя пользователя:</label></p> 
      <input type="text" id="loginUsername" name="username" required>
      <p><label for="loginPassword">Пароль:</label></p>
      <input type="password" id="loginPassword" name="password" required>
      <input type="submit" value="Войти">
    </form>
  </div>
</div>

<!-- Модальное окно регистрации -->
<div id="registerModal" class="modal">
  <div class="modal-content">

    <h2>Регистрация</h2>
    <!-- Форма регистрации -->
    <form id="registerForm" method="post" action="register.php">
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





<!-- Блок с фан артами -->

<div id="fanArtBlock">
  <h2 class="fanArtTitle">Фан Арты</h2>
  

  <?php if ($loggedIn): ?>
    <!-- Кнопка для открытия модального окна доступна только авторизированным пользователям -->
    <button id="myBtn">Добавить</button>
    
  <?php else: ?>
    <p>Для добавления изображений необходимо войти.</p>
  <?php endif; ?>
  <div class="fanArtImages">
  <?php
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

// SQL-запрос для выбора 8 случайных изображений
$sql = "SELECT img FROM fanarts ORDER BY RAND() LIMIT 100";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Вывод каждого изображения
    while($row = $result->fetch_assoc()) {
        echo '<img src="' . $row["img"] . '" ">';
    }
} else {
    echo "Изображений нет.";
}
$conn->close();
?>

  </div>
</div>





<!-- Footer -->
<footer>
  <p>Телефон: +7 (708) 379-31-01</p>
  <p>Email: sharuevvv@gmail.com</p>
  <p>Адрес: г. Алматы, ул. Жандосова 65</p>
</footer>

<script>

var modal = document.getElementById("myModal");


// Получение кнопок, которые открывают модальные окна
var btn = document.getElementById("myBtn");

// Открытие модального окна при нажатии на кнопку
btn.onclick = function() {
  modal.style.display = "block";
}


// Закрытие модального окна при нажатии вне его области
modal.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = 'none';
  }
}

</script>
<script src="script.js"></script>



</body>
</html>
