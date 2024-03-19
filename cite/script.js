// JavaScript
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("slide");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  slides[slideIndex-1].style.display = "block";
}

document.getElementById('imageSlider').addEventListener('click', function(e) {
  let rect = e.target.getBoundingClientRect();
  let x = e.clientX - rect.left;
  if (x < rect.width / 2) {
    // Левая половина слайда
    plusSlides(-1);
  } else {
    // Правая половина слайда
    plusSlides(1);
  }
});



// JavaScript
// Получение модального окна
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

document.addEventListener('DOMContentLoaded', function() {
  var userProfileButton = document.getElementById('userProfileButton');
  var userProfileModal = document.getElementById('userProfileModal');

  if (userProfileButton) {
    userProfileButton.addEventListener('click', function() {
      userProfileModal.style.display = 'block';
    });
  }

  // Код для закрытия модального окна
  // ...
});

