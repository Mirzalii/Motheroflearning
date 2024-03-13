//слайдер
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlides() {
    slideIndex++;
    if (slideIndex >= totalSlides) {
        slideIndex = 0;
    }
    updateSlideVisibility();
}

function updateSlideVisibility() {
    slides.forEach((slide, index) => {
        if (index === slideIndex) {
            slide.style.display = 'block';
        } else {
            slide.style.display = 'none';
        }
    });
}

function nextSlide() {
    slideIndex++;
    if (slideIndex >= totalSlides) {
        slideIndex = 0;
    }
    updateSlideVisibility();
}

function prevSlide() {
    slideIndex--;
    if (slideIndex < 0) {
        slideIndex = totalSlides - 1;
    }
    updateSlideVisibility();
}

// Автоматическое переключение слайдов каждые 5 секунд
setInterval(showSlides, 5000);

// регистрация и вход
// Получаем ссылки на модальное окно, кнопку "Войти", кнопку закрытия и ссылку "Зарегистрируйтесь"
// Получаем ссылки на модальное окно, кнопку "Войти", кнопку закрытия и ссылку "Зарегистрируйтесь"
var modal = document.getElementById("loginModal");
var loginBtn = document.getElementById("loginBtn");
var closeBtn = document.querySelector(".close");
var registerLink = document.getElementById("registerLink");
var loginForm = document.getElementById("loginForm");
var registerForm = document.getElementById("registerForm");

// При клике на кнопку "Войти" отображаем модальное окно с формой входа
loginBtn.onclick = function() {
    modal.style.display = "block";
    loginForm.style.display = "block";
    registerForm.style.display = "none";
}

// При клике на кнопку закрытия скрываем модальное окно
closeBtn.onclick = function() {
    modal.style.display = "none";
}

// При клике на ссылку "Зарегистрируйтесь" переключаем формы
registerLink.onclick = function() {
    loginForm.style.display = "none";
    registerForm.style.display = "block";
}
