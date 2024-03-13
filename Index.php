<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mother of Learning</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/1css/slider.css">

    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="index.php"><img src="logo.png" alt="MoFL Logo"></a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Главная</a></li>
                <li><a href="chapters.php">Начать читать</a></li>
                <li><a href="wiki.php">Wiki</a></li>
                <li><a href="fan_arts.php">Фан арты</a></li>
            </ul>
            
            <!-- Навигационная панель с кнопкой "Войти" -->
<nav>
    <ul class="nav-links">
        <li><a id="loginBtn" href="#">Войти</a></li>
    </ul>
</nav>

<!-- Плавающее модальное окно для входа и регистрации -->
<!-- Плавающее модальное окно для входа и регистрации -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="login.php" method="post">
            <div id="loginForm" class="login-form">
                <h2>Вход</h2>
                <input type="text" name="username" placeholder="Имя пользователя" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit">Войти</button>
                <p class="register-link">Нет аккаунта? <a id="registerLink" href="#">Зарегистрируйтесь</a></p>
            </div>
        </form>
        <form action="register.php" method="post">
            <div id="registerForm" class="register-form">
                <h2>Регистрация</h2>
                <input type="text" name="username" placeholder="Имя пользователя" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit">Зарегистрироваться</button>
            </div>
        </form>
    </div>
</div>


            

            </div>
            
        </nav>
    </header>

    <main>
        <div class="slider-container">
            <div class="slider">
                <img src="img/slide1.jpg" alt="Slide 1" class="slide">
                <img src="img/slide2.jpg" alt="Slide 2" class="slide">
                <img src="img/slide3.jpg" alt="Slide 3" class="slide">
                <!-- Добавьте другие изображения по аналогии -->
            </div>
            <button class="prev" onclick="prevSlide()">&#10094;</button>
            <button class="next" onclick="nextSlide()">&#10095;</button>
        </div>
        

          <div class="title-container">
            <h1 class="title">Mother of Learning</h1>
        </div>

        <div class="description">
            <p>
                Зориан — юный маг скромного происхождения, обладающий навыками чуть выше среднего.
            </p>
                Студент третьего года обучения в магической академии Сиории.
                <p>
                Он целеустремлённый, но раздражительный молодой человек, охваченный желанием обеспечить свое собственное будущее и освободиться от влияния своей семьи, которую он недолюбливает за то, что она предпочитает его братьям.
                Следовательно, у него нет времени на бессмысленные развлечения или внимание к чужим проблемам.
                Так уж вышло, что времени у него будет предостаточно.
            </p>
                Накануне ежегодного летнего фестиваля в Сиории его убивают и возвращают в начало месяца, как раз перед тем, как он собирался сесть на поезд в Сиорию.
                <p>
                Внезапно оказавшись в ловушке временной петли без четкого конца или выхода, Зориану придётся заглянуть как внутрь, так и вовне, чтобы разгадать тайну перед ним.
            </p>
                Он вынужден разгадать ее, ибо временная петля не была сделана ради него, а опасности таятся повсюду…
                <p>
                Повторение — мать учения, но Зориану сначала нужно убедиться, что он выживет, чтобы попытаться снова — в мире магии даже путешественник во времени не застрахован от тех, кто желает ему зла.
            </p>
        </div>
        
        <div class="button-container">
            <button class="read-button">Начать читать</button>
          </div>

<script src="script.js"></script>

</body>
</html>
