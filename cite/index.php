

<?php
session_start();
require_once 'config.php';
require_once 'database.php';

// Проверяем, есть ли информация о вошедшем пользователе
if (isset($_SESSION['username'])) {
    // Пользователь вошел в систему
    $loggedIn = true;
    $username = $_SESSION['username'];
} else {
    // Пользователь не вошел в систему
    $loggedIn = false;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Главная страница</title>
<link rel="stylesheet" href="styles.css">


</head>
<body>

<!-- Навигационная панель -->
<nav id="navbar">
    <a href="index.html" id="logo"><img src="logo.png" alt="Логотип"></a>
    <div id="menu">
      <a href="#read">Начать читать</a>
      <a href="#wiki">Wiki</a>
      <a href="#fanart">Фан арты</a>
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





















  


<!-- HTML -->
<div id="imageSlider" class="slider">
      <img src="img/slide1.png" alt="Slide 1" class="slide">
      <img src="img/slide1.jfif" alt="Slide 2" class="slide">
      <img src="img/slide2.jfif" alt="Slide 3" class="slide">
      <img src="img/slayder1.jpg" alt="Slide 4" class="slide">
      <img src="img/slayder1.jpg" alt="Slide 5" class="slide">
      <img src="img/fon3.jpg" alt="Slide 6" class="slide">
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
      <a href="read.html" class="readButton">Начать читать</a>
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
<!-- HTML -->
<div id="fanArtBlock">
  <h2 class="fanArtTitle">Фан Арты</h2>
  <div class="fanArtImages">
    <img src="img/fanart.jpg" alt="Фан арт 1" class="fanArtImage">
    <img src="img/fanart.jpg" alt="Фан арт 2" class="fanArtImage">
    <img src="img/fanart.jpg" alt="Фан арт 3" class="fanArtImage">
    <img src="img/fanart.jpg" alt="Фан арт 4" class="fanArtImage">
    <img src="img/fanart.jpg" alt="Фан арт 5" class="fanArtImage">
    <img src="img/fanart.jpg" alt="Фан арт 6" class="fanArtImage">
    <img src="img/fanart.jpg" alt="Фан арт 7" class="fanArtImage">
    <img src="img/fanart.jpg" alt="Фан арт 8" class="fanArtImage">
  </div>
  <a href="#moreFanArts" class="moreButton">Ещё ▼</a>
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









// Получение модальных окон
var loginModal = document.getElementById('loginModal');
var registerModal = document.getElementById('registerModal');

// Получение кнопок, которые открывают модальные окна
var loginBtn = document.getElementById('loginBtn');
var registerBtn = document.getElementById('registerBtn');



// Открытие модального окна входа
loginBtn.onclick = function() {
  loginModal.style.display = 'block';
}

// Открытие модального окна регистрации
registerBtn.onclick = function() {
  registerModal.style.display = 'block';
}

// Закрытие модального окна при нажатии вне его области
window.onclick = function(event) {
  if (event.target == registerModal) {
    loginModal.style.display = 'none';
    registerModal.style.display = 'none';
  }
}

// Закрытие модального окна при нажатии вне его области
window.onclick = function(event) {
  if (event.target == loginModal || event.target == registerModal) {
    loginModal.style.display = 'none';
    registerModal.style.display = 'none';
  }
}
</script>
</body>
</html>
