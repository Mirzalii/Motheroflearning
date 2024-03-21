

// Получение модальных окон
var loginModal = document.getElementById('loginModal');
var registerModal = document.getElementById('registerModal');

// Получение кнопок, которые открывают модальные окна
var loginBtn = document.getElementById('loginBtn');
var registerBtn = document.getElementById('registerBtn');

// Получение элементов <span> (x), которые закрывают модальные окна
var closeBtns = document.getElementsByClassName('close');

// Открытие модального окна входа
loginBtn.onclick = function() {
  loginModal.style.display = 'block';
}

// Открытие модального окна регистрации
registerBtn.onclick = function() {
  registerModal.style.display = 'block';
}

// Закрытие модального окна при нажатии на (x)
for (var i = 0; i < closeBtns.length; i++) {
  closeBtns[i].onclick = function() {
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

