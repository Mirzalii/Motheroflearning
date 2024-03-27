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
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Главная страница</title>
<link rel="stylesheet" href="css/mainpage.css">
<link rel="stylesheet" href="css/main.css">
</head>
<body>
<!-- Навигационная панель -->
<nav id="navbar">
<a href="index.php" id="logo">Mother of Learning</a>
<div id="menu">
    <div id="gl">
      <a href="read.php">Начать читать</a>
      <a href="fanarts.php">Фан арты</a>
     <?php if ($loggedIn): ?>
    <!-- Кнопка для открытия модального окна доступна только авторизированным пользователям -->
    <a href="forumpage.php">Форум</a>
  <?php else: ?>
  <?php endif; ?>
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
<!-- HTML -->
<div id="imageSlider" class="slider">
      <img src="img/slide1.png" alt="Slide 1" class="slide">
      <img src="img/slide22.png" alt="Slide 2" class="slide">
      <!-- <img src="img/slide3.png" alt="Slide 3" class="slide">
      <img src="img/slayder1.jpg" alt="Slide 4" class="slide">
      <img src="img/slayder1.jpg" alt="Slide 5" class="slide">
      <img src="img/fon3.jpg" alt="Slide 6" class="slide"> -->
    <a class="prev" onclick="moveSlide(-1)">❮</a>
    <a class="next" onclick="moveSlide(1)">❯</a>
  </div>
  <!-- HTML -->
<div id="titleContainer">
    <h1 id="mainTitle"><p class="mol">Mother of Learning</p></h1>
  </div>
<!-- Блок с описанием ранобэ -->
<div id="descriptionBlock">
    <div class="coverImage">
      <img src="img/ranobe.jpg" alt="Обложка ранобэ">
      <a href="read.php" class="readButton">Начать читать</a>
      <ul class="ranobeInfo">
        <li><p>Тип: Английский</p></li>
        <li><p>Год релиза: 2011</p></li>
        <li><p>Статус тайтла: Завершён</p></li>
        <li><p>Статус перевода: Завершен</p></li>
        <li><p>Автор: nobody103</p></li>
        <li><p>Загружено глав: 109</p></li>
      </ul>
    </div>
    <div class="descriptionContent">
      <h1 id="description">Мать Ученья</h1>
    <p>
        Зориан — юный маг скромного происхождения, обладающий навыками чуть выше среднего.
    </p>
    <p>
        Студент третьего года обучения в магической академии Сиории.
    </p>
    <p>
        Он целеустремлённый, но раздражительный молодой человек, охваченный желанием обеспечить свое собственное будущее и освободиться от влияния своей семьи, которую он недолюбливает за то, что она предпочитает его братьям.
    </p>
    <p>
        Следовательно, у него нет времени на бессмысленные развлечения или внимание к чужим проблемам.
    </p>
    <p>
        Так уж вышло, что времени у него будет предостаточно.
    </p>
    <p>
        Накануне ежегодного летнего фестиваля в Сиории его убивают и возвращают в начало месяца, как раз перед тем, как он собирался сесть на поезд в Сиорию.
    </p>
    <p>
        Внезапно оказавшись в ловушке временной петли без четкого конца или выхода, Зориану придётся заглянуть как внутрь, так и вовне, чтобы разгадать тайну перед ним.
    </p>
    <p>
        Он вынужден разгадать ее, ибо временная петля не была сделана ради него, а опасности таятся повсюду…
    </p>
    <p>  
        Повторение — мать учения, но Зориану сначала нужно убедиться, что он выживет, чтобы попытаться снова — в мире магии даже путешественник во времени не застрахован от тех, кто желает ему зла.</p>
    </p>
  </div>
</div>
<!-- Блок с фан артами -->
<div id="fanArtBlock">
  <h2 class="fanArtTitle">Фан Арты</h2>
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
$sql = "SELECT img FROM fanarts ORDER BY RAND() LIMIT 8";
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
  <a href="fanarts.php" class="moreButton">Ещё ▼</a>
</div>
<!-- Footer -->
<footer>
  <p>Телефон: +7 (708) 379-31-01</p>
  <p>Email: sharuevvv@gmail.com</p>
  <p>Адрес: г. Алматы, ул. Жандосова 65</p>
</footer>
<script>

// JavaScript
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("slide");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  slides[slideIndex-1].style.display = "block";
}

document.getElementById('imageSlider').addEventListener('click', function(e) {
  let rect = e.target.getBoundingClientRect();
  let x = e.clientX - rect.left;
  if (x < rect.width / 2) {
    // Левая половина слайда
    plusSlides(-1);
  } else {
    // Правая половина слайда
    plusSlides(1);
  }
});
</script>
<script src="modal.js"></script>
</body>
</html>
