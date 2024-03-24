<?php
// Включаем строгий режим типов
declare(strict_types=1);

// Подключение к базе данных
$host = 'localhost';
$db   = 'mofl';
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

// Обработка запроса на отправку кода восстановления пароля
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $code = random_int(100000, 999999);

    // Обновление кода сброса в базе данных
    $stmt = $pdo->prepare("UPDATE users SET reset_code = ? WHERE email = ?");
    $stmt->execute([$code, $email]);

    // Отправка письма
    $smtp_server = 'smtp.yandex.ru';
    $port = 465;
    $sender_email = 'sharuevvv@yandex.ru';
    $password = 'tduypdvauzsewxna'; // Укажите ваш пароль

    $subject = 'Код восстановления пароля';
    $message = "Ваш код восстановления пароля: $code";

    // Настройки для отправки письма
    $headers = array(
        'From' => $sender_email,
        'Reply-To' => $sender_email,
        'X-Mailer' => 'PHP/' . phpversion()
    );

    // Безопасное соединение с SMTP сервером
    $context = stream_context_create([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ],
    ]);

    // Отправка письма
    mail($email, $subject, $message, $headers, "-f$sender_email");

    echo json_encode(["message" => "Код восстановления пароля был отправлен на вашу электронную почту!"]);
}

// Обработка запроса на сброс пароля
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'], $_POST['new_password'])) {
    $code = $_POST['code'];
    $new_password = $_POST['new_password'];

    // Проверка кода и обновление пароля
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_code = ?");
    $stmt->execute([$code]);
    $user = $stmt->fetch();

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE reset_code = ?");
        $stmt->execute([$new_password, $code]);
        echo json_encode(["message" => "Ваш пароль был успешно обновлен!"]);
    } else {
        echo json_encode(["message" => "Неверный код восстановления пароля!"]);
    }
}
?>
