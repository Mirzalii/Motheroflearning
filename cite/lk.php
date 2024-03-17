<?php
session_start();

// Подключение к базе данных
$host = 'localhost';
$db = 'mofl';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Получение данных пользователя
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, email, profile_pic FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Здесь может быть код для обработки изменений в профиле пользователя


// Обработка запроса на изменение имени пользователя
if (isset($_POST['new_username'])) {
  $new_username = $_POST['new_username'];
  $update_query = "UPDATE users SET username = ? WHERE id = ?";
  $update_stmt = $conn->prepare($update_query);
  $update_stmt->bind_param('si', $new_username, $user_id);
  $update_stmt->execute();

}

// Обработка запроса на изменение email
if (isset($_POST['new_email'])) {
  $new_email = $_POST['new_email'];
  $update_query = "UPDATE users SET email = ? WHERE id = ?";
  $update_stmt = $conn->prepare($update_query);
  $update_stmt->bind_param('si', $new_email, $user_id);
  $update_stmt->execute();

}

// Обработка запроса на изменение пароля
if (isset($_POST['new_password'])) {
  $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Хеширование пароля
  $update_query = "UPDATE users SET password = ? WHERE id = ?";
  $update_stmt = $conn->prepare($update_query);
  $update_stmt->bind_param('si', $new_password, $user_id);
  $update_stmt->execute();
}

// Обработка запроса на изменение фото профиля
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
  $profile_pic_path = 'path/to/uploads/' . basename($_FILES['profile_pic']['name']);
  if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic_path)) {
    $update_query = "UPDATE users SET profile_pic = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('si', $profile_pic_path, $user_id);
    $update_stmt->execute();

  }
}

// Обработка запроса на выход из аккаунта
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: index.php');
  exit;
}

// Перенаправление на lk.php после обработки запроса
header('Location: lk.php');
exit;
?>



<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title>Личный кабинет</title>
<style>
  .container {
    width: 50%;
    margin: auto;
    text-align: center;
  }
  .profile-pic {
    display: inline-block;
    margin-top: 20px;
    position: relative;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }
  .profile-pic::after {
    content: '✏️';
    position: absolute;
    bottom: 0;
    right: 0;
    background-color: white;
    border-radius: 50%;
    padding: 5px;
    cursor: pointer;
  }
  .user-info {
    margin-top: 20px;
  }
  .user-info div {
    margin-bottom: 10px;
  }
  .edit-icon {
    display: inline-block;
    margin-left: 10px;
    cursor: pointer;
  }
  .hidden-password {
    display: inline-block;
    width: 120px;
    background-color: #eaeaea;
    border-radius: 5px;
    padding: 5px;
  }
  .button {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
  }
</style>
</head>
<body>

<div class="container">
  <h1>Личный кабинет</h1>
  <div class="profile-pic" style="background-image: url('<?php echo $profilePic ?? 'img/slide1.jpg'; ?>');"></div>
  
  <!-- Форма для загрузки фотографии профиля -->
  <form action="lk.php" method="post" enctype="multipart/form-data">
    <label for="profile_pic">Фото профиля:</label>
    <input type="file" id="profile_pic" name="profile_pic">
    <input type="submit" value="Загрузить">
  </form>
  
  <div class="user-info">
    <div>Имя пользователя: <?php echo htmlspecialchars($username); ?><span class="edit-icon">✏️</span></div>
    <div>Электронная почта: <?php echo htmlspecialchars($email); ?><span class="edit-icon">✏️</span></div>
    <div>Пароль: <span class="hidden-password">••••••••</span><span class="edit-icon">✏️</span></div>
  </div>
  <a href="logout.php" class="button">Выйти из аккаунта</a>
  <a href="index.php" class="button">Главное меню</a>
</div>

</body>
</html>
