<?php
// Функция для логирования
function logMessage($message) {
    file_put_contents('reset_log.txt', date('Y-m-d H:i:s') . ": " . $message . "\n", FILE_APPEND);
}

// Подключение к базе данных
$host = 'localhost';
$dbname = 'mofl';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Не удалось подключиться к базе данных: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_code']) && isset($_POST['email'])) {
    $reset_code = $_POST['reset_code'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND reset_code = :reset_code");
    $stmt->execute(['email' => $email, 'reset_code' => $reset_code]);
    $user = $stmt->fetch();

    if ($user) {
        header("Location: change_password.php?email=" . urlencode($email));
        exit;
    } else {
        logMessage("Неверный код восстановления для email: {$email} - код: {$reset_code}");
        echo "Неверный код восстановления.";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ввод кода восстановления</title>
</head>
<body>
    <h2>Введите код восстановления</h2>
    <form action="verify_code.php" method="post">
        <?php
        session_start();
        $email = isset($_SESSION['email_for_reset']) ? $_SESSION['email_for_reset'] : '';
        echo '<input type="hidden" name="email" value="' . htmlspecialchars($email) . '">';
        ?>
        <label for="reset_code">Код восстановления:</label>
        <input type="text" id="reset_code" name="reset_code" required>
        <button type="submit">Подтвердить код</button>
    </form>
</body>
</html>
