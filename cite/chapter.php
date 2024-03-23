<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mofl";
// Начинаем сессию
session_start();

// Создаем соединение
$conn = new mysqli($servername, $username, $password, $dbname);
// Проверяем соединение
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

// Подготавливаем SQL запрос
$stmt = $conn->prepare("SELECT title, content FROM Chapters WHERE id=?");
$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // Сохраняем id текущей главы в cookies
  setcookie("last_read_chapter", $id, time() + (86400 * 30), "/"); // 86400 = 1 day

// Проверяем, вошел ли пользователь в систему
$loggedIn = isset($_SESSION['username']);

// Если пользователь вошел в систему, получаем его роль
// Если пользователь вошел в систему, получаем его роль и фотографию профиля
if ($loggedIn) {
    // Получаем имя пользователя из сессии
    $username = $_SESSION['username'];

    // Получаем роль и фотографию профиля пользователя из базы данных
    $sql = "SELECT role, profile_pic FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
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
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/chapter.css">
 
</head>
<body>
<!-- Навигационная панель -->
<nav id="navbar">
<a href="index.html" id="logo">Mother of Learning</a>
    <div id="menu">
       <a href="index.php">Главная страница</a>
      <a href="read.php">Список глав</a>
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




<div class="chapter">
<div class="chapter-content">
<?php



// Подготавливаем SQL запрос
$stmt = $conn->prepare("SELECT title, content FROM Chapters WHERE id=?");
$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // выводим данные каждой строки
  while($row = $result->fetch_assoc()) {
    echo "<h1>".$row["title"]."</h1>";
    echo "<p class='chapter-text'>".$row["content"]."</p>";
  }
} else {
    echo "0 results";
  }
  
  // Кнопки для перехода к предыдущей и следующей главе
  if ($id > 1) {
    echo "<a href='chapter.php?id=".($id-1)."'>Предыдущая глава</a>";
  }
  echo " | ";
  echo "<a href='chapter.php?id=".($id+1)."'>Следующая глава</a>";
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
