import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import sys
import logging

# Настройка логирования
logging.basicConfig(level=logging.INFO, filename='email_log.log')

# Аргументы командной строки
receiver_email = sys.argv[1]
subject = sys.argv[2]
body = sys.argv[3]

try:
    # Настройки учетной записи и сервера
    smtp_server = 'smtp.yandex.ru'
    port = 465
    sender_email = 'moflpass@yandex.ru'  # Замените на ваш реальный адрес
    password = 'dqoqcoolzzrrgnnc'  # Замените на ваш реальный пароль

    # Создание сообщения
    message = MIMEMultipart()
    message['From'] = sender_email
    message['To'] = receiver_email
    message['Subject'] = subject

    # Тело сообщения
    message.attach(MIMEText(body, 'plain'))

    # Подключение к серверу и отправка сообщения
    server = smtplib.SMTP_SSL(smtp_server, port)
    server.login(sender_email, password)
    text = message.as_string()
    server.sendmail(sender_email, receiver_email, text)
    server.quit()
    logging.info('Письмо успешно отправлено на адрес: %s', receiver_email)
except Exception as e:
    logging.error('Ошибка при отправке письма: %s', str(e))

