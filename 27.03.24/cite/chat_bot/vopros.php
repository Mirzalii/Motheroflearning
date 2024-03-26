<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение запроса от пользователя
    $userQuestion = $_POST['question'];

    // Запуск Python скрипта с передачей вопроса
    $command = escapeshellcmd("python3 vop_otv.py '" . $userQuestion . "'");
    $output = shell_exec($command);

    // Отображение ответа пользователю
    echo $output;
}
?>
