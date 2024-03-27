<?php
// Подключаем файл конфигурации из папки logic
require_once 'logic/config.php';


// Начинаем сессию
session_start();

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

// Проверяем, отправлена ли форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Подготавливаем SQL-запрос
    $sql = "INSERT INTO chapters (title, content) VALUES (?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Привязываем переменные к подготовленному запросу в качестве параметров
        mysqli_stmt_bind_param($stmt, "ss", $param_title, $param_content);

        // Устанавливаем параметры
        $param_title = $title;
        $param_content = $content;

        // Пытаемся выполнить подготовленный запрос
        if (mysqli_stmt_execute($stmt)) {
            // Глава успешно добавлена, перенаправляем на страницу чтения
            header("location: read.php");
            exit();
        } else {
            echo "Что-то пошло не так. Пожалуйста, попробуйте еще раз позже.";
        }
    }

    // Закрываем запрос
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить главу</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/add_chapter.css">
</head>
<body>
<!-- Навигационная панель -->
<nav id="navbar">
<a href="index.php" id="logo">Mother of Learning</a>
<div id="menu">
    <div id="gl">
      <a href="index.php">Главная страница</a>
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
        <img src="<?php echo $profilePic; ?>" alt="Profile Picture" style="width: 100%; height: auto; border-radius: 50%;">
      </div>
      <span id="username" style="margin-left: 10px;"><?php echo htmlspecialchars($username); ?></span>
    </a>
  <?php else: ?>
  <?php endif; ?>
  </div>
</nav> 
<!-- блок длбавления глав -->
<div class="add-chapter">  
<div class="add-chapter-content">
            <h2>Добавить главу</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label for="title">Название главы</label>
                    <input type="text" name="title" id="title" required>
                </div>
                <div>
                    <label for="content">Содержание главы</label>
                    <textarea  type="content" name="content" id="content" required></textarea>
                </div>
                <div>
                    <input type="submit" value="Добавить главу">
                </div>
            </form>
    </div>
    </div>
</body>

</html>


