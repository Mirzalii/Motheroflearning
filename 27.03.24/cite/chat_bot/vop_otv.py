import sys
import sqlite3

# Подключение к базе данных
conn = sqlite3.connect('path/to/your_database.db')
cursor = conn.cursor()

# Получение вопроса от PHP скрипта
question = sys.argv[1]

# Поиск в базе данных по ключевым словам
cursor.execute("SELECT description FROM characters WHERE name LIKE ?", ('%' + question + '%',))
row = cursor.fetchone()

# Вывод ответа
if row:
    print(row[0])
else:
    print("Информация не найдена.")

# Закрытие соединения с базой данных
conn.close()
